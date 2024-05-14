<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Tech 008</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .navigation-menu {
            display: flex;
            justify-content: space-between;
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #0A3D62;
        }

        .nav-section {
            display: flex;
            align-items: center;
        }

        .nav-right-section {
            padding-right: 2%;
        }

        .nav-middle-section {
            flex-grow: 1;
            justify-content: center;
        }

        .nav-link, .brand-title, .search-form {
            display: block;
            color: white; /* Ensure all text is white */
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .nav-link a, .nav-link a:hover, .nav-link a:focus {
            color: white !important; /* Enforce white color in all states */
            background-color: transparent !important; /* Remove any background changes on hover/focus */
        }

        .search-form input[type="text"], .search-form input[type="submit"] {
            padding: 8px 15px;
            background: #fff;
            border: none;
            color: #0A3D62;
            border-radius: 20px;
        }

        .search-form input[type="text"] {
            width: 400px;
        }

        .search-form input[type="submit"] {
            cursor: pointer;
        }

        .nav-link:hover, .nav-link:focus {
            background-color: #1A5276; /* Subtle background change on hover */
            border-radius: 20px;
        }

        .active {
            border-bottom: 2px solid #fff;
        }
    </style>
</head>
<body>
<ul class="navigation-menu">
    <div class="nav-section nav-left-section">
        <li><h4 class="brand-title">Tech008</h4></li>
        <li class="nav-link <?= (current_url() == site_url('home/index')) ? 'active' : '' ?>"><a href="<?php echo site_url('home/index'); ?>">Home</a></li>
        <?php if($this->session->userdata('isUserLoggedIn')): ?>
            <li class="nav-link <?= (current_url() == site_url('questions/create')) ? 'active' : '' ?>"><a href="<?php echo site_url('questions/create'); ?>">Ask Question</a></li>
        <?php endif; ?>
    </div>
    <div class="nav-section nav-middle-section">
        <li class="nav-link <?= (current_url() == site_url('questions/search_questions')) ? 'active' : '' ?>">
            <form class="search-form" method="get" action="<?php echo site_url('questions/search_questions'); ?>">
                <input type="text" name="search" placeholder="Search For Questions">
                <input type="submit" value="Search">
            </form>
        </li>
    </div>
    <div class="nav-section nav-right-section">
        <?php if($this->session->userdata('isUserLoggedIn')): ?>
            <li class="nav-link" ><a href="<?php echo site_url('profile/index'); ?>"><?php echo $this->session->userdata('userName'); ?></a></li>
            <li class="nav-link"  ><a href="<?php echo site_url('users/logout'); ?>">Logout</a></li>
        <?php else: ?>
            <li class="nav-link <?= (current_url() == site_url('users/loadLogin')) ? 'active' : '' ?>"><a href="<?php echo site_url('users/loadLogin'); ?>">Login</a></li>
            <li class="nav-link <?= (current_url() == site_url('users/loadRegister')) ? 'active' : '' ?>"><a href="<?php echo site_url('users/loadRegister'); ?>">Signup</a></li>
        <?php endif; ?>
    </div>
</ul>
</body>
</html>
