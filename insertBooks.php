<?php
session_start();
include("include/ensureLogin.php");
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="s1.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title id="title">Add Book</title>
</head>

<body>


   <?php include("include/navbar.php");?>
    <div id="container">
        <div class="addBook">
            <form method="post">
                <table class="">
                    <tr>
                        <th colspan="2">Enter Book information to add to database</th>
                    </tr>

                    <tr>
                        <td> Enter ISBN :</td>
                        <td> <input type="text" name="book[isbn]" maxlength="20" required class="box textIn validinp" pattern="^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$" title="Please enter a valid isbn (10 or 13 digits with optional dashes'-' )!"> </td>
                    </tr>
                    <tr>
                        <td> Enter Title :</td>
                        <td> <input type="text" name="book[title]" maxlength="50" required class="box textIn validinp" pattern=".{3,}"> </td>
                    </tr>
                    <tr>
                        <td> Enter Author :</td>
                        <td> <input type="text" name="book[author]" maxlength="50" required class="box textIn validinp" pattern="\D{3,}" title="Please enter a valid name (Alphabetiacal only)!"> </td>
                    </tr>
                    <tr>
                        <td> Enter Publisher Year:</td>
                        <td> <input type="text" name="book[year]" maxlength="4" required class="box textIn validinp" pattern="\d{4}" title="Please enter a valid year!"> </td>
                    </tr>
                    <tr>
                        <td> Enter Publisher: </td>
                        <td> <input type="text" name="book[publisher]" maxlength="20" required class="box textIn validinp" pattern=".{4,}"> </td>
                    </tr>
                    <tr>

                        <td colspan="2">
                            <button type="submit" class="box btn">Add book</button>

                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <?php
        if ($_POST) {
            if (array_key_exists('book', $_POST)) {
                $conn = mysqli_connect("localhost", "root", "", "wt");
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                
                $isbn = $_POST['book']['isbn'];
                $title = $_POST['book']['title'];
                $author = $_POST['book']['author'];
                $year = $_POST['book']['year'];
                $publisher = $_POST['book']['publisher'];
                $sql = "SELECT * FROM books
        WHERE isbn = '" . mysqli_real_escape_string($conn, $isbn) . "'";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result)) {

                    echo '<script  type="text/javascript"> alert("ISBN is already registered in the database"); </script>';
                } else {
                    $sql = "INSERT INTO `books`(`isbn`, `title`, `author`, `year`, `publisher`) 
        VALUES ('" . mysqli_real_escape_string($conn, $isbn) . "','" . mysqli_real_escape_string($conn, $title) . "',
        '" . mysqli_real_escape_string($conn, $author) . "','" . intval($year) . "','" . mysqli_real_escape_string($conn, $publisher) . "')";
                    
                    if (mysqli_query($conn, $sql)) {

                        echo '<script  type="text/javascript"> alert("Book added succesfully"); </script>';
                        
                    } else {
                        echo '<script  type="text/javascript"> alert("Adding a book unexpectedly failed, please try again later!"); </script>';
                    }
                }
            }
        }
        ?>
    </div>
    <script src="ajax.js" language="javascript"></script>
</body>

</html>