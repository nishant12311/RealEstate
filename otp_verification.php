<?php
include("config.php");

if (isset($_POST['verify'])) {
    $email = $_POST['email'];
    $enteredOTP = $_POST['otp'];
    
    $query = "SELECT * FROM user WHERE uemail='$email'";
    $result = mysqli_query($con, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $storedOTP = $row['otp'];
        $otpExpiration = $row['otp_expiration'];
        
        if ($enteredOTP == $storedOTP && time() <= $otpExpiration) {
            // OTP is correct and not expired
            // Update user's account as activated, or perform necessary actions
            // You can also redirect the user to a success page
            echo "<p class='alert alert-success'>Account activated successfully!</p>";
        } else {
            $error = "<p class='alert alert-warning'>Invalid OTP or OTP expired.</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>User not found.</p>";
    }
}
?>

<!-- HTML form for OTP verification -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content here -->
</head>
<body>
    <div class="container">
        <h1>OTP Verification</h1>
        <?php echo isset($error) ? $error : ''; ?>
        <form method="post">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <div class="form-group">
                <label for="otp">Enter OTP:</label>
                <input type="text" class="form-control" name="otp" required>
            </div>
            <button type="submit" class="btn btn-primary" name="verify">Verify OTP</button>
        </form>
    </div>
</body>
</html>
