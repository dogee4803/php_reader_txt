<!DOCTYPE html>
<html lang="ru">
<?php
    include 'head.php';
?>
<body class="body">
    <?php
        include 'header.php';
    ?>
    <main class="main">
        <h1>Каталог:</h1>
        <div class="list-back">
            <ul class="list_ul">
                <?php
                    $dir = './books';
                    $books = array_diff(scandir($dir), array('..', '.'));/*Gettin rid of first 2*/
                    foreach ($books as $book) {
                        $bookPath = $dir . '/' . $book;
                        if (is_file($bookPath)) {
                            $fileName = pathinfo($book, PATHINFO_FILENAME);
                            echo '<li class="book"><a href="reading.php?book=' . urlencode($book) . '">' . $fileName . '</a></li>';
                        }
                    }
                ?>
            </ul>
        </div>
    </main>
    <?php
        include 'footer.php';
    ?>
</body>
</html>