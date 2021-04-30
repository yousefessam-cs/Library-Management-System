<?php
session_start();
include("include/ensureLogin.php");
$conn = mysqli_connect("localhost", "root", "", "wt");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="s1.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title id="title">Profile</title>
</head>

<body>


    <?php include("include/navbar.php"); ?>
    <div id="container">
        <div class="profile">
            <div class="editProfile">
                <form method="post">
                    <fieldset id="profileField" disabled>
                        <legend>
                            <h3>My Profile</h3>
                        </legend>
                        <table>
                            <tr>
                                <td><label for="newname">Username</label></td>
                                <td><input type="text" id="newname" name="newname" class="box validinp textIn" maxlength="20" value=<?php echo $_SESSION['name'] ?> required pattern=".{5,}" title="Must contain 5-20 characters"></td>
                            </tr>
                            <tr>
                                <td><label for="newemail">Email Address</label></td>
                                <td><input type="email" id="newemail" name="newemail" class="box validinp textIn" maxlength="50" value=<?php echo $_SESSION['email'] ?> required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Must contain some characters followed by an '@' then the domain name (for example: example@gmail.com)"></td>
                            </tr>
                            <tr>
                                <td><label for="newpassword">Password</label></td>
                                <td><input required type="password" name="newpassword" id="newpassword" class="box validinp textIn" maxlength="50" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><button type="submit" class="box btn">Apply</button></td>
                            </tr>
                            <tr>
                                <td colspan="2" id="updateErr"></td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
                <form id="confirmForm" method="post">

                    <div id="pwError">
                        <input required type="password" id="password1" name="password1" class="box textIn" maxlength="50" placeholder="Password">
                        <label for="password1" id="errEdit">Please enter your password if you <br> want to edit the user profile</label>
                    </div>
                    <button type="submit" class="box btn" id="enable" value="confirm">Edit profile</button>

                </form>

                <?php

                if ($_POST) {

                    if (array_key_exists("newname", $_POST)) {

                        include 'include/updateP.php';
                    } else if (array_key_exists("password1", $_POST)) {

                        $password = $_POST['password1'];
                        $email = $_SESSION['email'];
                        $sql = "SELECT password FROM users 
                         WHERE email ='" . mysqli_real_escape_string($conn, $email) . "' AND password ='" . mysqli_real_escape_string($conn, $password) . "' ";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)) {
                            $Opassword = mysqli_fetch_array($result)['password'];
                            echo '<script  type="text/javascript">
                            document.getElementById("profileField").disabled = false;
                            document.getElementById("newpassword").value="' . $Opassword . '";
                            </script>';
                        } else {
                            echo '<script  type="text/javascript">
                            document.getElementById("errEdit").innerHTML = "Incorrect password";
                            document.getElementById("errEdit").style.color = "red";
                            </script>';
                        }
                    }
                }

                ?>
            </div>

            <?php if ($_SESSION['type'] == 'admin') { ?>
                <div class="scroll">
                    <table id="borrowed">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h3>Late borrowers</h3>
                                </th>
                            </tr>

                            <tr>
                                <th>Borrower name</th>
                                <th>Borrower email</th>
                                <th>Book ISBN</th>
                                <th>Deadline</th>
                                <th>Actions</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT users.name , users.email , borrowed.isbn , borrowed.deadline FROM users 
                            JOIN borrowed ON users.email = borrowed.email WHERE deadline <= NOW() ORDER BY borrowed.deadline ASC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['isbn']; ?></td>
                                    <td><?php echo $row['deadline']; ?></td>
                                    <td>
                                        <form action="sendmail.php" method="post">
                                        
                                            <input type="hidden" name="tomail[email]" value="<?php echo $row['email']; ?>">
                                            <input type="hidden" name="tomail[isbn]" value="<?php echo $row['isbn']; ?>">
                                            <button type="submit" class="btn" style="border-radius:10px;">Send email</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="scroll">
                    <table id="borrowed">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h3>Borrowed books</h3>
                                </th>
                            </tr>

                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Deadline</th>
                                <th>Actions</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT books.title , books.author , borrowed.deadline , books.isbn FROM books 
                            JOIN borrowed ON books.isbn=borrowed.isbn 
                            WHERE borrowed.email='" . mysqli_real_escape_string($conn, $_SESSION['email']) . "' ORDER BY borrowed.deadline ASC";
                            $result = mysqli_query($conn, $sql);
                            include("include/displaybooks.php");
                            ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
<?php } ?>
<script src="ajax.js" language="javascript"></script>
</body>

</html>