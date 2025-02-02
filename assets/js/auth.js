import { ajaxRequest } from './ajaxHelper.js';

/**
 * Validate Email
 * @param {string} email - The email to validate.
 * @param {HTMLElement} feedbackDiv - The feedback container for validation messages.
 * @returns {Promise<boolean>} - Resolves to true if the email is valid and exists, false otherwise.
 */
export async function checkEmailExists(email, context,currentUserEmail=null) {
    try {
        // Send AJAX request to check if the email exists
        const data = await ajaxRequest({
            url: 'router.php?controller=auth&action=checkEmail',
            method: 'POST',
            data: { email },
        });

        // Handle responses based on context
        if (context === 'register') {
            if (data.exists) {
                return {
                    success: false,
                    message: 'Email already exists. Please log in instead.',
                };
            } else {
                return {
                    success: true,
                    message: 'Email is available for registration.',
                };
            }
        } else if (context === 'login'||context==='forgotPassword'||context==='resetPassword') {
            if (data.exists) {
                return {
                    success: true,
                    message: 'Email found. You can proceed.',
                };
            } else {
                return {
                    success: false,
                    message: 'No account found with this email. Please register.',
                };
            }
            
        }
        if (context === 'profile') {
            // Prevent unnecessary error when the user keeps their current email
            if (data.exists && email !== currentUserEmail) {
                return {
                    success: false,
                    message: 'Email found. Use another email to update.',
                };
            } else {
                return {
                    success: true,
                    message: 'Email is available for update.',
                };
            }
        }
        

        // Default case for unsupported context
        return {
            success: false,
            message: 'Invalid context provided.',
        };
    } catch (error) {
        console.error('Error in checkEmailExists:', error);
        return {
            success: false,
            message: 'An error occurred while checking the email. Please try again.',
        };
    }
}


export async function validateEmail(email, feedbackDiv, context,currentUserEmail=null) {
    
    if (!email) {
        feedbackDiv.innerText = 'Email cannot be empty.';
        feedbackDiv.className = 'text-danger mt-2';
        return false;
    }

    if (!validator.isEmail(email)) {
        feedbackDiv.innerText = 'Invalid email format.';
        feedbackDiv.className = 'text-danger mt-2';
        return false;
    }

    feedbackDiv.innerText = 'Valid email format. Checking availability...';
    feedbackDiv.className = 'text-info mt-2';

    // Call checkEmailExists with the context
    const result = await checkEmailExists(email, context,currentUserEmail);

    feedbackDiv.innerText = result.message;
    feedbackDiv.className = result.success ? 'text-success mt-2' : 'text-danger mt-2';

    return result.success;
}



/**
 * Handle Login Form Submission
 */
