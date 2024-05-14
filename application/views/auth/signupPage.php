<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body, html {
            background-color: #F5F5F5;
        }

        .signup-container {
            display: flex;
            width: 700px; /* Adjusted width to accommodate image and form */
            margin: auto;
            margin-top: 2%;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .image-panel {
            flex: 1;
            background: url('<?php echo base_url("assets/images/signup.png"); ?>') no-repeat center center; /* Example path, replace with actual */
            background-size: cover;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .form-panel {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .title {
            text-align: center;
        }

        .input-field {
            margin-bottom: 15px;
        }

        .input-field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input-field input[type="submit"] {
            background-color: #4681f4;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .input-field input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <!-- jQuery, Underscore, and Backbone included as before -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>
<body>
    <div class="signup-container">
        <div class="image-panel">
            <!-- Image set via CSS -->
        </div>
        <div class="form-panel">
            <h2 class="title">Register</h2>
            <div id="status-message" style="display: none; color: green;">Successfully Registered User!</div>
            <form id="signupForm">
                <div class="input-field">
                    <label for="input-first-name">First Name</label>
                    <input type="text" id="input-first-name" name="fName" placeholder="" required>
                </div>
                <div class="input-field">
                    <label for="input-last-name">Surname</label>
                    <input type="text" id="input-last-name" name="LName" placeholder="" required>
                </div>
                <div class="input-field">
                    <label for="input-email">Email</label>
                    <input type="email" id="input-email" name="email" placeholder="" required>
                </div>
                <div class="input-field">
                    <label for="input-password">Password</label>
                    <input type="password" id="input-password" name="password" placeholder="" required>
                </div>
                <div class="input-field">
                    <input type="submit" value="Register">
                </div>
                <p>Already have an account? <a href="<?php echo site_url('Users/loadLogin'); ?>">Login here</a></p>
            </form>
        </div>
    </div>

    <script>
    var UserModel = Backbone.Model.extend({
        defaults: {
            firstname: '',
            lastname: '',
            email: '',
            password: ''
        }
    });

    var UserView = Backbone.View.extend({
        el: "#signupForm",
        events: {
            'submit': 'registerUser'
        },

        initialize: function(){
            this.model = new UserModel();
        },

        registerUser: function(event){
            event.preventDefault();
            var firstname = this.$('#input-first-name').val();
            var lastname = this.$('#input-last-name').val();
            var email = this.$('#input-email').val();
            var password = this.$('#input-password').val();

            this.model.set({firstname: firstname, lastname: lastname, email: email, password: password});

            $.ajax({
                url: 'http://localhost/Tech008/index.php/Users/registration',
                type: 'POST',
                data: this.model.toJSON(),
                success: function(response) {
                    var msg = '';
                    var msgColor = '';
                    if (response.condition === 'A') {
                        msg = 'Username Already exists';
                        msgColor = 'red';
                    } else if (response.condition === 'B') {
                        msg = 'Successfully Registered';
                        msgColor = 'green';
                    } else {
                        msg = 'Unknown condition';
                        msgColor = 'black';
                    }
                    $('#status-message').text(msg).css('color', msgColor).show();
                    setTimeout(function() {
                        $('#status-message').hide();
                    }, 6000);
                },
                error: function(xhr, status, error) {
                    console.error('Error during registration:', error);
                }
            });
        }
    });

    var userView = new UserView();
    </script>
</body>
</html>
