# Milestone 1: Basic MVC Setup and Template Rendering

## Current Implementation Flow
1. HTTP Request Flow:
   - User sends request to /public/
   - Web server (WAMP) identifies index.php as entry point
   - PHP begins executing index.php

2. Entry Point (index.php):
   - Sets up error reporting and basic configuration
   - Defines ROOT_PATH constant for file references
   - Creates instance of EmailController
   - Calls controller's index method

3. Controller Layer (EmailController):
   - Receives the request from index.php
   - Prepares data for the view
   - IMPORTANT: Does NOT redirect to template
   - Instead, INCLUDES template file and processes it immediately
   - The render() method processes template in place

4. Template Processing:
   - Template file (layout.php) contains mix of HTML and PHP
   - When included by render(), PHP processes it immediately
   - Output starts flowing to browser as it's processed
   - No "sending back" to controller - it's direct output

## Key Differences from API Architecture
1. No explicit return of template
2. No redirect to template
3. Direct processing and output of HTML
4. Template processing happens within render() method

## Next Steps
1. Implement Service Layer:
   - Create EmailService for business logic
   - Move data operations out of controller
   - Implement email validation logic

2. Create Repository Layer:
   - Implement file operations
   - Handle reading/writing to Emails.txt
   - Manage different output files

3. Enhance Template System:
   - Create partial templates for reuse
   - Implement form for email input
   - Add validation feedback display

4. Add Error Handling:
   - Create error templates
   - Implement proper error display
   - Add logging system

## Important Concepts Learned
1. PHP's direct output nature
2. Template inclusion vs redirection
3. Separation of concerns in MVC
4. PHP's mixing of HTML and code
5. The role of require_once in template system

Remember: In PHP MVC, templates are not "returned" or "redirected to" - they are processed and output directly when included by the render method.
