
<?php



/*
* Sightings Controller (MVC DP)
*
* - Loads required models and starts a session
* - Handles GET input for search, type, and status filters
* - Fetches filtered sightings and dynamic dropdown options
* - Loads up the pets list for the Add Sighting form
* - Processes POST requests to create new sightings (role-restricted (only browsing users can))
* - Prepares user-friendly feedback message
* - Passes all data to the sightings view for rendering
*/




require_once('Models/SightingsDataSet.php');
require_once('Models/DB.php');

session_start();

$view = new stdClass();
$view->pageTitle = 'Sightings';

$sightingsDataSet = new SightingsDataSet();


$search = $_GET['search'] ?? '';
$type = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';

$view->sightings = $sightingsDataSet->fetchSightings($search, $type, $status);
$view->types = $sightingsDataSet->getDistinctTypes();
$view->statuses = $sightingsDataSet->getDistinctStatuses();

try {
    $db = DB::conn();
    $stmt = $db->prepare('SELECT id, name, type FROM pets ORDER BY name ASC');
    $stmt->execute();
    $view->pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $view->pets = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_sighting'])) {

    if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user') {

        $pet_id = $_POST['pet_id'];
        $user_id = $_SESSION['user_id'];
        $note = $_POST['note'];
        $latitude = $_POST['latitude'] ?? null;
        $longitude = $_POST['longitude'] ?? null;

        $sightingsDataSet->addSighting($pet_id, $user_id, $note, $latitude, $longitude);

        header('Location: sightings.php');
        exit();



    }else {
        $view->errorMessage = "Only browsing users can add sightings";
    }

}

$count = count ($view->sightings);
$view->dbMessage = $count > 0 ? "$count sighting(s) found." : "No sightings found.";

require_once('Views/sightings.phtml');

?>










