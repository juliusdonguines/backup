<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <link rel="stylesheet" href="terms_condition.css">
</head>
<body>
    <div class="container">
        <form class="form-container" action="seller.php" method="POST">
            <h1>Terms and Conditions</h1>
            
            <!-- Terms and Conditions Content -->
            <div class="terms-content">
                <p><strong>1. Acceptance of Terms</strong><br>
                By accessing and using this website, you accept and agree to be bound by these Terms and Conditions.</p>

                <p><strong>2. Use of the Website</strong><br>
                You agree to use this website only for lawful purposes.</p>

                <p><strong>3. Limitation of Liability</strong><br>
                We are not liable for any damages arising from your use of this website.</p>

                <p><strong>4. Privacy Policy</strong><br>
                We respect your privacy. Read our <a href="#">Privacy Policy</a> for more information.</p>

                <p><strong>5. Changes to Terms</strong><br>
                We reserve the right to change these terms at any time.</p>

                <p><strong>6. Governing Law</strong><br>
                These terms are governed by the laws of your country.</p>
            </div>

            <!-- Checkbox to accept terms -->
            <div class="acceptance">
                <label>
                    <input type="checkbox" id="acceptCheckbox" onclick="toggleButton()"> I agree to the <a href="#">Terms and Conditions</a>.
                </label>
            </div>

            <!-- Submit button -->
            <button type="submit" id="agreeButton" class="Agree" disabled>Agree</button>
        </form>
    </div>

    <script>
        function toggleButton() {
            const checkbox = document.getElementById('acceptCheckbox');
            const button = document.getElementById('agreeButton');
            button.disabled = !checkbox.checked; // Enable if checkbox is checked, disable otherwise
        }
    </script>
</body>
</html>
