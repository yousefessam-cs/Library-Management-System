<div class="nav">
    <a href="index.php">Home</a>
    <a id="books">Browse books</a>
    <a href="search.php">Advanced search</a>
    <!-- <div class="searchbar">
      <form action="search.php">
        <input type="text" required placeholder="Search">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div> -->

    <div class="signIn">
      <?php
      if (empty($_SESSION['type'])) {
      ?>
        <a href="login.php">Sign in</a>
        <a href="register.php">Sign up</a>
      <?php
      } else if ($_SESSION['type'] == "admin") {
      ?>
        <div class="dropdown">
          <button class="dropbtn"><?php echo $_SESSION['name']; ?>
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="profile.php">My profile</a>
            <a href="insertBooks.php">Add a Book</a>
            <a href="logout.php">Sign out</a>
          </div>
        </div>

      <?php
      } else {
      ?>
        <div class="dropdown">
          <button class="dropbtn"><?php echo $_SESSION['name']; ?>
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="profile.php">My profile</a>
            <!-- <a href="">Add a Book</a> -->
            <a href="logout.php">Sign out</a>
          </div>
        </div>
      <?php
      }
      ?>
    </div>

  </div>