
<?php

//Include database connection class
require_once('Models/DB.php');

//Create a view object (MVC)
$view = new stdClass();

//Get the database connection
$db = DB::conn();

//Fetch all pets for data use
$stmt = $db->prepare("SELECT id, name FROM pets");
$stmt->execute();

//Store results in view
$view->pets = $stmt->fetchAll(PDO::FETCH_ASSOC);


require_once('Views/map.phtml');

?>










