<?php
require_once 'core/init.php';



class GuestbookEntry {
	public $id, $name, $message, $posted, $entry;
	public function __construct() {
		$this->entry = "{$this->name} posted: {$this->message}";
	}

}

//GETTING ROW COUNT
$query = $handler->query('SELECT * FROM guestbook LIMIT 2');
if($query->rowCount()) {
	while ($r = $query->fetch(PDO::FETCH_OBJ)) {
		echo $r->message."<br>";
	}
} else {
	echo 'No results';
}

/* INSERTING
$name = 'Josdfsdfh';
$message = 'mint';

$sql = "INSERT INTO guestbook (name, message, posted) VALUES (:name, :message, NOW())";
$query = $handler->prepare($sql);
$query->execute(array(
	':name' 	=> $name,
	':message' 	=> $message
));

echo $handler->lastInsertId();*/
//$query = $handler->query('SELECT * FROM guestbook');

/* // SET FETCH MODE
$query->setFetchMode(PDO::FETCH_CLASS, 'GuestbookEntry');

while($r = $query->fetch()) {
	echo $r->entry."<br>";
}*/

/*
while($r = $query->fetch(PDO::FETCH_OBJ)){
	echo $r->message, '<br>';	
}*/

?>