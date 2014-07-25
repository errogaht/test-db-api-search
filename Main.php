<?php

class Main{
	public $db = __CLASS__;
	public $host;
	public $port;
	public $name;
	public $user;
	public $password;
	public $translateKey;
	public $table;


	public function __construct() {
		$this->host 	= Config::read('db.host');
		$this->port 	= Config::read('db.port');
		$this->name 	= Config::read('db.basename');
		$this->user 	= Config::read('db.user');
		$this->password = Config::read('db.password');
		$this->table 	= Config::read('db.table');
		//$this->db 		= new db("pgsql:host=$this->host;port=$this->port;dbname=$this->name", $this->user, $this->password);
		$this->db 		= new db("sqlite:db.sqlite");
		$this->db->setErrorCallbackFunction("echo");
		$this->createTable();

	}


	protected function createTable() {
		$sql = 'CREATE TABLE IF NOT EXISTS "'.$this->table.'" ("eng" varchar(255) NOT NULL,"ru" varchar(255) DEFAULT NULL);';
		$this->db->run($sql);
	}


	public function insert() {
		$insert = ["eng" => "44", "ru" => "hahaha224444444"];
		$this->db->insert($this->table, $insert);

	}


	public function loadWords() {
		$lines = file(Config::read('words.input'), FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES);
		$counter = 0;
		foreach ($lines as $word) {
			if ($this->loadWord($word))
				$counter++;
		}
		return $counter;
	}


	public function loadWord($word) {
		$results = $this->db->select($this->table, "eng = '$word'");

		if (!$results) {
			$insert = ["eng" => $word];
			$this->db->insert($this->table, $insert);
			return true;
		}

	}


	public function translate($word, $from = 'en', $to = 'ru') {
		$this->translateKey = Config::read('translate.key');
		$json = file_get_contents("https://translate.yandex.net/api/v1.5/tr.json/translate?key=$this->translateKey&text=$word&lang=$from-$to&format=plain");
		$text = json_decode($json);
		return $text->text[0];
		}


	public function translateAll() {
		$notTranslatedWords = $this->db->select($this->table, "ru IS NULL");
		$counter = 0;
		foreach ($notTranslatedWords as $word) {
			$transtation = $this->translate($word['eng']);
			$this->db->update($this->table, ["ru" => $transtation], "eng = '{$word['eng']}'");
			if ($transtation && $transtation != '') {
				$counter++;
			}
		}
		return $counter;
	}


	public function searchFrom($text){
		$result = $this->db->select($this->table, "eng LIKE '$text%'");
		$return = '';
		foreach ($result as $item) {
			$tail = substr($item['eng'], strlen($text)); 
			$return .= "<p><span><b>$text</b>$tail</span> — <i>{$item['ru']}</i></p> \n";
		}
		return $return;
	}


	public function searchExact($text){
		$result = $this->db->select($this->table, "eng = '$text'");
		echo json_encode($result);
	}
}