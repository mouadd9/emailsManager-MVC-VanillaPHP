// Wait for page to load
document.addEventListener('DOMContentLoaded', function() {
    // Get our form element
    const emailFormElement = document.getElementById('emailForm');
    
    // Adding new email
    emailFormElement.addEventListener('submit', function(event) {
        // Prevent reloading the page
        event.preventDefault();
        
        // Get the email input value
        const emailInputElement = document.getElementById('email');
        const emailAddress = emailInputElement.value.trim();
        
        // Use URLSearchParams for proper URL-encoding
        const urlParams = new URLSearchParams();
        urlParams.append('action', 'addEmail');
        urlParams.append('email', emailAddress);
        
        sendRequest(urlParams, function(data) {
            displayMessage(data.message, data.success);
            // If email was successfully added, clear the input and update layout
            if (data.success) {
                emailInputElement.value = '';
                updateEmailTables(data);
            }
        });
    });
    
    // Generic function to handle all email management actions from our controller
    window.performAction = function(action) {
        const urlParams = new URLSearchParams();
        urlParams.append('action', action);
        
        sendRequest(urlParams, function(data) {
            displayMessage(data.message, data.success);
            if (data.success) {
                if (action === 'afficherFrequences' && data.data) {
                    // Display email frequencies
                    updateEmailFrequencies(data.data);
                } else if (data.html) {
                    // Update email tables from AJAX response
                    updateEmailTables(data);
                }
            }
        });
    };
    
    // Function to show messages to the user
    function displayMessage(message, isSuccess) {
        const resultAreaElement = document.getElementById('resultArea');
        const messageClass = isSuccess ? 'success' : 'error';
        resultAreaElement.innerHTML = `<div class="message ${messageClass}">${message}</div>`;
        resultAreaElement.style.display = 'block';
        
        // Hide message after 5 seconds
        setTimeout(function() {
            resultAreaElement.style.display = 'none';
        }, 5000);
    }
    
    // Function to update layout with new HTML received from controller
    function updateEmailTables(data) {
        if (data.html) {
            const emailListsElement = document.getElementById('emailLists');
            emailListsElement.style.opacity = '0.5';
            emailListsElement.innerHTML = data.html;
            emailListsElement.style.opacity = '1';
        }
    }

    // Function to update email frequencies
    function updateEmailFrequencies(frequencies) {
        const emailFrequenciesElement = document.getElementById('emailFrequencies');
        const frequencyListElement = document.getElementById('frequencyList');
        frequencyListElement.innerHTML = '';

        for (const [email, count] of Object.entries(frequencies)) {
            const listItem = document.createElement('li');
            listItem.textContent = `${email}: ${count} fois`;
            frequencyListElement.appendChild(listItem);
        }

        emailFrequenciesElement.style.display = 'block';
    }

    // Reusable function to send AJAX requests
    function sendRequest(urlParams, callback) {
        fetch('index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: urlParams.toString()
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(callback)
        .catch(error => {
            displayMessage('Une erreur est survenue: ' + error.message, false);
        });
    }
});