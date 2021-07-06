/*
 *  Document   : op_auth_signup.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Sign Up Page
 */

class pageAuthSignUp {
    /*
     * Init Sign Up Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
     *
     */
    static initValidation() {
        // Load default options for jQuery Validation plugin
        Dashmix.helpers('validation');

        // Init Form Validation
        jQuery('.js-validation-signup').validate({
            rules: {
                'login': {
                    required: true,
                    minlength: 5,
                    matches: /\S+[a-zA-Z0-9]+/g
                },
                'firstname': {
                    required: true,
                },
                'lastname': {
                    required: true,
                },
                'email': {
                    required: true,
                    email: true
                },
                'password': {
                    required: true,
                    minlength: 5
                },
                'password-confirm': {
                    required: true,
                    equalTo: '#signup-password'
                },
            },
            messages: {
                'login': {
                    required: 'Please enter a login name',
                    minlength: 'Your username must consist of at least 3 characters',
                    matches: 'Not allowed to insert special character'
                },
                'firstname': {
                    required: "Please enter a first name",
                },
                'lastname': {
                    required: "Please enter a last name",
                },
                'email': 'Please enter a valid email address',
                'password': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long'
                },
                'confirm': {
                    required: 'Please provide a password',
                    minlength: 'Your password must be at least 5 characters long',
                    equalTo: 'Please enter the same password as above'
                },
            }
        });
    }

    /*
     * Init functionality
     *
     */
    static init() {
        this.initValidation();
    }
}

// Initialize when page loads
jQuery(() => {
    pageAuthSignUp.init();
});