export function handleLogin() {
    const emailInput = document.getElementById('email');
    const emailFeedbackDiv = document.getElementById('email-feedback');

    // Real-time email validation
    emailInput.addEventListener('input', async function () {
        const email = emailInput.value;
      let  isEmailValid=await validateEmail(email, emailFeedbackDiv,"login"); // Perform validation as user types
        if (!isEmailValid) {
            return; // Stop submission if email validation fails
        }
    });

    // Form submission logic
    document.getElementById('login-form').addEventListener('submit', async function (event) {
        event.preventDefault(); // Prevent form submission

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const feedbackDiv = document.getElementById('login-feedback');

        // Perform final email validation during form submission
      
        try {
            // Perform AJAX login request
            const data = await ajaxRequest({
                url: 'router.php?controller=auth&action=authenticate',
                method: 'POST',
                data: { email, password },
            });

            if (data.success) {
                window.location.href = data.redirect; // Redirect on success
            } else {
                feedbackDiv.innerText = data.message || 'Invalid credentials. Please try again.';
                feedbackDiv.className = 'text-danger mt-2';
            }
        } catch (error) {
            console.error('Error in handleLogin:', error);
            feedbackDiv.innerText = 'An error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        }
    });
}
/** 
* Validate password
* @param {string} password - The email to validate.
* @param {HTMLElement} feedbackDiv - The feedback container for validation messages.
* @returns {Promise<boolean>} - Resolves to true if the email is valid and exists, false otherwise.
*/

export function validatePassword(password,feedbackDiv){
if(!password){
    feedbackDiv.innerText = 'Password cannot be empty.';
    feedbackDiv.className = 'text-danger mt-2';
    return false;
}
if (!validator.isLength(password, { min: 8 })) {
    feedbackDiv.innerText = 'Password must be at least 8 characters long.';
    feedbackDiv.className = 'text-danger mt-2';
} else if (!/[A-Z]/.test(password)) {
    feedbackDiv.innerText = 'Password must include at least one uppercase letter.';
    feedbackDiv.className = 'text-danger mt-2';
} else if (!/[a-z]/.test(password)) {
    feedbackDiv.innerText = 'Password must include at least one lowercase letter.';
    feedbackDiv.className = 'text-danger mt-2';
} else if (!/[0-9]/.test(password)) {
    feedbackDiv.innerText = 'Password must include at least one number.';
    feedbackDiv.className = 'text-danger mt-2';
} else if (!/[!@#$%^&*]/.test(password)) {
    feedbackDiv.innerText = 'Password must include at least one special character (!@#$%^&*).';
    feedbackDiv.className = 'text-danger mt-2';
} else {
    feedbackDiv.innerText = 'Strong password!';
    feedbackDiv.className = 'text-success mt-2';
    return true;
}
};
export function confirmPassword(password,confirmPassword,feedbackDiv){
    if(password!==confirmPassword){
        feedbackDiv.innerText = 'Passwords do not match.';
        feedbackDiv.className = 'text-danger mt-2';
        return false;
    }
    else{
    feedbackDiv.innerText = 'Passwords match!';
    feedbackDiv.className = 'text-success mt-2';
return true;
    }}
 export  async function checkPhoneExists(phone, context ) {
        try {
            // Send AJAX request to check if the email exists
            const data = await ajaxRequest({
                url: 'router.php?controller=auth&action=checkPhone',
                method: 'POST',
                data: { phone },
            });
            if(context==='register'){
            if(data.exists){
                return {
                    success: false,
                    message: 'Phone number already exists. Please log in instead.',
                };
            }
            else
            {
                return {
                    success: true,
                    message:data.message|| 'Phone number is available for registration.',
                };
            }
        }

        }catch (error) {
            console.error('Error in checkPhoneExists:', error);
            return {
                success: false,
                message: 'An error occurred while checking the phone. Please try again.',
            };
        }
    }

  export  async function validatePhone(phone, feedbackDiv, context ) {
    if (!phone) {
        feedbackDiv.innerText = 'Phone number cannot be empty.';
        feedbackDiv.className = 'text-danger mt-2';
        return false;
    }
  
    const parsedPhone = libphonenumber.parsePhoneNumberFromString(phone, 'BD');
    if (!parsedPhone || !parsedPhone.isValid()) {
        feedbackDiv.innerText = 'Invalid phone number format.';
        feedbackDiv.className = 'text-danger mt-2'; // Use 'text-danger' for error feedback
        return false;
    }
    if(context==='register'){
    
        feedbackDiv.innerText = 'Valid phone number format. Checking availability...';
        feedbackDiv.className = 'text-info mt-2'; // Use 'text-info' for neutral feedback
     const   $result= await checkPhoneExists(phone,context);
        feedbackDiv.innerText = $result.message;
        feedbackDiv.className = $result.success ? 'text-success mt-2' : 'text-danger mt-2';
        
        return $result.success;
    }

    
 
      
    
};
function toggleFields() {
    const role = document.getElementById('role').value; // Get selected role
    const lawyerFields = document.getElementById('lawyerFields'); // Get lawyer-specific fields

    // Show lawyer fields if role is "lawyer", otherwise hide them
    lawyerFields.style.display = (role === 'lawyer') ? 'block' : 'none';
}

    
export function handleRegister() {
    const emailInput = document.getElementById('email');
    const emailFeedbackDiv = document.getElementById('email-feedback');
    const passwordInput = document.getElementById('password');
    const passwordFeedbackDiv = document.getElementById('password-feedback');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const confirmPasswordFeedbackDiv = document.getElementById('confirm-password-feedback');
    const phoneInput = document.getElementById('phone');
    const phoneFeedbackDiv = document.getElementById('phone-feedback');
    let isEmailValid = false;
    let isPasswordValid = false;
    let isConfirmPasswordValid = false;
    let isPhoneValid = false;
    emailInput.addEventListener('input', function () {
        const email = emailInput.value;
        isEmailValid = validateEmail(email, emailFeedbackDiv,'register');
        if(!isEmailValid){
            return;
        }

       
    });
    passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;
        
    isPasswordValid = validatePassword(password, passwordFeedbackDiv);
    
    if(!isPasswordValid){
        return;
    }
   else{
    confirmPasswordInput.addEventListener('input', function () {
    isConfirmPasswordValid = confirmPassword(password,confirmPasswordInput.value,confirmPasswordFeedbackDiv);
    if(!isConfirmPasswordValid){
        return; 

   }
});

}});
    phoneInput.addEventListener('input', function () {
        const phone = phoneInput.value;
        isPhoneValid = validatePhone(phone, phoneFeedbackDiv,'register');
        if(!isPhoneValid){
            return;
        }
    });
    document.getElementById('register-form').addEventListener('submit', async function (event) {
        event.preventDefault(); // Prevent form submission initially
    
        // Get the latest values
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPasswordInput = document.getElementById('confirm-password').value;
        const phone = document.getElementById('phone').value;
    
        // Get feedback divs
        const emailFeedbackDiv = document.getElementById('email-feedback');
        const passwordFeedbackDiv = document.getElementById('password-feedback');
        const confirmPasswordFeedbackDiv = document.getElementById('confirm-password-feedback');
        const phoneFeedbackDiv = document.getElementById('phone-feedback');
        const feedbackDiv = document.getElementById('register-feedback');
    
        // Validate all fields one more time
        let isEmailValid = validateEmail(email, emailFeedbackDiv, 'register');
        let isPasswordValid = validatePassword(password, passwordFeedbackDiv);
        let isConfirmPasswordValid = confirmPassword(password, confirmPasswordInput, confirmPasswordFeedbackDiv);
        let isPhoneValid = validatePhone(phone, phoneFeedbackDiv, 'register');
    
        // If any validation fails, stop the form submission
        if (!isEmailValid || !isPasswordValid || !isConfirmPasswordValid || !isPhoneValid) {
            feedbackDiv.innerText = 'Please correct the errors before submitting.';
            feedbackDiv.className = 'text-danger mt-2';
            return;
        }
    
        // If all validations pass, proceed with the AJAX request
        const formElement = document.getElementById('register-form');
        const formData = new FormData(formElement);
    
        try {
            const data = await ajaxRequest({
                url: 'router.php?controller=auth&action=store',
                method: 'POST',
                data: formData,
            });
    
            if (data.success) {
                feedbackDiv.innerText = 'Registration successful. Redirecting...';
                feedbackDiv.className = 'text-success mt-2';
    
                setTimeout(() => {
                    window.location.href = data.redirect; // Redirect on success
                }, 2000);
            } else {
                feedbackDiv.innerText = data.message || 'Invalid credentials. Please try again.';
                feedbackDiv.className = 'text-danger mt-2';
            }
    
            console.log('Registration successful:', data);
        } catch (error) {
            console.error('Error in handleRegister:', error.message);
            feedbackDiv.innerText = 'An error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        }
    });
    
}
export async function handleForgotPassword() {
    const emailInput = document.getElementById('email');
    const emailFeedbackDiv = document.getElementById('email-feedback');
    let isEmailValid = false;

    emailInput.addEventListener('input', function () {
        const email = emailInput.value;
        isEmailValid = validateEmail(email, emailFeedbackDiv, 'forgotPassword');
    });

    document.getElementById('forgot-password-form').addEventListener('submit', async function (event) {
        event.preventDefault();

        const email = emailInput.value;
        const feedbackDiv = document.getElementById('forgot-password-feedback');

        if (!isEmailValid) {
            feedbackDiv.innerText = 'Please enter a valid email address.';
            feedbackDiv.className = 'text-danger mt-2';
            return;
        }

        try {
            const data = await ajaxRequest({
                url: 'router.php?controller=auth&action=processForgotPassword',
                method: 'POST',
                data: { email },
            });

            if (data.success) {
                feedbackDiv.innerHTML = `Reset link generated: <a href="${data.resetLink}" target="_blank">${data.resetLink}</a>`;
                feedbackDiv.className = 'text-success mt-2';
            } else {
                feedbackDiv.innerText = data.message || 'An error occurred. Please try again.';
                feedbackDiv.className = 'text-danger mt-2';
            }
        } catch (error) {
            console.error('Error in handleForgotPassword:', error);
            feedbackDiv.innerText = 'An error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        }
    });
}
export async function handleResetPassword() {
    // Get form elements
    const passwordInput = document.getElementById('password');
    const passwordFeedbackDiv = document.getElementById('password-feedback');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const confirmPasswordFeedbackDiv = document.getElementById('password-feedback');
    let isPasswordValid = false;
    let isConfirmPasswordValid = false;
   passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;
        isPasswordValid = validatePassword(password, passwordFeedbackDiv);
        if (!isPasswordValid) {
            return;
        }
    });
    confirmPasswordInput.addEventListener('input', function () {
        isConfirmPasswordValid = confirmPassword(passwordInput.value, confirmPasswordInput.value, confirmPasswordFeedbackDiv);
        if (!isConfirmPasswordValid) {
            return;
        }
    });
    document.getElementById('reset-password-form').addEventListener('submit', async function (event) {
        event.preventDefault();

        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const feedbackDiv = document.getElementById('reset-password-feedback');
        
        const formElement = document.getElementById('reset-password-form');
     

        if (!isPasswordValid || !isConfirmPasswordValid) {
            feedbackDiv.innerText = 'Please enter valid passwords.';
            feedbackDiv.className = 'text-danger mt-2';
            return;
        }

        try {
            const  formData=new FormData(formElement);
            const data = await ajaxRequest({
                url: 'router.php?controller=auth&action=processResetPassword',
                method: 'POST',
                data: formData,
            });

            if (data.success) {
                feedbackDiv.innerText = 'Password reset successfully.Redirecting';
                

                 setTimeout(() => {
                    window.location.href = 'router.php?controller=auth&action=login';
                }, 2000);

                
                feedbackDiv.className = 'text-success mt-2';
                
            } else {
                feedbackDiv.innerText = data.message || 'An error occurred. Please try again.';
                feedbackDiv.className = 'text-danger mt-2';
            }
           
        } catch (error) {
            console.error('Error in handleResetPassword:', error);
            feedbackDiv.innerText = 'An error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        }
    });
}
