// Our JavaScript code will go here

// Wait for page to load
document.addEventListener('DOMContentLoaded', function() {
    // Get our form element
    const emailForm = document.getElementById('emailForm');
    
    // ############################## adding new email 
    // ############################## adding new email 
    // ############################## adding new email 
    // ############################## adding new email 
    emailForm.addEventListener('submit', function(event) {
        // Prevent form from actually submitting (which would reload page)
        event.preventDefault();
        // Get the email input value
        const emailInput = document.getElementById('email');
        const email = emailInput.value.trim();
        // Send to server using fetch
        fetch('index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'action=addEmail&email=' + encodeURIComponent(email)
        }) // here we construct the HTTP request by defining its method, headers and body
        .then(response => response.json().then(data => {
            console.log("####################");
            console.log("Response:", data);
            console.log("####################");
            return data;
        }))
        /*
            {
                "success" : false | true,
                "message" : "Invalid action" | "Email already exists" | "Email added successfully"
            } 
        */
        .then(data => {
            // Show message to user
            showMessage(data.message, data.success);
            // Clear input if success
            if (data.success) {
                emailInput.value = '';
                
            }
        })
        .catch(error => {
            showMessage(error.message, false);
        });
    });
    
    // Function to show messages to user
    function showMessage(message, isSuccess) {
        const resultArea = document.getElementById('resultArea');
        const messageClass = isSuccess ? 'success' : 'error';
        resultArea.innerHTML = `<div class="message ${messageClass}">${message}</div>`;
        resultArea.style.display = 'block';
        
        // Hide message after 5 seconds
        setTimeout(function() {
            resultArea.style.display = 'none';
        }, 5000);
    }
});