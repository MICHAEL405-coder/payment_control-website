
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home Page</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: #87CEEB;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            flex-wrap: wrap;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            display: flex;
            align-items: center;
        }

        .navbar a i {
            margin-right: 8px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: #333;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #87CEEB;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .dropdown-content a i {
            margin-right: 8px;
        }

        .dropdown-content a:hover {
            background-color: #ADD8E6;
            color: #333;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            padding: 20px;
            text-align: center;
            flex: 1;
        }

        .footer {
            background-color: #87CEEB;
            color: white;
            text-align: center;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
        }

        .second-footer {
            background-color: #87CEEB;
            color: white;
            text-align: center;
            padding: 10px;
        }

        #animated-text {
            color: #0074d9;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
        }

        #coffee-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 20px;
        }

        .navbar .icon {
            display: none;
        }

        @media (max-width: 768px) {
            .navbar a, .navbar .dropdown {
                display: none;
            }
            
            .navbar a.icon {
                display: block;
                position: absolute;
                right: 0;
                top: 0;
                padding: 10px;
            }

            .navbar.responsive {
                position: relative;
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar.responsive a, .navbar.responsive .dropdown {
                display: block;
                text-align: left;
                padding: 10px;
            }

            .dropdown-content {
                position: relative;
            }

            .footer {
                flex-direction: column;
                height: auto;
                padding: 20px;
            }
        }

        .logout-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px 20px;
            float: right;
        }

        .logout-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
<div class="navbar" id="navbar">
    <a href="home.php"><i class="fa fa-home"></i>Home</a>
    <div class="dropdown">
        <button class="dropbtn"><i class="fa fa-coffee"></i>Coffee Data <i class="fa fa-caret-down"></i></button>
        <div class="dropdown-content">
            <a href="insert_data.php"><i class="fa fa-plus"></i>Insert Data</a>
            <a href="display.php"><i class="fa fa-eye"></i>Display Data</a>
        </div>
    </div>
    <div class="dropdown">
        <button class="dropbtn"><i class="fa fa-list"></i>Purchase List <i class="fa fa-caret-down"></i></button>
        <div class="dropdown-content">
            <a href="upload.php"><i class="fa fa-upload"></i>Upload Purchased Data</a>
            <a href="michael.php"><i class="fa fa-calculator"></i>Average Purchase Data</a>
        </div>
    </div>
    <a href="aboutus.php"><i class="fa fa-info-circle"></i>About Us</a>
    <a href="logout.php" class="logout-button">Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="toggleNavbar()">
        <i class="fa fa-bars"></i>
    </a>
</div>

<div class="container">
    <h1 id="animated-text"></h1>
    <img id="coffee-image" src="coffee.jpg" alt="Coffee Image">
</div>

<div class="footer">
    <p>Ethiopian coffee and tea authority.</p>
    <p>All Rights Reserved. Powered by <a href="https://www.google.com/search?q=deboengineeringc" target="_blank">Debo Engineering</a> Developer <a href="https://t.me/paradise2911" target="_blank">Michael</a>.</p>
</div>

<script>
    const animatedText = document.getElementById('animated-text');
    const phrase = "Welcome to coffee payment & purchase control system";
    let currentCharIndex = 0;

    function type() {
        if (currentCharIndex < phrase.length) {
            animatedText.textContent += phrase.charAt(currentCharIndex++);
            setTimeout(type, 100);
        }
    }

    function toggleNavbar() {
        const navbar = document.getElementById('navbar');
        if (navbar.className === 'navbar') {
            navbar.className += ' responsive';
        } else {
            navbar.className = 'navbar';
        }
    }

    // Start the typewriter effect
    type();
</script>
</body>
</html>
