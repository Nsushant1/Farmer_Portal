// Form Validation JavaScript

// Email validation
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// Phone validation
function validatePhone(phone) {
    const regex = /^[0-9]{10}$/;
    return regex.test(phone);
}

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[$@#&!]+/)) strength++;
    
    return strength;
}

// Show error message
function showError(input, message) {
    const formGroup = input.parentElement;
    const errorDiv = formGroup.querySelector('.error-message') || document.createElement('span');
    
    input.classList.add('error');
    errorDiv.classList.add('error-message');
    errorDiv.textContent = message;
    
    if (!formGroup.querySelector('.error-message')) {
        formGroup.appendChild(errorDiv);
    }
}

// Clear error message
function clearError(input) {
    const formGroup = input.parentElement;
    const errorDiv = formGroup.querySelector('.error-message');
    
    input.classList.remove('error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Login form validation
if (document.getElementById('loginForm')) {
    const loginForm = document.getElementById('loginForm');
    
    loginForm.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Email validation
        const email = document.getElementById('email');
        if (!email.value.trim()) {
            showError(email, 'Email is required');
            isValid = false;
        } else if (!validateEmail(email.value)) {
            showError(email, 'Please enter a valid email');
            isValid = false;
        } else {
            clearError(email);
        }
        
        // Password validation
        const password = document.getElementById('password');
        if (!password.value) {
            showError(password, 'Password is required');
            isValid = false;
        } else {
            clearError(password);
        }
        
        if (!isValid) {
            e.preventDefault();
        } else {
            // Show loading state
            const submitBtn = loginForm.querySelector('button[type="submit"]');
            submitBtn.classList.add('loading');
            submitBtn.textContent = 'Logging in...';
        }
    });
}

// Registration form validation
if (document.getElementById('registerForm')) {
    const registerForm = document.getElementById('registerForm');
    const passwordInput = document.getElementById('password');
    
    // Password strength indicator
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            const strengthBar = document.querySelector('.password-strength-bar');
            
            if (strengthBar) {
                strengthBar.classList.remove('weak', 'medium', 'strong');
                
                if (strength <= 2) {
                    strengthBar.classList.add('weak');
                } else if (strength <= 4) {
                    strengthBar.classList.add('medium');
                } else {
                    strengthBar.classList.add('strong');
                }
            }
        });
    }
    
    registerForm.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Full name validation
        const fullName = document.getElementById('full_name');
        if (!fullName.value.trim()) {
            showError(fullName, 'Full name is required');
            isValid = false;
        } else if (fullName.value.trim().length < 3) {
            showError(fullName, 'Name must be at least 3 characters');
            isValid = false;
        } else {
            clearError(fullName);
        }
        
        // Email validation
        const email = document.getElementById('email');
        if (!email.value.trim()) {
            showError(email, 'Email is required');
            isValid = false;
        } else if (!validateEmail(email.value)) {
            showError(email, 'Please enter a valid email');
            isValid = false;
        } else {
            clearError(email);
        }
        
        // Phone validation
        const phone = document.getElementById('phone');
        if (phone.value && !validatePhone(phone.value)) {
            showError(phone, 'Please enter a valid 10-digit phone number');
            isValid = false;
        } else {
            clearError(phone);
        }
        
        // Password validation
        const password = document.getElementById('password');
        if (!password.value) {
            showError(password, 'Password is required');
            isValid = false;
        } else if (password.value.length < 6) {
            showError(password, 'Password must be at least 6 characters');
            isValid = false;
        } else {
            clearError(password);
        }
        
        // Confirm password validation
        const confirmPassword = document.getElementById('confirm_password');
        if (!confirmPassword.value) {
            showError(confirmPassword, 'Please confirm your password');
            isValid = false;
        } else if (confirmPassword.value !== password.value) {
            showError(confirmPassword, 'Passwords do not match');
            isValid = false;
        } else {
            clearError(confirmPassword);
        }
        
        if (!isValid) {
            e.preventDefault();
        } else {
            // Show loading state
            const submitBtn = registerForm.querySelector('button[type="submit"]');
            submitBtn.classList.add('loading');
            submitBtn.textContent = 'Creating Account...';
        }
    });
    
    // Clear errors on input
    const inputs = registerForm.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                clearError(this);
            }
        });
    });
}