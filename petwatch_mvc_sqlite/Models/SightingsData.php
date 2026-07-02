

<?php

/*
* SightingsData (MVC)
*
* - This class represents a single sighting record.
* - It also stores all fields from the sightings table, as well as joined pet/user info.
* - The constructor maps a database row into object properties.
* - Getter methods provide safe access to each field for the view.
*
* Used by SightingsDataSet to return well-structured objects instead of raw arrays.
*/





class SightingsData {
    protected $_id, $_petID, $_userID, $_note, $_latitude, $_longitude, $_createdAt,
    $_petName, $_petType, $_petStatus, $_username;

    public function __construct($dbRow) {

        $this->_id = $dbRow['id'];
        $this->_petID = $dbRow['pet_id'];
        $this->_userID = $dbRow['user_id'];
        $this->_note = $dbRow['note'];
        $this->_latitude = $dbRow['latitude'];
        $this->_longitude = $dbRow['longitude'];
        $this->_createdAt = $dbRow['created_at'];

        $this->_petName = $dbRow['pet_name'] ?? null;
        $this->_petType = $dbRow['pet_type'] ?? null;
        $this->_petStatus = $dbRow['pet_status'] ?? null;
        $this->_username = $dbRow['username'] ?? null;

    }

    public function getID(){
        return $this->_id;
    }
    public function getPetID(){
        return $this->_petID;
    }
    public function getUserID(){
        return $this->_userID;
    }
    public function getNote(){
        return $this->_note;

    }
    public function getLatitude(){
        return $this->_latitude;
    }

    public function getLongitude(){
        return $this->_longitude;
    }

    public function getCreatedAt(){
        return $this->_createdAt;
    }

    public function getPetName(){
        return $this->_petName;
    }

    public function getPetType(){
        return $this->_petType;
    }

    public function getPetStatus(){
        return $this->_petStatus;
    }

    public function getUsername(){
        return $this->_username;
    }



}















