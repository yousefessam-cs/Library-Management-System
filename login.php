<?php
session_start();
if(array_key_exists('type',$_SESSION)){
    header("Location: index.php");
}
?>
<html>

<head>
    <title>Login</title>

    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="s1.css">
</head>

<body>


    <div id="alert1">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        This combination of username/email and pasword doesn't exist
    </div>
    <?php include("include/navbar.php");?>
    <form method="post" class="rForm">

        <div class="login">
            <div class="heading">
                <h2>Sign in</h2>
                <div>
                    <input type="text" id="name" name="name" class="box textIn" maxlength="50" placeholder="Username">
                </div>
                <div>
                    <input type="password" id="pw1" name="password" class="box textIn" maxlength="50" placeholder="Password">
                </div>
                <div>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <button type="submit" class="box btn">Login</button>

                <p>Need an account? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </form>
</body>

</html>


<?php
if ($_POST) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $conn = mysqli_connect("localhost", "root", "", "wt");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users 
    WHERE (email ='" . mysqli_real_escape_string($conn, $name) . "' 
    OR name ='" . mysqli_real_escape_string($conn, $name) . "') 
    AND password='" . mysqli_real_escape_string($conn, $password) . "'";
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result)) {
            if(isset($_POST['remember'])){
                setcookie('email',$row['email'], time() + 60 * 60 * 24 * 7);
                setcookie('name',$row['name'], time() + 60 * 60 * 24 * 7);
                setcookie('type',$row['type'], time() + 60 * 60 * 24 * 7);
            }
            $row = mysqli_fetch_array($result);
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['type'] = $row['type'];
            header("Location: index.php");
        } else {
            echo '<script  type="text/javascript">document.getElementById("alert1").style.visibility = "visible"; </script>';
        }
    }
}

?>