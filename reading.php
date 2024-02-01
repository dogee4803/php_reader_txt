<!DOCTYPE html>
<html lang="ru">
<?php
    include 'head.php';
?>
<body class="body">
    <?php
        if (isset($_GET['book']) && isset($_GET['page'])) {
            setcookie('book', $_GET['book'], time() + 259200); // Saving cookie book for 3 days
            setcookie('page', $_GET['page'], time() + 259200); // Saving cookie page for 3 days
        }
        include 'header.php';
    ?>
    <main class="main">
        <div class="list-back">
            <?php
                function splitPages($bookContent, $length){
                    $bookLength = mb_strlen($bookContent);
                    $pages = [];
                    $offset = 0;
                    while ($offset < $bookLength) {
                        $pageContent = mb_substr($bookContent, $offset, $length);
                        $lastSpacePos = mb_strrpos($pageContent, ' ');
                        if ($lastSpacePos !== false && $lastSpacePos > mb_strlen($pageContent) - 30) {
                            $pageContent = mb_substr($pageContent, 0, $lastSpacePos);
                            $offset += $lastSpacePos + 1;
                        } else {
                            $offset += $length;
                        }
                        $pages[] = $pageContent;
                    }
                    return $pages;
                }
                
                $book = $_GET['book'];
                $bookPath = './books/' . $book;
                if (is_file($bookPath)) {
                    $bookContent = file_get_contents($bookPath);
                    $pages = splitPages($bookContent, 2000);
                    $totalPages = count($pages);
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $pageContent = $pages[$currentPage - 1];
                    echo '<h1>' . $book . '</h1>';
                    echo $pageContent;
                    // It's time for buttons
                    if ($totalPages > 1) {
                        echo '<div>';
                        if ($currentPage > 1) {
                            echo '<a href="?book=' . urlencode($book) . '&page=' . ($currentPage - 1) . '">Назад</a>';
                        }
                        for ($i = 1; $i <= $totalPages; $i++) {
                            if ($i == $currentPage) {
                                echo '<strong>' . $i . '</strong> '; //highlight for current page
                            } else {
                                echo '<a href="?book=' . urlencode($book) . '&page=' . $i . '">' . $i . '</a> '; // all other pages
                            }
                        }
                        if ($currentPage < $totalPages) {
                            echo '<a href="?book=' . urlencode($book) . '&page=' . ($currentPage + 1) . '">Вперед</a>';
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<p>Книга не найдена</p>';
                }
            ?>
        </div>
    </main>
    <?php
        include 'footer.php';
    ?>
</body>
</html>