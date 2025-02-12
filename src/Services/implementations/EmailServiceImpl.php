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
}
