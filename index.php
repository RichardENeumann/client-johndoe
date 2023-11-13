<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/reset.css">
    <link rel="stylesheet" href="style/base.css">
    <link rel="stylesheet" href="style/tablet.css">
    <link rel="stylesheet" href="style/desktop.css">
    <link rel="icon" type="image/x-icon" href="style/icons8-puzzle-100.png">
    <title>John Doe</title>
</head>
<body>
    <header>
        <a href="index.php">
            <h1 class="title">John Doe</h1>
        </a>
        <div class="contact">
            email: <a href="mailto:contact@johndoe.com">contact@johndoe.com</a>
            <br>
            mobile: <a href="tel:+4912345678901">+49 (0)123 456 789 01</a>
        </div>
    </header>
    <nav>
        <?php
            // Build navigation items from XML file
            $navigation = [];              
            $navSource = simplexml_load_file("logic/navigation.xml");
            foreach($navSource->children() as $entry) {
                array_push($navigation,
                    "<a href=\"index.php?page=".$entry->variable."\">".$entry->title."</a>");
            }
            echo implode(" &#11049; ", $navigation);
        ?>        
    </nav>
    <?php
        // Load page content according to GET parameter
        $included = false;
        if (!isset($_GET["page"])) {
            include "content/welcome.html";
            $included = true;
        } else if (strtolower($_GET["page"]) == "legal") {
            include "content/legal.html";
            $included = true;
        } else {
            foreach($navSource->children() as $entry) {
                if (strtolower($_GET["page"]) == $entry->variable) {
                    include "content/".$entry->filename;
                    $included = true;
                    break;
                } 
            }
        }        
        if ($included == false) {
            include "content/welcome.html";
            $included = true;
        }    
    ?>
    <footer>
        <a href="index.php?page=legal" class="navigation">Legal Note</a>
    </footer>
</body>
</html>