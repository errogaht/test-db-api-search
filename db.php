<?php
require_once 'config.php';	
require_once 'Main.php';	
require_once 'inc\php-pdo-wrapper-class\class.db.php';



$lol = new Main();

if ($_POST) {
	switch ($_POST['cmd']) {
		case 'loadTxt':
			echo "Загружено {$lol->loadWords()} слов";
			break;
		case 'translateAll':
			echo "Переведено {$lol->translateAll()} слов";
			break;
		case 'translateType':
			echo $lol->searchFrom($_POST['text']);
			break;
		
		default:
			# code...
			break;
	}
}


