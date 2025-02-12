# Email Management System - File Structure

Email-Management/
├── src/                    # Source code directory
│   ├── Models/            # Data models
│   │   └── Email.php      # Email entity class
│   │
│   ├── Controllers/       # Request handlers
│   │   └── EmailController.php  # Handles all email-related requests
│   │
│   ├── Services/          # Business logic
│   │   ├── EmailValidationService.php  # Email validation logic
│   │   └── EmailManagementService.php  # Email operations (sort, filter, etc.)
│   │
│   ├── Repository/        # Data access layer
│   │   └── EmailFileRepository.php  # File operations for emails
│   │
│   ├── Utils/            # Utility classes
│   │   └── DomainExtractor.php  # Domain handling utilities
│   │
│   └── Views/            # Templates and presentation
│       ├── layout.php    # Main layout template
│       ├── form.php      # Email input form
│       └── list.php      # Email list display
│
├── public/               # Publicly accessible files
│   ├── index.php        # Entry point
│   ├── js/              # JavaScript files
│   │   ├── validation.js    # Client-side validation
│   │   └── main.js          # Main JavaScript functionality
│   │
│   └── css/             # Stylesheets
│       └── style.css    # Main stylesheet
│
├── config/              # Configuration files
│   └── config.php       # Application configuration
│
└── data/                # Data storage
    ├── Emails.txt           # Main emails storage
    ├── EmailsT.txt          # Sorted emails
    ├── adressesNonValides.txt  # Invalid emails
    └── domains/             # Domain-specific files

## File Descriptions

### Source Code (src/)
- **Models/Email.php**: Defines the Email class with properties and basic validation
- **Controllers/EmailController.php**: Handles HTTP requests and form submissions
- **Services/EmailValidationService.php**: Implements email validation logic
- **Services/EmailManagementService.php**: Implements email management operations
- **Repository/EmailFileRepository.php**: Handles all file I/O operations
- **Utils/DomainExtractor.php**: Handles domain extraction and grouping
- **Views/*.php**: Contains all HTML templates and forms

### Public (public/)
- **index.php**: Application entry point
- **js/validation.js**: Client-side email validation
- **js/main.js**: AJAX requests and UI interactions
- **css/style.css**: Page styling and layout

### Configuration (config/)
- **config.php**: Contains application settings and constants

### Data Storage (data/)
- **Emails.txt**: Main storage file for valid emails
- **EmailsT.txt**: Stores sorted email list
- **adressesNonValides.txt**: Stores invalid emails
- **domains/**: Directory for domain-specific email files

## Key Points
1. All business logic is in Services/
2. File operations are isolated in Repository/
3. Views are separated from logic
4. Public assets are isolated
5. Data files are separate from code