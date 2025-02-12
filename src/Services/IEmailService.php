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
}
