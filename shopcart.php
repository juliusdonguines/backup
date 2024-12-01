<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        /* Reset and basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Vertically and horizontally center */
            min-height: 100vh;
            text-align: center; /* Center text */
        }

        h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            justify-items: center;
            max-width: 1200px;
            width: 100%;
        }

        .product-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            text-align: center;
            padding: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .product-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
            display: block;  /* Ensures the image is displayed as a block element */
            margin-left: auto;  /* Centers the image horizontally */
            margin-right: auto;  /* Centers the image horizontally */
        }

        .product-card h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        .product-card p {
            font-size: 1.1rem;
            color: #777;
            margin-bottom: 15px;
        }

        .product-card button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-card button:hover {
            background-color: #0056b3;
        }

        .cart {
            background-color: #fff;
            width: 90%;
            max-width: 400px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .cart h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #333;
        }

        .cart ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cart ul li {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #555;
        }

        .cart p {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-top: 15px;
        }

        /* Back Button Styles */
        .Back {
            background-color: #f44336; /* Red color */
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .Back:hover {
            background-color: #d32f2f; /* Darker red on hover */
            transform: translateY(-2px);
        }

        /* Media Queries */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .product-card h2 {
                font-size: 1.3rem;
            }

            .product-card p {
                font-size: 1rem;
            }

            .cart {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <h1>Viewing Your Shopping Cart</h1>

    <div class="product-grid">
        <div class="product-card">
            <img src="euthaliaremove.png" class="product-image" alt="Shop 1">
            <h2>Shop 1</h2>
            <a href="addtocart.php"><button class="buy-now">View Cart</button></a>
        </div>
        <div class="product-card">
            <img src="Threeblooms.jpg" class="product-image" alt="Shop 2">
            <h2>Shop 2</h2>
            <a href="addtocart2.php"><button class="buy-now">View Cart</button></a>
        </div>
        <div class="product-card">
            <img src="welflowershop.jpg" class="product-image" alt="Shop 3">
            <h2>Shop 3</h2>
            <a href="addtocart3.php"><button class="buy-now">View Cart</button></a>
        </div>
        <div class="product-card">
            <img src="download.jpg" class="product-image" alt="Shop 4">
            <h2>Shop 4</h2>
            <a href="addtocart4.php"><button class="buy-now">View Cart</button></a>
        </div>
    </div>

    <a href="homepage.php"><button class="Back">Back</button></a>

</body>
</html>
