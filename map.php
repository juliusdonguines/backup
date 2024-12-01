<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map with Back Button</title>
    <style>
        /* Center the Back button */
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px; /* Adjust space from iframe */
        }

        /* Style for the Back button */
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff; /* Bootstrap blue color */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for the Back button */
        .button:hover {
            background-color: #0056b3; /* Darker blue */
        }
    </style>
</head>
<body>
    <p>
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m21!1m12!1m3!1d2399.724897377851!2d121.16314736102588!3d14.208693550202161!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m6!3e6!4m0!4m3!3m2!1d14.209065372082074!2d121.16313126777219!5e1!3m2!1sen!2sph!4v1732448237087!5m2!1sen!2sph" 
            width="1900" 
            height="850" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </p>
    <div class="button-container">
        <a href="homepage.php" class="button">Back</a>
    </div>
</body>
</html>
