<div class="navbar-container">
    <nav class="navbar">
        <div class="navbar__brand">
        
            <a href="index.php" class="brand"><img src="assets/logo.png" alt="">  <span class="brand-text">AttackOnCode</span> </a>
        </div>
        <div class="navbar__dropdown-items">
            <form class="navbar__form" action="search-results.php" method="GET">
                <div class="navbar__search-container">
                    <input class="navbar__searchbar" name="searched-item" type="text" placeholder="Search Threads">
                    <div class="navbar__search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>
            </form>
            <ul class="navbar__links">
                <li class="navbar__links--link"><a href="index.php"> Home </a></li>
                <li class="navbar__links--link"><a href="about.php"> About</a></li>
                <li class="navbar__links--link"><a href="contact.php"> Contact</a></li>
                <?php if(!isset($_SESSION['loggedin'])): ?>
                    <a class="navbar__links--link loginBtn" href="login.php">Login</a>
                    <!-- <li class="navbar__links--link loginBtn"><a href="login.php"> Login</a></li> -->
                    <!-- <li class="navbar__links--link signupBtn"> <a href="signup.php"> Signup</a></li> -->
                    <a class="navbar__links--link signupBtn" href="signup.php">Signup</a>
                <?php else: ?>
                    <a class="navbar__links--link signupBtn" href="logout.php">Logout</a>
                    <!-- <li class="navbar__links--link signupBtn"> <a href="logout.php"> Logout</a></li> -->
                <?php endif; ?>
            </ul>
        </div>

        <div class="navbar__hamburger">
            <span class="line line-1"></span>
            <span class="line line-2"></span>
            <span class="line line-3"></span>
        </div>
    </nav>
</div>