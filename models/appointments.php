<?php

class appointments {
    
    public $id = 0;
    public $dateHour = '1900-12-01 12:30:00';
    public $idPatients = 0;
    public $db = null;
    
    public function __construct() {
        $this->db = database::getInstance();
    }
    
    public function takeAppointementForAPatient() {
        $requestToTakeAppointementForAPatient = 'INSERT INTO `appointments` (`dateHour`, `idPatients`) '
                . ' VALUES (:dateHour, :idPatients)';
        
        $request = $this->db->prepare($requestToTakeAppointementForAPatient);
        
        $request->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        $request->bindValue(':idPatients', $this->idPatients, PDO::PARAM_INT);
        
        return $request->execute();
    }
    
    public function checkIfRdvExistByAllHisAttribute() {
        $queryToCheckIfRdvExistByAllHisAttribute = 'SELECT COUNT(`id`) AS `exist` '
                . ' FROM `appointments` '
                . ' WHERE `idPatients` = :idPatients AND `dateHour` = :dateHour';
        
        $query = $this->db->prepare($queryToCheckIfRdvExistByAllHisAttribute);
        
        $query->bindValue(':idPatients', $this->idPatients, PDO::PARAM_STR);
        $query->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        
        $query->execute();
        
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
    public function showRdvList() {
        $queryShowRdvList = 
                'SELECT DATE_FORMAT(`appointments`.`dateHour`, \'%d/%m/%Y\') AS `frenchDate`, DATE_FORMAT(`appointments`.`dateHour`, \'%H:%i\') AS `hour`, `patients`.`lastname`, `patients`.`firstname`, `appointments`.`id` '
                . ' FROM `appointments` '
                . ' INNER JOIN `patients` ON `appointments`.`idPatients` = `patients`.`id` '
                . ' ORDER BY `dateHour`';
        
        $query = $this->db->query($queryShowRdvList);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getAllAppointmentInfoByHisId() {
        $queryTogetAllAppointmentInfoByHisId = 
                'SELECT DATE_FORMAT(`appointments`.`dateHour`, \'%Y-%m-%d\') AS `sqlDate`, DATE_FORMAT(`appointments`.`dateHour`, \'%d/%m/%Y\') AS `frenchDate`, DATE_FORMAT(`appointments`.`dateHour`, \'%H:%i\') AS `hour`, `patients`.`lastname`, `patients`.`firstname`, `patients`.`phone`, `patients`.`mail`, DATE_FORMAT(`patients`.`birthdate`, \'%d/%m/%Y\') AS `frenchBirthdate` '
                . ' FROM `appointments` '
                . ' INNER JOIN `patients` ON `appointments`.`idPatients` = `patients`.`id` '
                . ' WHERE `appointments`.`id` = :id';

        $query = $this->db->prepare($queryTogetAllAppointmentInfoByHisId);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        $query->execute();
        
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
    public function checkIfTheAppointmentExistsByHisId() {
        $requestTocheckIfAppointmentExist = 'SELECT COUNT(`id`) AS `exist` '
                . ' FROM `appointments` '
                . ' WHERE `id` = :id';

        $request = $this->db->prepare($requestTocheckIfAppointmentExist);

        $request->bindValue(':id', $this->id, PDO::PARAM_INT);

        $request->execute();

        return $request->fetch(PDO::FETCH_OBJ);
    }
    
    public function changeDataOfAnAppoitment() {
        $queryToChangeDataOfAnAppoitment = 'UPDATE `appointments` '
                . 'SET `dateHour` = :dateHour '
                . 'WHERE `id` = :id';

        $query = $this->db->prepare($queryToChangeDataOfAnAppoitment);

        $query->bindValue(':dateHour', $this->dateHour, PDO::PARAM_STR);
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $query->execute();
    }
    
    public function deleteAnAppoitment() {
        $queryToDeleteAnAppoitment = 
                'DELETE '
                . 'FROM `appointments` '
                . ' WHERE `id` = :id';
        
        $query = $this->db->prepare($queryToDeleteAnAppoitment);
        
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        $query->execute();
        
    }
}
