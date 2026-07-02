
<?php

require_once('Models/DB.php');


$db = DB::conn();

$pet_id = $_POST['pet_id'];
$note = $_POST['note'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$stmt = $db->prepare("INSERT INTO sightings 
    (pet_id, latitude, longitude, note, created_at)
    
    VALUES(?, ?, ?, ?, datetime('now'))
");

$stmt->execute([$pet_id, $lat, $lng, $note]);
echo "Sighting created";



?>










