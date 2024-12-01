<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="changepass.css">
</head>
<body>
    <div class="password-container">
        <h1>Change Password</h1>
        <form id="changePasswordForm">
            <div class="form-group">
            <label>Current Password:</label>
            <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Re-enter Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter new password" required>
            </div>
            <button type="submit" class="btn">Change Password</button>
        </form>
    </div>
    <script>
        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Replace this with the actual current password for validation (example: fetched from the server)
            const savedCurrentPassword = 'root'; 

            if (currentPassword !== savedCurrentPassword) {
                alert('Current password is incorrect.');
                return;
            }

            if (newPassword === confirmPassword) {
                alert('Password successfully changed!');
            } else {
                alert('New passwords do not match. Please try again.');
            }
        });
    </script>
</body>
</html>