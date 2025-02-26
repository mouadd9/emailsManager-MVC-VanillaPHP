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

    /**
     * Get all emails grouped by domain
     * @return array Associative array of domain => emails[]
     */
    public function getEmailsByDomain(): array;

    /**
     * Get all invalid emails
     * @return array List of invalid emails
     */
    public function getInvalidEmails(): array;

    /**
     * Get all sorted emails from EmailsT.txt
     * @return array List of sorted emails
     */
    public function getSortedEmails(): array;

    /**
     * Update the main emails file with new content
     * @param array $emails New list of emails to save
     * @return bool Success status
     */
    public function updateValidEmails(array $emails): bool;

    /**
     * Save invalid emails to adressesNonValides.txt
     * @param array $emails List of invalid emails
     * @return bool Success status
     */
    public function saveInvalidEmails(array $emails): bool;

    /**
     * Save sorted emails to EmailsT.txt
     * @param array $emails Sorted list of emails
     * @return bool Success status
     */
    public function saveSortedEmails(array $emails): bool;

    /**
     * Save emails by domain into separate files
     * @param array $emailsByDomain Array of emails grouped by domain
     * @return bool Success status
     */
    public function saveDomainEmails(array $emailsByDomain): bool;
}
