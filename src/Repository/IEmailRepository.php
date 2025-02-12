<?php

interface IEmailRepository {
    /**
     * Add a new email to storage
     * @return bool True if successful, false otherwise
     */
    public function save(string $email): bool;

    /**
     * Get all emails from storage
     * @return array List of emails
     */
    public function getAll(): array;

    /**
     * Check if email exists in storage
     * @return bool True if exists, false otherwise
     */
    public function exists(string $email): bool;
}
