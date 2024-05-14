<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body, html {
            background-color: #F5F5F5;
        }

        .auth-container {
            display: flex;
            width: 700px;
            margin: auto;
            margin-top: 5%;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .img-section {
            flex: 1;
            background: url('<?php echo base_url("assets/images/login.png"); ?>') no-repeat center center;
            background-size: cover;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .form-section {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .title {
            text-align: center;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input-group input[type="submit"] {
            background-color: #4681f4;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .input-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>
<body>
    <div class="auth-container">
        <div class="img-section">
            <!-- Image set in CSS -->
        </div>
        <div class="form-section">
            <h2 class="title">Login</h2>
            <div id="status-message" style="display: none; color: green;">Successfully Registered User!</div>
            <form id="authForm">
                <div class="input-group">
                    <label for="user-email">Email</label>
                    <input type="email" id="user-email" name="email" placeholder="" required>
                </div>
                <div class="input-group">
                    <label for="user-password">Password</label>
                    <input type="password" id="user-password" name="password" placeholder="" required>
                </div>
                <div class="input-group">
                    <input type="submit" value="Login">
                </div>
                <p>Don't have an account? <a href="<?php echo site_url('Users/loadRegister'); ?>">Register Now</a></p>
            </form>
        </div>
    </div>

    <script>
    var LoginModel = Backbone.Model.extend({
        defaults: {
            email: '',
            password: ''
        }
    });

    var LoginView = Backbone.View.extend({
        el: "#authForm",
        events: {
            'submit': 'authenticateUser'
        },

        initialize: function(){
            this.model = new LoginModel();
        },

        authenticateUser: function(event){
            event.preventDefault();
            var userEmail = this.$('#user-email').val();
            var userPassword = this.$('#user-password').val();

            this.model.set({email: userEmail, password: userPassword});

            $.ajax({
                url: 'http://localhost/Tech008/index.php/Users/login',
                type: 'POST',
                data: this.model.toJSON(),
                xhrFields: {
                    withCredentials: true
                },
                success: function(response) {
                    var msg = '';
                    var msgColor = '';
                    if (response.condition === 'A') {
                        msg = 'Successfully Logged in.';
                        msgColor = 'green';
                        window.location.href = 'http://localhost/Tech008/index.php/home';
                    } else if (response.condition === 'B') {
                        msg = 'Invalid Email or Password';
                        msgColor = 'red';
                    }
                    $('#status-message').text(msg).css('color', msgColor).show();
                    setTimeout(function() {
                        $('#status-message').hide();
                    }, 10000);
                },
                error: function(xhr, status, error) {
                    console.error('Error during authentication:', error);
                }
            });
        }
    });

    var loginView = new LoginView();
    </script>
</body>
</html>
