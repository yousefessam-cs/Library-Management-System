<?php
session_start();

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="s1.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title id="title">Search</title>
</head>

<body>


    <?php include("include/navbar.php");?>
    <div id="container">


        <div class="scroll center" style="margin-top: 50px;">
            <?php
            $conn = mysqli_connect("localhost", "root", "", "wt");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            ?>
            <table class="browse">
                <thead>

                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>ISBN</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <form method="post">

                            <td> <input type="text" placeholder="Title" name="search[title]" maxlength="50" class="box textIn "> </td>

                            <td> <input type="text" placeholder="Author" name="search[author]" maxlength="50" class="box textIn "> </td>

                            <td> <input type="text" placeholder="Publisher" name="search[publisher]" maxlength="20" class="box textIn "> </td>

                            <td> <input type="text" placeholder="Year" name="search[year]" maxlength="4" class="box textIn "> </td>

                            <td> <input type="text" placeholder="ISBN" name="search[isbn]" maxlength="20" class="box textIn "> </td>

                            <td><button type="submit" class="box btn ">Search</button></td>
                        </form>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_POST) {
                        if (array_key_exists('search', $_POST)) {

                            $sql = "SELECT * FROM books WHERE 1 ";

                            if (!empty($_POST['search']['isbn'])) {
                                $isbn = $_POST['search']['isbn'];
                                $sql .= "AND isbn LIKE '%" . mysqli_real_escape_string($conn, $isbn) . "%'";
                            }
                            if (!empty($_POST['search']['title'])) {

                                $title = $_POST['search']['title'];
                                $sql .= "AND title LIKE '%" . mysqli_real_escape_string($conn, $title) . "%'";
                            }
                            if (!empty($_POST['search']['author'])) {
                                $author = $_POST['search']['author'];
                                $sql .= "AND author LIKE '%" . mysqli_real_escape_string($conn, $author) . "%'";
                            }
                            if (!empty($_POST['search']['year'])) {
                                $year = $_POST['search']['year'];
                                $sql .= "AND year='" . mysqli_real_escape_string($conn, $year) . "'";
                            }
                            if (!empty($_POST['search']['publisher'])) {
                                $publisher = $_POST['search']['publisher'];
                                $sql .= "AND publisher LIKE '%" . mysqli_real_escape_string($conn, $publisher) . "%'";
                            }
                        }


                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result)==0){
                             ?>
                            <tr><td colspan="6">No reults found.</td></tr>
                            <?php
                        }
                        include("include/displaybooks.php");
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
    <script src="ajax.js" language="javascript"></script>
</body>

</html>