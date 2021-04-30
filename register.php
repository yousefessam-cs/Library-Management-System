<?php
session_start();
if(array_key_exists('type',$_SESSION)){
    header("Location: index.php");
}
?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title id="title">Sign up!</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="s1.css">
</head>

<body>
    <div id="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        This email or Username is already registered, please retry
    </div>
    <?php include("include/navbar.php");?>
    <form method="post" class="rForm">

        <div class="register">
            <div class="heading">
                <h2>Sign up</h2>

                <div>
                    <input type="text" id="name" name="name" class="box validinp textIn" maxlength="20" placeholder="Username" required pattern=".{5,}" title="Must contain 5-20 characters">
                </div>
                <div>
                    <input type="email" id="mail" name="email" class="box validinp textIn" maxlength="50" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Must contain some characters followed by an '@' then the domain name (for example: example@gmail.com)">
                </div>
                <div>
                    <input type="password" id="pw1" name="password" class="box validinp textIn" maxlength="50" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                </div>
                <div>
                    <input type="password" id="pw2" class="box validinp textIn" maxlength="50" required placeholder="Confirm Password">
                </div>

                <div class="selectDiv">
                    <select id="accType" name="accType" class="box textIn">
                        <option value="student">Student</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>

                <button type="submit" id="regBtn" class="box btn">Register</button>

                <p>Already have an account? <a href="login.php">Sign in</a></p>

            </div>
        </div>
    </form>
    <script src="validation.js" language="javascript"></script>
</body>

</html>
<?php
if ($_POST) {
    $conn = mysqli_connect("localhost", "root", "", "wt");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $type = $_POST['accType'];
    $sql = "SELECT * FROM users 
    WHERE email ='" . mysqli_real_escape_string($conn, $email) . "'";
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result)) {
        echo '<script  type="text/javascript">document.getElementById("alert").style.visibility = "visible"; </script>';
    } else {
        $sql = "INSERT INTO `users` (`name`, `email`, `password`, `type`) 
        VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $type . "')";
        if (mysqli_query($conn, $sql)) {

            header("Location: login.php");
        } else {
            echo '<script  type="text/javascript"> alert("Registration unexpectedly failed, please try again later!"); </script>';
        }
    }
}
?>