<?php
session_start();
include("include/ensureLogin.php");
$conn = mysqli_connect("localhost", "root", "", "wt");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$email = $_POST['tomail']['email'];
$isbn = $_POST['tomail']['isbn'];
$sql = "SELECT name FROM users WHERE email ='" . mysqli_real_escape_string($conn, $email) . "'";
$result = mysqli_query($conn, $sql);
$name = mysqli_fetch_array($result)['name'];
$sql = "SELECT * FROM books JOIN borrowed ON borrowed.isbn = books.isbn 
WHERE books.isbn ='" . $isbn . "'";
$result = mysqli_query($conn, $sql);
$book = mysqli_fetch_array($result);

$subject = "Uni LMS Warning";

$message = "
<html>

<head>
    <title>Warning</title>
</head>

<body style='color=black;text-align:center;'>
    <p>Dear " . $name . "</p>
    <p>You are late to return a borrowed book</p>
    <table style='min-width: 900px;text-align:center;'>
        <thead style='background-color: gray;
        border-bottom: black 2px solid;'>
            <th>Title</th>
            <th>Author</th>
            <th>Publisher</th>
            <th>Year</th>
            <th>ISBN</th>
            <th>Deadline</th>
        </thead>
        <tbody>
            <td>" . $book['title'] . "</td>
            <td>" . $book['author'] . "</td>
            <td>" . $book['publisher'] . "</td>
            <td>" . $book['year'] . "</td>
            <td>" . $book['isbn'] . "</td>
            <td>" . $book['deadline'] . "</td>
        </tbody>
    </table>

</body>

</html>
";



$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: admin@ULMS.com' . "\r\n";


if (mail($email, $subject, $message, $headers)) {
    echo '<script  type="text/javascript">
                     alert("Email sent successfully!");
                     window.location="profile.php"
                      </script>';
} else {
    echo '<script  type="text/javascript">
                     alert("Failed to send email!");
                     window.location="profile.php"
                      </script>';
}
