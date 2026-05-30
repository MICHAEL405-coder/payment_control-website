<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - CoffeeControl</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        .contact-section {
            margin-bottom: 30px;
        }
        .contact-section h2 {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            color: #333;
        }
        .contact-info {
            margin-bottom: 20px;
        }
        .contact-info p {
            margin: 5px 0;
        }
        .contact-form {
            display: flex;
            flex-direction: column;
        }
        .contact-form label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .contact-form input, 
        .contact-form textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
        }
        .contact-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .contact-form button:hover {
            background-color: #45a049;
        }
        body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    color: #333;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-image: url('bean.jpg'); /* Replace 'background.jpg' with your image file path */
        background-size: cover; /* Cover the entire background */
        background-position: center; /* Center the background image */
        background-attachment: fixed; /* Fixed background image */
        color: #333; /* Text color */
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>

        <div class="contact-section">
            <h2>Get in Touch</h2>
            <p>We'd love to hear from you! Whether you have a question about our services, need assistance, or just want to talk about coffee, we're here for you.</p>
        </div>

        <div class="contact-section">
            <h2>Contact Information</h2>
            <div class="contact-info">
                <p><strong>Email:</strong> michaelyilkal484@gmail.com</p>
                <p><strong>Phone:</strong> +251 1123-4567</p>
                <p><strong>Address:</strong>J.I.T Jimma City, ETHIOPIA</p>
            </div>
        </div>

        <div class="contact-section">
            <h2>Send Us a Message</h2>
            <form class="contact-form" action="contact_submit.php" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
</body>
</html>
