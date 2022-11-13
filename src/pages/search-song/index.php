<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search-song</title>
    <!-- styles -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="flex">

        <div id="navbar"></div>
        <section class="main-section">
            <div id="account-info"></div>

            <div class="search-container">
                <!-- textbox -->
                <input class="bg-black search-box" type="text" id="search-text" placeholder="Search for songs">
                <!-- search button -->
                <button id="search-button" onclick="onSearchClick()">
                    <img class="search-button" src="../../assets/icons/search.svg" alt="search">
                </button>
            </div>

            <!-- drop down. option is title, singer, and year -->
            <div class="search-filter-container">
                <div class="filter-container">
                    <select name="option" id="search-option" class="search-filter-dropdown">
                        <option value="title">title</option>
                        <option value="singer">singer</option>
                        <option value="year">year</option>
                    </select>
                </div>

                <div class="filter-container">
                    <label for="sort">sort by</label>
                    <select name="sort" id="sort" class="search-filter-dropdown">
                        <option value="">none</option>
                        <option value="year-asc">year asc</option>
                        <option value="year-desc">year desc</option>
                        <option value="title-asc">title asc</option>
                        <option value="title-desc">title desc</option>
                    </select>
                </div>
                <div class="filter-container">
                    <label for="filter">filter by genre</label>
                    <select name="filter" id="filter" class="search-filter-dropdown">
                        <option value="">none</option>

                        <?php
                        $GENRE_LIST = array("alternative",
                        "blues",
                        "children",
                        "classical",
                        "country",
                        "EDM",
                        "Electronic",
                        "Folk",
                        "Hip-Hop/Rap",
                        "Indie",
                        "Jazz",
                        "J-Pop",
                        "K-Pop",
                        "Latin",
                        "Metal",
                        "Opera",
                        "Pop",
                        "RnB",
                        "Reggae",
                        "Rock",
                        "Traditional",
                        "Others");
                        foreach($GENRE_LIST as $value) {
                            echo "<option value=$value>$value</option>";
                        }
                        ?>
                    </select>
                </div>
                
            </div>
            


            <!-- search result -->
            <div id="pagination" class="move-page-button-container"></div>
            <div id="song-list">
            </div>
        </section>
    </div>
    <div id="player"></div>
</body>
<?php
    // add global js and styles
    require '../../global.php';
    echoGlobal();
?>
<!-- script -->
<script src="script.js"></script>

</html>