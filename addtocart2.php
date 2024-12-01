<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Store</title>
    <style>
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
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Adjusting the image styles to be responsive */
        .product-image {
            width: 100%;
            height: auto;
            object-fit: cover; /* Ensures the image covers the area without distortion */
            border-radius: 8px;
            margin-bottom: 25px;
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

        /* Checkout Button Styles */
        .Check-out {
            background-color: #28a745; /* Green color */
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .Check-out:hover {
            background-color: #218838; /* Darker green on hover */
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

        .cart ul li button {
            background-color: #dc3545; /* Red for remove button */
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
<a href="homepage.php" onclick="history.back()"><img src="IMG/chevron-left-regular-24.png"></a>
    <h1>Shop 2</h1>
    <a href="cart2.php"><button class="Back">Back</button></a>


    <div class="product-grid">
        <div class="product-card">
            <img class="product-image" src="flower.jpg" alt="Product 1">
            <h2>Product 1</h2>
            <p>Price: $10.00</p>
            <button onclick="addToCart('Product 1', 10.00)">Add to Cart</button>
        </div>
        <div class="product-card">
            <img class="product-image" src="flower2.jpg" alt="Product 2">
            <h2>Product 2</h2>
            <p>Price: $15.00</p>
            <button onclick="addToCart('Product 2', 15.00)">Add to Cart</button>
        </div>
        <div class="product-card">
            <img class="product-image" src="flower3.jpg" alt="Product 3">
            <h2>Product 3</h2>
            <p>Price: $20.00</p>
            <button onclick="addToCart('Product 3', 20.00)">Add to Cart</button>
        </div>

        <div class="product-card">
            <img class="product-image" src="flower4.jpg" alt="Product 4">
            <h2>Product 4</h2>
            <p>Price: $20.00</p>
            <button onclick="addToCart('Product 4', 20.00)">Add to Cart</button>
        </div>

        <div class="product-card">
            <img class="product-image" src="flower5.jpg" alt="Product 5">
            <h2>Product 5</h2>
            <p>Price: $25.00</p>
            <button onclick="addToCart('Product 5', 25.00)">Add to Cart</button>
        </div>

    </div>

    <div class="cart">
        <h2>Shopping Cart</h2>
        <ul id="cartItems"></ul>
        <p id="totalPrice">Total: $0.00</p>
        <a href="form.php"><button class="Check-out">Check out</button></a>
    </div>

    <script>
    let cart = JSON.parse(localStorage.getItem('cartShop2')) || []; // Load cart for Shop 2 from localStorage or initialize empty array
    let totalPrice = parseFloat(localStorage.getItem('totalPriceShop2')) || 0; // Load total price from localStorage or initialize as 0

    // Update the display on page load
    updateCartDisplay();

    function addToCart(name, price) {
        cart.push({ name, price });
        totalPrice += price;

        saveCartToLocalStorage(); // Save updated cart to localStorage
        updateCartDisplay();
    }

    function removeFromCart(index) {
        totalPrice -= cart[index].price; // Subtract price of removed item
        cart.splice(index, 1); // Remove item from array

        saveCartToLocalStorage(); // Save updated cart to localStorage
        updateCartDisplay();
    }

    function updateCartDisplay() {
        const cartItems = document.getElementById('cartItems');
        cartItems.innerHTML = ''; // Clear existing items

        cart.forEach((item, index) => {
            const li = document.createElement('li');
            li.innerHTML = `${item.name} - $${item.price.toFixed(2)} 
                <button onclick="removeFromCart(${index})">Remove</button>`;
            cartItems.appendChild(li);
        });

        const totalPriceEl = document.getElementById('totalPrice');
        totalPriceEl.textContent = `Total: $${totalPrice.toFixed(2)}`;
    }

    function saveCartToLocalStorage() {
        localStorage.setItem('cartShop2', JSON.stringify(cart)); // Save Shop 2 cart array to localStorage
        localStorage.setItem('totalPriceShop2', totalPrice.toString()); // Save Shop 2 total price to localStorage
    }
</script>


</body>
</html>
