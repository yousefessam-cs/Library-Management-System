<?php
session_start();
include("include/ensureLogin.php");

if ($_POST) {

    $conn = mysqli_connect("localhost", "root", "", "wt");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (array_key_exists('submit', $_POST)) {

        $_SESSION['oldisbn'] = $_POST['submit'];
        $isbn = $_POST['submit'];

        $sql = "SELECT * FROM books
        WHERE isbn = '" . mysqli_real_escape_string($conn, $isbn) . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $author = $row['author'];
        $year = $row['year'];
        $publisher = $row['publisher'];
    }
    if (array_key_exists('newbook', $_POST)) {
        $isbn = $_POST['newbook']['isbn'];
        $sql = "SELECT * FROM books
            WHERE isbn = '" . mysqli_real_escape_string($conn, $isbn) . "'";

        $title = $_POST['newbook']['title'];
        $author = $_POST['newbook']['author'];
        $year = $_POST['newbook']['year'];
        $publisher = $_POST['newbook']['publisher'];
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) && mysqli_fetch_array($result)['isbn'] != $_SESSION['oldisbn']) {

            echo '<script  type="text/javascript"> alert("ISBN is already registered in the database"); </script>';
        } else {
            $sql = "UPDATE books
                SET isbn ='" . mysqli_real_escape_string($conn, $isbn) . "',
                title ='" . mysqli_real_escape_string($conn, $title) . "',
                author='" . mysqli_real_escape_string($conn, $author) . "',
                year='" . intval($year) . "',
                publisher='" . mysqli_real_escape_string($conn, $publisher) . "'
                WHERE isbn='" . $_SESSION['oldisbn'] . "'";
            
            if (mysqli_query($conn, $sql)) {

                unset($_SESSION['oldisbn']);
                echo '<script  type="text/javascript">
                 alert("Book updated succesfully");
                 window.location="index.php"
                  </script>';
                // header("Location: index.php");
            } else {
                echo '<script  type="text/javascript"> alert("Updating book unexpectedly failed, please try again later!"); </script>';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="s1.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title id="title">Home</title>
</head>

<body>


   <?php include("include/navbar.php");?>
    <div id="container">
        <div class="addBook">
            <form method="post">
                <table class="">
                    <tr>
                        <th colspan="2">Enter Book information to update to database</th>
                    </tr>

                    <tr>
                        <td> Enter ISBN :</td>
                        <td> <input type="text" name="newbook[isbn]" value="<?php echo $isbn; ?>" maxlength="20" required class="box textIn validinp" pattern="^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$" title="Please enter a valid isbn (10 or 13 digits with optional dashes'-' )!"> </td>
                    </tr>
                    <tr>
                        <td> Enter Title :</td>
                        <td> <input type="text" name="newbook[title]" value="<?php echo $title; ?>" maxlength="50" required class="box textIn validinp" pattern=".{3,}"> </td>
                    </tr>
                    <tr>
                        <td> Enter Author :</td>
                        <td> <input type="text" name="newbook[author]" value="<?php echo $author; ?>" maxlength="50" required class="box textIn validinp" pattern="\D{3,}" title="Please enter a valid name (Alphabetiacal only)!"> </td>
                    </tr>
                    <tr>
                        <td> Enter Publisher Year:</td>
                        <td> <input type="text" name="newbook[year]" value="<?php echo $year; ?>" maxlength="4" required class="box textIn validinp" pattern="\d{4}" title="Please enter a valid year!"> </td>
                    </tr>
                    <tr>
                        <td> Enter Publisher: </td>
                        <td> <input type="text" name="newbook[publisher]" value="<?php echo $publisher; ?>" maxlength="20" required class="box textIn validinp" pattern=".{4,}"> </td>
                    </tr>
                    <tr>

                        <td colspan="2">
                            <button type="submit" class="box btn">Update book</button>

                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </div>
    <script src="ajax.js" language="javascript"></script>
</body>

</html>