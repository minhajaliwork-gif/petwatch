<?php


/*
 * SightingsDataSet Model (MVC DP)
 *
 * - This class handles all database operations for sightings.
 * - fetchSightings(): returns sightings and includes an optional search/type/status filters.
 * - addSighting(): adds a new sighting into the database.
 * - getDistinctTypes() / getDistinctStatuses(): used for dynamic dropdown filters to get a more precise sighting.
 *
 * Uses prepared  SQL statements for safety and returns SightingsData objects
 * for easy use in the controller and view.
 */



require_once('Models/DB.php');
require_once('Models/SightingsData.php');

class SightingsDataSet {
    protected $_dbHandle;

    public function __construct() {
        $this->_dbHandle = DB::conn();
    }

    public function fetchSightings($search = '', $type = '', $status = '') {
        $sql = 'SELECT sightings.*,
                        pets.name AS pet_name,
                        pets.type AS pet_type,
                        pets.status AS pet_status,
                        users.username AS username
                FROM sightings
                JOIN pets ON sightings.pet_id = pets.id
                JOIN users ON sightings.user_id = users.id
                WHERE 1=1';

        $params = [];

        if (!empty($search)) {
            $sql .= ' AND (pets.name LIKE :search OR sightings.note LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }

        if (!empty($type)) {
            $sql .= ' AND pets.type = :type';
            $params[':type'] = $type;
        }

        if (!empty($status)) {
            $sql .= ' AND pets.status = :status';
            $params[':status'] = $status;
        }


        $sql .= ' ORDER BY sightings.created_at DESC';

        $statement = $this->_dbHandle->prepare($sql);
        $statement->execute($params);

        $dataSet = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $dataSet[] = new SightingsData($row);
        }

        return $dataSet;

    }

    public function addSighting($pet_id , $user_id, $note, $latitude, $longitude)
    {
        $sql = 'INSERT INTO sightings (pet_id , user_id , note , latitude, longitude, created_at)
        VALUES (:pet_id , :user_id , :note , :latitude, :longitude, datetime("now"))';

        $statement = $this->_dbHandle->prepare($sql);
        $statement->execute([
            ':pet_id' => $pet_id,
            ':user_id' => $user_id,
            ':note' => $note,
            ':latitude' => $latitude,
            ':longitude' => $longitude,

        ]);
    }


    public function getDistinctTypes() {
        $statement = $this->_dbHandle->prepare('SELECT DISTINCT type FROM pets ORDER BY type ASC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getDistinctStatuses() {
        $statement = $this->_dbHandle->prepare('SELECT DISTINCT status FROM pets ORDER BY status ASC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }





}


















