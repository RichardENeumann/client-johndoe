<main class="blog">
    <h1>Blog</h1><br>
    <?php
    $blogentries = [];
    $directory = [];
    // Display the newest n blog entries:
    $howManyDefault = 2;
    // Read blog entries from folder
    function loadEntries() {
        global $blogentries;
        global $directory;
        $directory = scandir("blog/");
        foreach($directory as $file) {
            if (preg_match("/(?:entry)\d{3}/", $file)) {
                $tempObj = simplexml_load_file("blog/".$file);
                $tempObj->addChild("number", substr($file, -7, -4));
                array_push($blogentries, $tempObj);
            }
        }  
    }
    // Display requested blog entries
    function showEntries(string $howMany) {
        global $blogentries;
        global $directory;
        global $howManyDefault;
        if ($howMany === "all") {
            foreach ($blogentries as $entry) { 
                echo "<div class=\"blog-entry\">";
                echo "<h2>".rawurldecode(strval($entry->title))."</h2>";
                echo "<div class=\"entry-info\">";
                echo "by: <em>".rawurldecode(strval($entry->author))."</em>";
                echo " &#11049; Date: <em>".rawurldecode(strval($entry->date))."</em><br><br>";
                echo "</div>";
                echo "<p>".rawurldecode(strval($entry->teasertext)).
                    "... <a href=\"index.php?page=blog&show=".$entry->number."\">[more]</a></p>";
                echo "</div><hr>";
            }
        } else if (preg_match("/^\d{3}$/", $howMany)) {
            if (in_array("entry".$howMany.".xml", $directory)) {
                $entry = simplexml_load_file("blog/entry".$howMany.".xml");
                echo "<div class=\"blog-entry\">";
                echo "<h2>".rawurldecode(strval($entry->title))."</h2>";
                echo "<div class=\"entry-info\">";
                echo "by: <em>".rawurldecode(strval($entry->author))."</em>";
                echo " &#11049; Date: <em>".rawurldecode(strval($entry->date))."</em><br><br>";
                echo "</div>";
                echo "<p>".rawurldecode($entry->content)."</p>";
                echo "</div><hr>";
            } else {
                echo "No entry found! <br><br>";
            }
        } else {
            for ($i = 0; $i < $howManyDefault; $i++) {
                echo "<div class=\"blog-entry\">";
                echo "<h2>".rawurldecode(strval($blogentries[$i]->title))."</h2>";
                echo "<div class=\"entry-info\">";
                echo "by: <em>".rawurldecode(strval($blogentries[$i]->author))."</em>";
                echo " &#11049; Date: <em>".rawurldecode(strval($blogentries[$i]->date))."</em><br><br>";
                echo "</div>";
                echo "<p>".rawurldecode(strval($blogentries[$i]->teasertext)).
                    "... <a href=\"index.php?page=blog&show=".$blogentries[$i]->number."\">[more]</a></p>";
                echo "</div><hr>";
            }    
        }
    }
    // Prepare blog entries and validate GET parameters
    loadEntries();
    if (!isset($_GET["show"])) {
        showEntries("");  
        echo "<a href=\"index.php?page=blog&show=all\">[show all entries]</a>";
    } else if ($_GET["show"] === "all") {
        showEntries("all");
        echo "<a href=\"index.php?page=blog\">[back]</a>";
    }else if (preg_match("/^\d{3}$/", $_GET["show"])) {
        showEntries($_GET["show"]);
        echo "<a href=\"index.php?page=blog\">[back]</a>";
    } else {
        showEntries("");
        echo "<a href=\"index.php?page=blog&show=all\">[show all entries]</a>";
    }
    ?>
</main>
<div class="logos"></div>
