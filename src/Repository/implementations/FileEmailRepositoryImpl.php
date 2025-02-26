<?php
// Hibernate v2 txt LOOOL !
class FileEmailRepositoryImpl implements IEmailRepository
{
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->ensureStorageExists();
    }

    private function ensureStorageExists(): bool
    {
        $directory = dirname($this->filePath);
        if (!file_exists($directory)) {
            return mkdir($directory, 0777, true);
        }
        return true;
    }

    public function save(string $email): bool
    {
        return (bool) file_put_contents($this->filePath, $email . PHP_EOL, FILE_APPEND); // !!!
    }

    public function getAll(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        return file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    }

    public function exists(string $email): bool
    {
        return in_array($email, $this->getAll());
    }

    public function getEmailsByDomain(): array
    {
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

    public function getInvalidEmails(): array
    {
        $invalidEmailsPath = dirname($this->filePath) . '/adressesNonValides.txt';
        if (!file_exists($invalidEmailsPath)) {
            return [];
        }
        $content = file_get_contents($invalidEmailsPath);
        if ($content === false) {
            return [];
        }
        return array_filter(explode(PHP_EOL, $content));
    }

    public function getSortedEmails(): array
    {
        $sortedEmailsPath = dirname($this->filePath) . '/EmailsT.txt';
        if (!file_exists($sortedEmailsPath)) {
            return [];
        }
        return file($sortedEmailsPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
    }

    public function updateValidEmails(array $emails): bool
    {
        return (bool) file_put_contents($this->filePath, implode(PHP_EOL, $emails));
    }

    public function saveInvalidEmails(array $emails): bool
    {
        $invalidEmailsPath = dirname($this->filePath) . '/adressesNonValides.txt';
        $content = implode(PHP_EOL, array_filter($emails));
        $result = file_put_contents($invalidEmailsPath, $content);
        return $result !== false;
    }

    public function saveSortedEmails(array $emails): bool
    {
        $sortedEmailsPath = dirname($this->filePath) . '/EmailsT.txt';
        return (bool) file_put_contents($sortedEmailsPath, implode(PHP_EOL, $emails));
    }

    public function saveDomainEmails(array $emailsByDomain): bool
    {
        $domainsPath = dirname($this->filePath) . '/domains/';
        if (!file_exists($domainsPath)) {
            mkdir($domainsPath, 0777, true);
        }

        $success = true;
        foreach ($emailsByDomain as $domain => $emails) {
            $domainFile = $domainsPath . $domain . '.txt';
            if (!file_put_contents($domainFile, implode(PHP_EOL, $emails))) {
                $success = false;
            }
        }
        return $success;
    }
}
