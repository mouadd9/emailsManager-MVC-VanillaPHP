<?php

interface IEmailService {
    /**
     * Get all emails from the system
     * @return array List of all emails
     */
    public function getEmails(): array;

    /**
     * Add a new email to the system
     * @param string $email Email to add
     * @return array Result with success status and message
     */
    public function addEmail(string $email): array;

    /**
     * Validate all emails in the system and separate invalid ones
     * @return array {
     *   success: bool,
     *   message: string,
     *   data: ?array {
     *     valid: string[],
     *     invalid: string[]
     *   }
     * }
     */
    public function validateEmails(): array;

    /**
     * Get all invalid emails
     * @return array List of invalid emails
     */
    public function getInvalidEmails(): array;

    /**
     * Get all emails grouped by domain
     * @return array Associative array of domain => emails[]
     */
    public function getEmailsByDomain(): array;

    /**
     * Get all sorted emails from EmailsT.txt
     * @return array List of sorted emails
     */
    public function getSortedEmails(): array;

    /**
     * Calculate and return email frequencies
     * @return array Array of email => frequency pairs
     */
    public function getEmailFrequencies(): array;

    /**
     * Remove duplicate emails and update storage
     * @return array Result with success status and message
     */
    public function removeDuplicates(): array;

    /**
     * Sort emails and save to EmailsT.txt
     * @return array Result with success status and message
     */
    public function sortEmails(): array;

    /**
     * Separate emails by domain into separate files
     * @return array Result with success status and message
     */
    public function separateByDomain(): array;

    /**
     * Get list of non-existent domains
     * @return array List of non-existent domains and their emails
     */
    public function getNonExistentDomains(): array;
}
