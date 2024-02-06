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
		<h1>Результат поиска:</h1>
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
			// Getting word and book from url
			$word = $_GET['word'];
			$book_name = urldecode($_GET['book']);
			echo $book_name;
			
			$dir = './books';
			$bookPath = $dir . '/' . $book_name;
			// Check existance of file
			if (file_exists($bookPath)) {
				$bookContent = file_get_contents($bookPath);
				$pages = splitPages($bookContent, 2000);
				$i = 1;
				$found = false;
				// Read every page
				echo '<ul class="list_ul">';
				foreach ($pages as $page) {
					// Checking every page
					$i += 1;
					$sentences = preg_split('/(?<=[.?!])\s+(?=[а-я])/i', $page); //If you want to use english letters, change 'а-я' to 'a-z'
					foreach ($sentences as $sentence) { //Checking every sentence
						if (stripos($sentence, $word) !== false) {
							echo '<li class="book"><a href="reading.php?book=' . urlencode($book_name) . '&page=' . $i . '">Страница ' . $i . ': ' . $sentence . '</a></li>';
							$found = true;
						}
					}						
				}		
				echo '</ul>';

				// If the word isn't found
				if ($found == false) {
					echo "Слово не найдено в книге.";
				}
			}
			else {
				// If book isn't found
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
