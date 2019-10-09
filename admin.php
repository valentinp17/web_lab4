<?php
require('init.php')
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Админка новостного портала</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <p>Админка новостного портала</p>
    <a href="/">юзеринка</a>
</header>
<section>
    <?php
    if ($_POST) {
        if (isset($_POST["action"]) && $_POST["action"] == "POST" && isset($_POST["title"]) && isset($_POST["text"])) {
            $title = mysqli_real_escape_string($conn, $_POST["title"]);
            $text = mysqli_real_escape_string($conn, $_POST["text"]);
            $insert = $conn->query("INSERT INTO news (`title`, `text`) VALUES (\"" . $title . "\",\"" . $text . "\")");
            if ($insert && mysqli_affected_rows($conn) > 0) {
                echo '<div class="info-message">Новостная запись успешно создана</div>';
            } else {
                echo '<div class="error-message">Ошибка взаимодействия с БД</div>';
            }
        } else if (isset($_POST["action"]) && $_POST["action"] == "DELETE" && isset($_POST["id"])) {
            $id = (int)$_POST["id"];
            $delete = $conn->query("DELETE FROM news WHERE id = " . $id);
            if ($delete && mysqli_affected_rows($conn) > 0) {
                echo '<div class="info-message">Новостная запись успешно удалена</div>';
            } else {
                echo '<div class="error-message">Ошибка взаимодействия с БД или запись не найдена</div>';
            }
        } else {
            echo '<div class="error-message">Некорректный запрос</div>';
        }
    }
    ?>

    <form method="post" class="news-form">
        <input type="hidden" name="action" value="POST">
        <label for="title">
            Название
            <input name="title" required>
        </label>
        <label for="text">
            Содержимое
            <textarea name="text" required cols="50" rows="10"></textarea>
        </label>
        <input class="submit-button" type="submit" value="💌"/>
    </form>
</section>
<section>
    <?php
    $news_list = $conn->query("SELECT `title`, `id` FROM news ORDER BY `postingTime` DESC")->fetch_all(MYSQLI_ASSOC);
    foreach ($news_list as $news_item) {
        $title = htmlspecialchars($news_item["title"]);
        $id = htmlspecialchars($news_item["id"]);
        echo '<article class="admin-entry"><p>' . $title . '</p>' .
            '<form method="post">' .
            '<input type="hidden" name="action" value="DELETE">' .
            '<input type="hidden" name="id" value="' . $id . '">' .
            '<input class="delete-button" type="submit" value="🚮">' .
            '</form>' .
            '</article>';
    }
    ?>
</section>
</body>
