<?php
// Получение книги и страницы из куки
$book = isset($_COOKIE['book']) ? $_COOKIE['book'] : '';
$page = isset($_COOKIE['page']) ? $_COOKIE['page'] : '';
?>
<header class="header">
        <nav>
            <ul class="navbar">
                <li class="logo-header"><img src="images/logo.svg" class="logo-header"></li>
                <li class="navbar-link"><a href="index.php">Главная</a></li>
                <li class="navbar-link"><a href="list.php">Каталог</a></li>
                <?php
                echo '<li class="navbar-link"><a href="reading.php?book=' . urlencode($book) . '&page=' . urlencode($page) . '">Закладка</a></li>';
                ?>
            </ul>
        </nav>
    </header>