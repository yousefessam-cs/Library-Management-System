<?php
session_start();
include("include/ensureLogin.php");
$conn = mysqli_connect("localhost", "root", "", "wt");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_POST) {
    if (array_key_exists('submit', $_POST)) {
        $_SESSION['borrowisbn'] = $_POST['submit'];
    }
    if (array_key_exists('deadline', $_POST)) {
        $deadline =  date('Y-m-d H:i:s', strtotime($_POST['deadline']));
        if (date('Y-m-d H:i:s') > $deadline) {
            echo '<script type="text/javascript">
                alert("Invalid deadline, please retry");
            </script>';
        } else {
            $sql = "INSERT INTO `borrowed`(`email`, `isbn`, `deadline`) 
            VALUES ('" . mysqli_real_escape_string($conn, $_SESSION['email']) . "','" . $_SESSION['borrowisbn'] . "','" . $deadline . "')";
            if(mysqli_query($conn,$sql)){
                unset($_SESSION['borrowisbn']);
                echo '<script type="text/javascript">
                alert("Succesfully borrowed the book!");
                window.location="index.php";
            </script>';
            }else{
                unset($_SESSION['borrowisbn']);
                echo '<script type="text/javascript">
                alert("Cannot borrow the same book twice!");
                window.location="index.php";
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
    <title id="title">Set Deadline</title>
</head>

<body>
    <?php include("include/navbar.php"); ?>
    <div id="container">
        <table class="browse" style="margin-top: 200px; text-align:center">
            <thead>
                <tr>
                    <th colspan="5">
                        <form method="post" class="borrow">
                            <label for="deadline">Set return date and time</label>
                            <input required type="datetime-local" class="textIn box" name="deadline" id="deadline">
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
                $sql = "SELECT * FROM books WHERE isbn ='" . $_SESSION['borrowisbn'] . "'";
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