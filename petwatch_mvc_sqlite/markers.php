
<?php

//Connection to SQlite database
$pdo = new PDO("sqlite:" . __DIR__ . "/database/petwatch.db");

//Get search input from AJAX request
$search = $_GET['search'] ?? '';

//If search is not empty filter results
if ($search !== ''){
    $stmt = $pdo->prepare("
        SELECT 
            sightings.latitude,
            sightings.longitude,
            sightings.note,
            sightings.created_at,
            pets.name AS pet_name
        FROM sightings
        JOIN pets ON sightings.pet_id = pets.id
        WHERE pets.name LIKE ? OR sightings.note LIKE ?
          
            ");
    //Execute query with wildcard search
    $stmt->execute(["%$search%", "%$search%"]);
} else {
//If theres no search return all sightings
    $stmt =  $pdo->query("
    SELECT
        sightings.latitude,
        sightings.longitude,
        sightings.note,
        sightings.created_at,
        pets.name AS pet_name
        
        FROM sightings
    JOIN pets ON sightings.pet_id = pets.id
        
    ");


}

//Store the results in an array
$data = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}
//Return data as JSON for AJAX
echo json_encode($data);


?>










