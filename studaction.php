<?php
session_start();
include("include/ensureLogin.php");
$conn = mysqli_connect("localhost", "root", "", "wt");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_POST) {
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    if (array_key_exists('extend', $_POST) && !empty($_POST['extend'])) {
        $_SESSION['currentisbn'] = $_POST['extend'];
        $sql = "SELECT deadline FROM borrowed 
        WHERE isbn ='" . $_SESSION['currentisbn'] . "' AND email ='" . $email . "'";
        $result = mysqli_query($conn, $sql);
        $_SESSION['deadline'] = mysqli_fetch_array($result)['deadline'];
    } else if (array_key_exists('return', $_POST) && !empty($_POST['return'])) {
        $_SESSION['currentisbn'] = $_POST['return'];
        $sql = "DELETE FROM `borrowed` WHERE email = '" . $email . "' 
        AND isbn = '" . $_SESSION['currentisbn'] . "'";
        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['currentisbn']);
            unset($_SESSION['deadline']);
            echo '<script  type="text/javascript">
                 alert("Book Returned successfully!");
                 window.location="profile.php"
                  </script>';
        } else {
            unset($_SESSION['currentisbn']);
            unset($_SESSION['deadline']);
            echo '<script  type="text/javascript">
                 alert("Book return was unsuccessful, Please retry!");
                 window.location="profile.php"
                  </script>';
        }
    } else if (array_key_exists('deadline', $_POST)) {
        if (date('Y-m-d H:i:s', strtotime($_POST['deadline'])) < $_SESSION['deadline'] || date('Y-m-d H:i:s', strtotime($_POST['deadline'])) < date('Y-m-d H:i:s')) {
            unset($_SESSION['currentisbn']);
            unset($_SESSION['deadline']);
            echo '<script  type="text/javascript">
                 alert("Return date can only be extended beyond current time, Please retry!");
                 window.location="profile.php"
                  </script>';
        } else {
            $_SESSION['deadline'] =  date('Y-m-d H:i:s', strtotime($_POST['deadline']));
            $sql = "UPDATE borrowed SET deadline = '" . $_SESSION['deadline'] . "' 
            WHERE email = '" . $email . "' AND isbn = '" . $_SESSION['currentisbn'] . "'";
            if (mysqli_query($conn, $sql)) {
                unset($_SESSION['currentisbn']);
                unset($_SESSION['deadline']);
                echo '<script  type="text/javascript">
                     alert("Deadline extended successfully!");
                     window.location="profile.php"
                      </script>';
            } else {
                unset($_SESSION['currentisbn']);
                unset($_SESSION['deadline']);
                echo '<script  type="text/javascript">
                     alert("Extension unexpectedly failed, please retry!");
                     window.location="profile.php"
                      </script>';
            }
        }
    }
}
?>
<html>

<head>
    <link rel="stylesheet" href="s1.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title id="title">Extend Deadline</title>
</head>

<body>
    <?php include("include/navbar.php"); ?>
    <div id="container">
        <table class="browse" style="margin-top: 200px; text-align:center">
            <thead>
                <tr>
                    <th colspan="5">
                        <form method="post" class="borrow">
                            <label for="deadline">Extend return date and time</label>
                            <input required type="datetime-local" class="textIn box" name="deadline" id="deadline" value="<?php echo date('Y-m-d\TH:i:s', strtotime($_SESSION['deadline'])); ?>">
                            <button type="submit" class="box btn">Go!</button>
                        </form>
                    </th>
                </tr>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>ISBN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM books WHERE isbn ='" . $_SESSION['currentisbn'] . "'";
                $result = mysqli_query($conn, $sql);
                $book = mysqli_fetch_array($result);
                ?>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['author']; ?></td>
                <td><?php echo $book['publisher']; ?></td>
                <td><?php echo $book['year']; ?></td>
                <td><?php echo $book['isbn']; ?></td>
            </tbody>
        </table>
    </div>
    <script src="ajax.js" language="javascript"></script>
</body>

</html>