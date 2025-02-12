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
}
