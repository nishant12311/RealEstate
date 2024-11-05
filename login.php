<?php
session_start();
include("config.php");
$error = "";
$msg = "";

// Check if the user is already logged in
if (isset($_SESSION['uid'])) {
    header("location:index.php");
    exit();
}

// Check if the "Remember Me" checkbox is checked
if (isset($_POST['remember_me'])) {
    $remember_me = true;
} else {
    $remember_me = false;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass = sha1($pass);

    if (!empty($email) && !empty($pass)) {
        // Check if the user is verified
        $sql = "SELECT * FROM user WHERE uemail='$email' AND upass='$pass' AND is_verified='1'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        if ($row) {
            $_SESSION['uid'] = $row['uid'];
            $_SESSION['uemail'] = $email;

            // If "Remember Me" is checked, set cookies
            if ($remember_me) {
                setcookie("user_email", $email, time() + 3600 * 24 * 7, "/");
                setcookie("user_token", md5($email . $pass), time() + 3600 * 24 * 7, "/");
            }

            header("location:index.php");
        } else {
            $error = "<p class='alert alert-warning'>Email or Password does not match or your account is not verified.</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Please fill in all the fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta Tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

    <!-- CSS Links -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/layerslider.css">
    <link rel="stylesheet" type="text/css" href="css/color.css">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">

    <!-- Title -->
    <title>Real Estate PHP</title>

    <script>
        // Function to set the "Remember Me" checkbox state based on the stored cookies
        function setRememberMeCheckbox() {
            const userEmail = getCookie("user_email");
            if (userEmail) {
                document.getElementById("email").value = userEmail;
                document.getElementById("remember_me").checked = true;
            }
        }

        // Function to get a cookie by name
        function getCookie(name) {
            const value = "; " + document.cookie;
            const parts = value.split("; " + name + "=");
            if (parts.length === 2) return parts.pop().split(";").shift();
        }
    </script>
</head>

<body onload="setRememberMeCheckbox();">

<div id="page-wrapper">
    <div class="row"> 
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  -->

		<div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div>

    <div class="page-wrappers login-body full-row bg-gray">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Login</h1>
                            <p class="account-subtitle">Access to our dashboard</p>
                            <?php echo $error; ?><?php echo $msg; ?>
                            <!-- Form -->
                            <form method="post">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Your Email*">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="pass" class="form-control"
                                        placeholder="Your Password">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me"
                                        name="remember_me">
                                    <label class="form-check-label" for="remember_me">Remember Me</label>
                                </div>
                                <button class="btn btn-success" name="login" value="Login" type="submit">Login</button>
                            </form>

                            <div class="login-or">
                                <span class="or-line"></span>
                                <span class="span-or">or</span>
                            </div>

                            <!-- Social Login -->
                            <div class="social-login">
                                <span>Login with</span>
                                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="google"><i class="fab fa-google"></i></a>
                                <a href="#" class="facebook"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="google"><i class="fab fa-instagram"></i></a>
                            </div>
                            <!-- /Social Login -->

                            <div class="text-center dont-have">Don't have an account? <a href="register.php">Register</a></div>
                            <div class="text-center dont-have"><a href="register.php">Forget Password?</a></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--	Footer   start-->
<?php include("include/footer.php");?>
		<!--	Footer   start-->
    <!-- JavaScript Links -->
    <script src="js/jquery.min.js"></script>
    <!--jQuery Layer Slider -->
    <script src="js/greensock.js"></script>
    <script src="js/layerslider.transitions.js"></script>
    <script src="js/layerslider.kreaturamedia.jquery.js"></script>
    <!--jQuery Layer Slider -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/tmpl.js"></script>
    <script src="js/jquery.dependClass-0.1.js"></script>
    <script src="js/draggable-0.1.js"></script>
    <script src="js/jquery.slider.js"></script>
    <script src="js/wow.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>
