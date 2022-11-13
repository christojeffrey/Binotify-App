<?php
    function navbar($args){
        // $is_admin, is_logged_in  
        extract($args);
        // create two different navbar, depending on whether is_admin true or false.
        // on admin, add link to add song, add album
        // on both, have link to home, album list, search, logout

        // if not logged in, change logout button to login button

        if ($is_admin){
            // admin navbar
            $admin_navbar = <<<ADMIN_NAVBAR
            <li class="nav-item">
                <a class="nav-link" href="../add-song/index.php">Add Song</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../add-album/index.php">Add Album</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../user-list/index.php">User List</a>
            </li>
            ADMIN_NAVBAR;
        } else {
            $admin_navbar = "";
        }
        if($is_logged_in){
            // logged in navbar
            $logged_in_navbar = <<<LOGGED_IN_NAVBAR
            <li class="nav-item">
                <button class="nav-link" onclick = "onLogout()" >Logout</button>
            </li>
            LOGGED_IN_NAVBAR;
        } else {
            // not logged in navbar
            $logged_in_navbar = <<<NOT_LOGGED_IN_NAVBAR
            <li class="nav-item">
                <a class="nav-link" href="../login/index.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../register/index.php">Register</a>
            </li>
            NOT_LOGGED_IN_NAVBAR;
        }
        $navbar = <<<NAVBAR
        <style>
            .navbar{
                min-height: 100vh;
                margin: 2rem 2rem 0 2rem;
            }
            .nav-item{
                margin: 1rem 0rem;
            }

            .brand{
                margin: 1rem 0rem;
                font-size: 1.5rem;
                text-align: center;
                font-weight: 800;
            }
        </style>
        <nav class="navbar">
            <div class = "brand">
            supotifiy
            </div>
            <div id="navbarNav">
                <ul >
                    <li class="nav-item">
                        <a class="nav-link" href="../home/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../album-list/index.php">Album List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../search-song/index.php">Search</a>
                    </li>
                    $admin_navbar
                    $logged_in_navbar
                </ul>
            </div>
        </nav>
        NAVBAR;
        return $navbar;
    }
?>