<?php
session_start()
?>

<div class="scroll center" style="margin-top: 50px;">
    <?php
    $conn = mysqli_connect("localhost", "root", "", "wt");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM books ORDER BY year DESC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)) {
    ?>
        <table class="browse">
            <thead>
                <tr>
                    <th colspan="6">
                        <h1>Browse books</h1>
                    </th>
                </tr>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>ISBN</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include("include/displaybooks.php")?>
            </tbody>
        </table>
    <?php
    } else {
        echo "<h1>No Books Found!<h1>";
    }
    ?>
</div>