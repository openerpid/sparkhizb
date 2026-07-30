<?php

namespace Sparkhizb\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;
use Throwable;
use ZipArchive;

class BackupAllDb extends BaseCommand
{
    /**
     * Grup command di Spark
     */
    protected $group = 'Database';

    /**
     * Nama perintah CLI
     */
    protected $name = 'sparkhizb:backupalldb';

    /**
     * Deskripsi perintah
     */
    protected $description = 'Mem-backup seluruh database yang terdaftar di konfigurasi CI4 dan mengompresnya ke format .zip';

    public function run(array $params)
    {
        CLI::write("===[ Memulai Proses Backup Database ]===", 'yellow');

        // Load konfigurasi database dari Config\Database
        $dbConfig = new Database();

        // Buat folder tujuan: writable/SparkhizbBackupDb/YYYY-MM-DD
        $dateFolder = date('Y-m-d');
        $targetDir  = WRITEPATH . 'SparkhizbBackupDb/' . $dateFolder;

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Ambil semua grup database yang dikonfigurasi (default, tests, dll)
        $groupList = array_keys(get_object_vars($dbConfig));

        foreach ($groupList as $groupName) {
            // Abaikan properti non-grup di class Database
            if (in_array($groupName, ['defaultGroup', 'override'], true)) {
                continue;
            }

            $config = $dbConfig->{$groupName} ?? null;

            if (! is_array($config) || empty($config['database'])) {
                continue;
            }

            CLI::write("\nMengecek grup database: [{$groupName}]...", 'cyan');

            $hostname = $config['hostname'] ?? '127.0.0.1';
            $username = $config['username'] ?? '';
            $password = $config['password'] ?? '';
            $database = $config['database'] ?? '';
            $port     = $config['port']     ?? 3306;

            // 1. Tes Koneksi Database
            if (! $this->testConnection($hostname, $username, $password, $database, (int)$port)) {
                CLI::error("Status: GAGAL Terhubung ke [{$database}] @ {$hostname}:{$port}. Dilewati.");
                continue;
            }

            CLI::write("Status: TERHUBUNG (Database: {$database})", 'green');

            // 2. Ekspor Database menggunakan 'mysqldump'
            $timeFormatted = date('Ymd_His');
            $sqlFilename   = "{$groupName}_{$database}_{$timeFormatted}.sql";
            $sqlPath       = $targetDir . DIRECTORY_SEPARATOR . $sqlFilename;

            $passParam = ! empty($password) ? "-p" . escapeshellarg($password) : "";

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
                CLI::error("Gagal melakukan dump untuk [{$database}]. Pastikan 'mysqldump' terpasang di server.");
                CLI::error("Output Error: " . implode("\n", $output));
                continue;
            }

            // 3. Kompres File .sql Menjadi .zip
            $zipFilename = "{$groupName}_{$database}_{$timeFormatted}.zip";
            $zipPath     = $targetDir . DIRECTORY_SEPARATOR . $zipFilename;

            if ($this->zipFile($sqlPath, $zipPath, $sqlFilename)) {
                // Hapus file .sql mentah setelah di-ZIP agar hemat ruang
                unlink($sqlPath);
                CLI::write("Berhasil di-backup & ZIP: {$zipFilename}", 'green');
            } else {
                CLI::error("Gagal mengompresi file ke format ZIP.");
            }
        }

        CLI::write("\n===[ Backup Selesai. Lokasi simpan: writable/SparkhizbBackupDb/{$dateFolder}/ ]===\n", 'green');
    }

    /**
     * Helper untuk menguji koneksi database secara cepat
     */
    private function testConnection(string $host, string $user, string $pass, string $db, int $port): bool
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
     * Helper untuk mengompresi file .sql ke .zip
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