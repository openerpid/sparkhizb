<?php

namespace Sparkhizb\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;
use ZipArchive;

class BackupDb extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'sparkhizb:backupdb';
    protected $description = 'Mem-backup semua database terdaftar di .env dan mengompresnya ke writable/SparkhizbBackupDb/{tanggal}';

    public function run(array $params)
    {
        CLI::write("===[ Memulai Backup Database dari .env ]===", 'yellow');

        // 1. Parsing file .env secara manual agar mendeteksi SEMUA grup 'database.x.database'
        $envDatabases = $this->parseEnvDatabaseConfig();

        if (empty($envDatabases)) {
            CLI::error("Tidak ada konfigurasi database yang ditemukan di file .env!");
            return;
        }

        // 2. Buat folder penyimpanan: writable/SparkhizbBackupDb/YYYY-MM-DD
        $dateFolder = date('Y-m-d');
        $targetDir  = WRITEPATH . 'SparkhizbBackupDb/' . $dateFolder;

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // 3. Loop setiap grup database yang ditemukan di .env
        foreach ($envDatabases as $group => $config) {
            CLI::write("\nMengecek koneksi untuk grup: [{$group}]...", 'cyan');

            $hostname = $config['hostname'] ?? '127.0.0.1';
            $username = $config['username'] ?? '';
            $password = $config['password'] ?? '';
            $database = $config['database'] ?? '';
            $port     = $config['port']     ?? 3306;
            $driver   = $config['DBDriver'] ?? 'MySQLi';

            if (empty($database)) {
                CLI::write("Grup [{$group}] tidak memiliki nama database. Dilewati.", 'gray');
                continue;
            }

            // Pengecekan Koneksi Langsung lewat Native PDO/MySQLi (Akurat & Mendukung Port 1990)
            if (! $this->testConnection($hostname, $username, $password, $database, (int)$port)) {
                CLI::error("Status: GAGAL Terhubung ke [{$database}] @ {$hostname}:{$port}. Dilewati.");
                continue;
            }

            CLI::write("Status: SUCCESS (Database: {$database} @ {$hostname}:{$port})", 'green');

            // 4. Ekspor menggunakan mysqldump dengan Port Kustom (1990)
            $timeFormatted = date('Ymd_His');
            $sqlFilename   = "{$group}_{$database}_{$timeFormatted}.sql";
            $sqlPath       = $targetDir . DIRECTORY_SEPARATOR . $sqlFilename;

            $passParam = ! empty($password) ? "-p" . escapeshellarg($password) : "";
            
            // Perintah mysqldump dengan parameter -P (Port)
            $cmd = sprintf(
                'mysqldump -h %s -P %s -u %s %s %s > %s 2>&1',
                escapeshellarg($hostname),
                escapeshellarg($port),
                escapeshellarg($username),
                $passParam,
                escapeshellarg($database),
                escapeshellarg($sqlPath)
            );

            exec($cmd, $output, $returnVar);

            if ($returnVar !== 0) {
                CLI::error("Gagal dump database [{$database}]. Pastikan 'mysqldump' terpasang di OS.");
                CLI::error("Output Error: " . implode("\n", $output));
                continue;
            }

            // 5. Kompres file .sql menjadi .zip
            $zipFilename = "{$group}_{$database}_{$timeFormatted}.zip";
            $zipPath     = $targetDir . DIRECTORY_SEPARATOR . $zipFilename;

            if ($this->zipFile($sqlPath, $zipPath, $sqlFilename)) {
                unlink($sqlPath); // Hapus file SQL mentah setelah di-ZIP
                CLI::write("Berhasil di-backup & ZIP: {$zipFilename}", 'green');
            } else {
                CLI::error("Gagal mengompresi file ke ZIP untuk [{$group}].");
            }
        }

        CLI::write("\n===[ Backup Selesai. Lokasi simpan: writable/SparkhizbBackupDb/{$dateFolder} ]===\n", 'green');
    }

    /**
     * Membaca file .env secara langsung untuk mengekstrak grup database dinamis
     */
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
            // Abaikan komentar (#)
            if (str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                list($key, $value) = explode('=', $line, 2);
                $key   = trim($key);
                $value = trim($value, " \t\n\r\0\x0B'\"");

                // Cari baris yang diawali 'database.'
                if (str_starts_with($key, 'database.')) {
                    $parts = explode('.', $key);
                    if (count($parts) >= 3) {
                        $group    = $parts[1]; // misal: approval, siakad, vms
                        $property = $parts[2]; // misal: hostname, database, port

                        // Abaikan grup backup
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

    /**
     * Tes koneksi database langsung menggunakan mysqli native
     */
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

    /**
     * Helper Kompresi ZIP
     */
    private function zipFile(string $sourcePath, string $zipPath, string $filenameInZip): bool
    {
        if (! class_exists('ZipArchive')) {
            return false;
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $zip->addFile($sourcePath, $filenameInZip);
            $zip->close();
            return true;
        }

        return false;
    }
}