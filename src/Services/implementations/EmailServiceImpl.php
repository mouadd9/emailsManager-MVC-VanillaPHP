<?php

class EmailServiceImpl implements IEmailService {
    private $repository;

    public function __construct(IEmailRepository $repository) {
        $this->repository = $repository;
    }
    
    // ######################################### Get all emails from the system
    // ########################################################################
    public function getEmails(): array {
        return $this->repository->getAll();
    }
    
    // ######################################### Add a new email to the system
    // ########################################################################
    public function addEmail(string $email): array {
        // FILTER 1 (email validation)  
        if (!$this->isValidEmail($email)) {
            // EXCEPTION 1 (invalid email format)
            return [
                'success' => false,
                'message' => 'Invalid email format'
            ];
        }

        // FILTER 2 (email existence)
        if ($this->repository->exists($email)) {
            // EXCEPTION 2 (email already exists)
            return [
                'success' => false,
                'message' => 'Email already exists'
            ];
        }

        // OPERATION (email saving)
        if ($this->repository->save($email)) {
            return [
                'success' => true,
                'message' => 'Email added successfully'
            ];
        }

        return [
            'success' => false,
            'message' => 'Could not save email'
        ];


        // here we will throw an exception instead of doing this.
    }
    
    // ######################################### Validate all emails
    // ########################################################################
    public function validateEmails(): array {
        $allEmails = $this->repository->getAll();
        $validEmails = [];
        $invalidEmails = [];
        
        foreach ($allEmails as $email) {
            $email = trim($email); // Remove any whitespace
            if ($this->isValidEmail($email)) {
                $validEmails[] = $email;
            } else {
                $invalidEmails[] = $email;
            }
        }
        
        // Update valid emails
        if (!$this->repository->updateValidEmails($validEmails)) {
            return [
                'success' => false,
                'message' => 'Failed to update valid emails',
                'data' => null
            ];
        }
        
        // Save invalid emails
        if (!$this->repository->saveInvalidEmails($invalidEmails)) {
            return [
                'success' => false,
                'message' => 'Failed to save invalid emails',
                'data' => null
            ];
        }
        
        return [
            'success' => true,
            'message' => sprintf('Successfully validated emails: %d valid, %d invalid', 
                count($validEmails), 
                count($invalidEmails)
            ),
            'data' => [
                'valid' => $validEmails,
                'invalid' => $invalidEmails
            ]
        ];
    }
    
    private function isValidEmail(string $email): bool {
        // First, basic format check with filter_var
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Additional validation rules
        // 1. Check for consecutive dots
        if (strpos($email, '..') !== false) {
            return false;
        }

        // 2. Check for valid domain format
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return false;
        }

        $domain = $parts[1];
        // Check domain has at least one dot and proper TLD length
        if (substr_count($domain, '.') < 1 || 
            strlen(explode('.', $domain)[1]) < 2) {
            return false;
        }

        // 3. Check local part length (before @)
        if (strlen($parts[0]) > 64 || strlen($parts[0]) < 1) {
            return false;
        }

        // 4. Check for invalid characters in local part
        if (!preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+$/', $parts[0])) {
            return false;
        }

        return true;
    }

    // ######################################### Get invalid emails
    // ########################################################################
    public function getInvalidEmails(): array {
        return $this->repository->getInvalidEmails();
    }
    
    // ######################################### Get emails by domain
    // ########################################################################
    public function getEmailsByDomain(): array {
        return $this->repository->getEmailsByDomain();
    }

    // ######################################### Get sorted emails
    // ########################################################################
    public function getSortedEmails(): array {
        return $this->repository->getSortedEmails();
    }

    // ######################################### Get email frequencies
    // ########################################################################
    public function getEmailFrequencies(): array {
        $emails = $this->getEmails();
        $frequencies = array_count_values($emails);
        
        return [
            'success' => true,
            'message' => 'Email frequencies calculated',
            'data' => $frequencies
        ];
    }

    // ######################################### Remove duplicate emails
    // ########################################################################
    public function removeDuplicates(): array {
        $emails = $this->getEmails();
        $uniqueEmails = array_unique($emails);
        
        if ($this->repository->updateValidEmails($uniqueEmails)) {
            return [
                'success' => true,
                'message' => sprintf('Removed %d duplicate(s)', count($emails) - count($uniqueEmails))
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Failed to remove duplicates'
        ];
    }

    // ######################################### Sort emails
    // ########################################################################
    public function sortEmails(): array {
        $emails = $this->getEmails();
        sort($emails);
        
        if ($this->repository->saveSortedEmails($emails)) {
            return [
                'success' => true,
                'message' => 'Emails sorted and saved successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Failed to sort emails'
        ];
    }

    // ######################################### Separate emails by domain
    // ########################################################################
    public function separateByDomain(): array {
        $emails = $this->getEmails();
        $emailsByDomain = [];
        
        foreach ($emails as $email) {
            if (preg_match('/@(.+)$/', $email, $matches)) {
                $domain = $matches[1];
                $emailsByDomain[$domain][] = $email;
            }
        }
        
        if ($this->repository->saveDomainEmails($emailsByDomain)) {
            return [
                'success' => true,
                'message' => sprintf('Separated emails into %d domain(s)', count($emailsByDomain))
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Failed to separate emails by domain'
        ];
    }

    // ######################################### Get non-existent domains
    // ########################################################################
    public function getNonExistentDomains(): array {
        $emails = $this->getEmails();
        $nonExistentDomains = [];
        
        foreach ($emails as $email) {
            if (preg_match('/@(.+)$/', $email, $matches)) {
                $domain = $matches[1];
                if (!checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
                    if (!isset($nonExistentDomains[$domain])) {
                        $nonExistentDomains[$domain] = [];
                    }
                    $nonExistentDomains[$domain][] = $email;
                }
            }
        }
        
        return [
            'success' => true,
            'message' => 'Non-existent domains retrieved',
            'data' => $nonExistentDomains
        ];
    }
}
