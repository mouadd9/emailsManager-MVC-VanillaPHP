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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
}
