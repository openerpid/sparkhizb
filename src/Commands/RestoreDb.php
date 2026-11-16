<?php

namespace Sparkhizb\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;
use ZipArchive;

class RestoreDb extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'sparkhizb:restoredb';
    protected $description = 'Memuat dan melakukan restore database dari folder backup (.zip) di writable/SparkhizbBackupDb/';

    public function run(array $params)
    {
        CLI::write("===[ Memulai Proses Restore Database ]===", 'yellow');

        // 1. Tanyakan tanggal folder backup yang ingin di-restore
        $defaultDate = date('Y-m-d');
        $targetDate  = CLI::prompt("Masukkan tanggal folder backup (YYYY-MM-DD):", $defaultDate);

        $backupDir = WRITEPATH . 'SparkhizbBackupDb/' . trim($targetDate);

        if (! is_dir($backupDir)) {
            CLI::error("Folder backup tidak ditemukan di: {$backupDir}");
            return;
        }

        // 2. Ambil semua file .zip di folder tersebut
        $zipFiles = glob($backupDir . DIRECTORY_SEPARATOR . '*.zip');

        if (empty($zipFiles)) {
            CLI::error("Tidak ditemukan file .zip di dalam folder {$backupDir}");
            return;
        }

        // 3. Baca konfigurasi database dari .env
        $envDatabases = $this->parseEnvDatabaseConfig();

        CLI::write("\nDitemukan " . count($zipFiles) . " file zip backup.", 'cyan');
        
        // Konfirmasi keamanan sebelum eksekusi
        $confirm = CLI::prompt("PERINGATAN: Restore akan menimpa data yang ada! Lanjutkan? (y/n)", ['y', 'n']);
        if (strtolower($confirm) !== 'y') {
            CLI::write("Proses restore dibatalkan.", 'gray');
            return;
        }

        // 4. Loop setiap file zip dan eksekusi restore
        foreach ($zipFiles as $zipPath) {
            $zipFilename = basename($zipPath);
            CLI::write("\nMemproses file: [{$zipFilename}]...", 'cyan');

            // Ekstrak nama grup dari nama file (Format: {group}_{database}_{timestamp}.zip)
            $parts = explode('_', $zipFilename);
            $group = $parts[0] ?? '';

            if (! isset($envDatabases[$group])) {
                CLI::error("Grup [{$group}] tidak ditemukan konfigurasi .env-nya. Dilewati.");
                continue;
            }

            $config   = $envDatabases[$group];
            $hostname = $config['hostname'] ?? '127.0.0.1';
            $username = $config['username'] ?? '';
            $password = $config['password'] ?? '';
            $database = $config['database'] ?? '';
            $port     = $config['port']     ?? 3306;

            // Ekstrak file ZIP
            $extractedSqlPath = $this->extractZip($zipPath, $backupDir);
            if (! $extractedSqlPath) {
                CLI::error("Gagal mengekstrak file ZIP: {$zipFilename}");
                continue;
            }

            // Pengecekan koneksi sebelum restore
            if (! $this->testConnection($hostname, $username, $password, $database, (int)$port)) {
                CLI::error("Gagal terhubung ke DB [{$database}] @ {$hostname}:{$port}. Restore dibatalkan untuk grup ini.");
                unlink($extractedSqlPath);
                continue;
            }

            // Perintah CLI untuk import SQL ke MySQL
            $passParam = ! empty($password) ? "-p" . escapeshellarg($password) : "";
            $cmd       = sprintf(
                'mysql -h %s -P %s -u %s %s %s < %s 2>&1',
                escapeshellarg($hostname),
                escapeshellarg($port),
                escapeshellarg($username),
                $passParam,
                escapeshellarg($database),
                escapeshellarg($extractedSqlPath)
            );

            exec($cmd, $output, $returnVar);

            // Hapus file .sql mentah setelah proses selesai
            if (file_exists($extractedSqlPath)) {
                unlink($extractedSqlPath);
            }

            if ($returnVar === 0) {
                CLI::write("BERHASIL Restore ke database: [{$database}]", 'green');
            } else {
                CLI::error("GAGAL Restore ke database [{$database}].");
                CLI::error("Output Error: " . implode("\n", $output));
            }
        }

        CLI::write("\n===[ Proses Restore Selesai ]===\n", 'green');
    }

    private function extractZip(string $zipPath, string $extractTo): ?string
    {
        $zip = new ZipArchive();
        if ($zip->open($zipPath) === true) {
            $sqlFilename = $zip->getNameIndex(0); // Ambil file pertama di dalam zip
            $zip->extractTo($extractTo);
            $zip->close();

            return $extractTo . DIRECTORY_SEPARATOR . $sqlFilename;
        }

        return null;
    }

    private function parseEnvDatabaseConfig(): array
    {
        $envFile = ROOTPATH . '.env';
        if (! file_exists($envFile)) {
            return [];
        }

        $lines     = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $databases = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                list($key, $value) = explode('=', $line, 2);
                $key   = trim($key);
                $value = trim($value, " \t\n\r\0\x0B'\"");

                if (str_starts_with($key, 'database.')) {
                    $parts = explode('.', $key);
                    if (count($parts) >= 3) {
                        $group    = $parts[1];
                        $property = $parts[2];

                        if ($group === 'backup') {
                            continue;
                        }

                        $databases[$group][$property] = $value;
                    }
                }
            }
        }

        return $databases;
    }

    private function testConnection($host, $user, $pass, $db, $port): bool
    {
        mysqli_report(MYSQLI_REPORT_OFF);
        try {
            $conn = @mysqli_connect($host, $user, $pass, $db, $port);
            if ($conn) {
                mysqli_close($conn);
                return true;
            }
        } catch (Throwable $e) {
            return false;
        }
        return false;
    }
}