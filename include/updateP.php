<?php
$email = $_POST['newemail'];
$name = $_POST['newname'];
$password = $_POST['newpassword'];
$sql = "SELECT * FROM users 
    WHERE email ='" . mysqli_real_escape_string($conn, $email) . "'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) && mysqli_fetch_array($result)['email'] != $email) {
    echo '<script  type="text/javascript">
    document.getElementById("updateErr").style.color = "red";
    document.getElementById("updateErr").innerHTML = "Email already exists";
    
        </script>';
} else {
    $sql = "UPDATE users
        SET name='" . mysqli_real_escape_string($conn, $name) . "' ,
        email ='" . mysqli_real_escape_string($conn, $email) . "', 
        password='" . mysqli_real_escape_string($conn, $password) . "'
        WHERE email ='" . mysqli_real_escape_string($conn, $_SESSION['email']) . "'";
    if (mysqli_query($conn, $sql)) {

        $_SESSION['name']= $name;
        $_SESSION['email']= $email;
        header("Location: profile.php");
    } else {
        echo '<script  type="text/javascript"> alert("Updating unexpectedly failed, please try again later!"); </script>';
    }
}
?>