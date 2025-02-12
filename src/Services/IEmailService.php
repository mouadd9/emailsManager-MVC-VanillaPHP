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
}
