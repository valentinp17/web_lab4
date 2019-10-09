<?php
require('init.php')
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <title>Новостной портал</title>
</head>
<body>
<header>
    <p>Новостной портал</p>
    <a href="admin.php">админка</a>
</header>
<section>
    <?php
    $news_list = $conn->query("SELECT `title`, `text` FROM news ORDER BY `postingTime` DESC")->fetch_all(MYSQLI_ASSOC);
    foreach ($news_list as $news_item) {
        $title = nl2br(htmlspecialchars($news_item["title"]));
        $text = nl2br(htmlspecialchars($news_item["text"]));
        echo '<article>' . '<h2>' . $title . '</h2>' . '<p class="news-text">' . $text . '</p>' . '</article>';
    }
    ?>
</section>
</body>
