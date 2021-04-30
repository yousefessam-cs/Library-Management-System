<?php
while ($book = mysqli_fetch_array($result)) {
?>
    <tr>
        <?php if (array_key_exists('title', $book)) {
        ?>

            <td><?php echo $book['title']; ?></td>
        <?php
        }
        if (array_key_exists('author', $book)) {
        ?>

            <td><?php echo $book['author']; ?></td>
        <?php
        }
        if (array_key_exists('publisher', $book)) { ?>


            <td><?php echo $book['publisher']; ?></td>
        <?php
        }
        if (array_key_exists('year', $book)) {
        ?>

            <td><?php echo $book['year']; ?></td>
        <?php
        }
        if (array_key_exists('isbn', $book)) { ?>

            <td><?php echo $book['isbn']; ?></td>
        <?php
        }
        if (array_key_exists('deadline', $book)) { ?>

            <td><?php echo $book['deadline']; ?></td>
            <?php
        }

        if (array_key_exists('type', $_SESSION)) {
            if ($_SESSION['type'] == 'admin') {
            ?>
                <td>
                    <form action="updateB.php" method="POST"><button type="submit" class="btn box" name="submit" value="<?php echo $book['isbn']; ?>">Update</button></form>
                </td>
                <?php
            } else {
                if (array_key_exists('deadline', $book)) {
                ?>
                    <td>

                <form action="studaction.php" method="post" >
                            <button style=" border-radius:5px;" type="submit" class="btn" name="extend" value="<?php echo $book['isbn']; ?>">Extend</button><br>
                            <button style=" border-radius:5px;" type="submit" class="btn" name="return" value="<?php echo $book['isbn']; ?>">Return</button>
                        </form>
                    </td>
                <?php
                } else {

                ?>
                    <td>
                        <form action="borrow.php" method="POST"><button type="submit" class="btn box" name="submit" value="<?php echo $book['isbn']; ?>">Borrow</button></form>
                    </td>
            <?php
                }
            }
        } else {
            ?>
            <td>
                Login Required!
            </td>
        <?php
        }
        ?>
    </tr>
<?php
}
?>