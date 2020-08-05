<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Oblasti</title>
    <link rel="stylesheet" href="CSS_site.css">
    <link rel="stylesheet" href="CSS.css">
</head>
<body>

    <div id="wrapper">
        <header>
            <a href="index.php"><img class="logo" src="long.svg" alt="Tu bolo moje logo..."></a>
        </header>

        <nav>
            <ul>
                <li><a href="index.php">Ministerstva</a></li>
                <li><a href="index2.php">Volebni obdobi</a></li>
            </ul>
        </nav>
    </div>

    <div class="DropDown">
        <p>Zadajte oblast pre vyhadanie: <br></p>
        <?php include('config.php') ?>


        <script type="text/javascript" src="script.js"></script>

        <footer>
            Copyright 2020 <a href="https://www.facebook.com/miroslav.khoma" target="_blank">contact me</a>
        </footer>
    </div>

</body>
</html>