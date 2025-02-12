<?php
// Hibernate v2 txt LOOOL !
class FileEmailRepositoryImpl implements IEmailRepository {
    private $filePath;

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
        $this->ensureStorageExists();
    }

    private function ensureStorageExists(): bool { // !!!
        $directory = dirname($this->filePath);
        if (!file_exists($directory)) {
            return mkdir($directory, 0777, true);
        }
        return true;
    }

    public function save(string $email): bool {
        return (bool)file_put_contents($this->filePath, $email . PHP_EOL, FILE_APPEND); // !!!
    }

    public function getAll(): array {
        if (!file_exists($this->filePath)) {
            return [];
        }
        return file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    }

    public function exists(string $email): bool {
        return in_array($email, $this->getAll());
    }

    public function getEmailsByDomain(): array {
        $domainsPath = dirname($this->filePath) . '/domains/';
        $result = [];
        
        // Read all domain files
        $files = glob($domainsPath . '*.txt');
        foreach ($files as $file) {
            $domain = basename($file, '.txt');
            $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
            $result[$domain] = $emails;
        }
        
        return $result;
    }

    public function getInvalidEmails(): array {
        $invalidEmailsPath = dirname($this->filePath) . '/adressesNonValides.txt';
        if (!file_exists($invalidEmailsPath)) {
            return [];
        }
        return file($invalidEmailsPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    }
}
