<?php

class patients {

    public $id = 0;
    public $lastname = '';
    public $firstname = '';
    public $birthdate = '1900-12-01';
    public $phone = '';
    public $mail = '';
    public $db = null;

    public function __construct() {
        $this->db = database::getInstance();
    }

    /**
     * Méthode permettant de récuperer est insérer dans notre base de donné des patients
     */
    public function pushAnewPatientToDb() {
        $requestToPushANewPatient = 'INSERT INTO `patients`(`lastname`, `firstname`, `birthdate`, `phone`, `mail`) '
                . ' VALUES(UPPER(:lastname), :firstname, :birthdate, :phone, :mail)';

        $request = $this->db->prepare($requestToPushANewPatient);

        $request->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $request->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $request->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $request->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $request->bindValue(':mail', $this->mail, PDO::PARAM_STR);

        return $request->execute();
    }

    /**
     * Methode qui permet de verifier si le patient existe déjà
     * Elle retourne : 0 quand le patient n'existe pas 
     *                 1 quand le patient existe
     * @return OBJ
     */
    public function checkIfPatientExists() {
        $requestToCheckPatient = 'SELECT COUNT(`id`) AS `patientExist` FROM `patients` WHERE `lastname`=:lastname'
                . ' AND `firstname`=:firstname AND `birthdate`=:birthdate'
                . ' AND `phone`=:phone AND `mail`=:mail';

        $request = $this->db->prepare($requestToCheckPatient);

        $request->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $request->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $request->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $request->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $request->bindValue(':mail', $this->mail, PDO::PARAM_STR);

        $request->execute();

        return $request->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Méthode qui permet de rechercher et afficher une liste de patient selon les critères de recherche selon le nom uniquement 
     * @param $search type = array, $offset type = int
     * @return array(obj{})
     */
    public function searchAPatient($search = array(), $offset = 0) {
        $requestToSearchAPatient = 'SELECT `firstname`, `lastname`, `id` '
                . ' FROM `patients` ';
        if (count($search) > 0) {
            $whereLike = array();
            $requestToSearchAPatient .= 'WHERE ';
            foreach ($search as $colName => $value) {
                $whereLike[] = '`' . $colName . '` LIKE :' . $colName;
            }
            $requestToSearchAPatient .= implode(' OR ', $whereLike);
        }
        $requestToSearchAPatient .= ' LIMIT 10 '
                . 'OFFSET :start';
        
        
        $request = $this->db->prepare($requestToSearchAPatient);
        
        
        $request->bindValue(':start', $offset, PDO::PARAM_INT);
        foreach ($search as $colName => $value) {
            $request->bindValue(':' . $colName , $value, PDO::PARAM_STR);
        }
        

        $request->execute();
        

        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Méthode permettant d'afficher les information d'un patient en particulier en comparant son id avec un paramètre
     * @return obj ou string
     */
    public function displayPatientInfoWithHisId() {
        $requestToDisplayPatientInfoWithHisId = 'SELECT `patients`.`firstname`, `patients`.`lastname`, DATE_FORMAT(`patients`.`birthdate`, \'%d/%m/%Y\') AS `frenchBirthdate`, `patients`.`birthdate`, `patients`.`phone`, `patients`.`mail`, DATE_FORMAT(`appointments`.`dateHour`, \'%d/%m/%Y\') AS `frenchDate`, DATE_FORMAT(`appointments`.`dateHour`, \'%H:%i\') AS `hour` '
                . ' FROM `patients` '
                . ' LEFT JOIN `appointments` '
                . ' ON `patients`.`id` = `appointments`.`idPatients` '
                . ' WHERE `patients`.`id` = :id';
        $request = $this->db->prepare($requestToDisplayPatientInfoWithHisId);

        $request->bindValue(':id', $this->id, PDO::PARAM_INT);

        $request->execute();

        return $request->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Méthode qui permet de retourner 1 si le patient existe et 0 si il n'existe pas
     * @return obj
     */
    public function checkIfThePatientExistsByHisId() {
        $requestTocheckIfPatientExist = 'SELECT COUNT(`id`) AS `exist` '
                . ' FROM `patients` '
                . ' WHERE `id` = :id;';

        $request = $this->db->prepare($requestTocheckIfPatientExist);

        $request->bindValue(':id', $this->id, PDO::PARAM_INT);

        $request->execute();

        return $request->fetch(PDO::FETCH_OBJ);
    }

    public function changeDataOfAPatient() {
        $queryTochangeDataOfAPatient = 'UPDATE `patients` '
                . ' SET `lastname` = :lastname, `firstname` = :firstname, `birthdate` = :birthdate, `phone` = :phone, `mail` = :mail '
                . ' WHERE `id` = :id';

        $query = $this->db->prepare($queryTochangeDataOfAPatient);

        $query->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $query->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $query->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $query->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $query->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $query->bindValue(':id', $this->id, PDO::PARAM_INT);

        $query->execute();
    }

    public function searchAPatientToTakeRdv() {
        $queryToSearchAPatientToTakeRdv = 'SELECT `lastname`, `firstname`, DATE_FORMAT(`birthdate`, \'%d/%m/%Y\') AS `birthdate`, `phone`, `mail`, id '
                . ' FROM `patients` '
                . ' WHERE `lastname` LIKE UPPER(:lastname) AND `firstname` LIKE :firstname';

        $query = $this->db->prepare($queryToSearchAPatientToTakeRdv);

        $query->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $query->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function displayFirstnameLastnameBirthdateAndGetId() {
        $queryToDisplayFirstnameLastnameBirthdateAndGetId = 'SELECT `lastname`, `firstname`, DATE_FORMAT(`birthdate`, \'%d/%m/%Y\') AS birthdate, id '
                . ' FROM `patients`';

        $query = $this->db->query($queryToDisplayFirstnameLastnameBirthdateAndGetId);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteAPatintAndHisAppointments() {
        $queryToDeleteAPatintAndHisAppointments = 'DELETE '
                . ' FROM `patients` '
                . ' WHERE `patients`.`id` = :id';

        $query = $this->db->prepare($queryToDeleteAPatintAndHisAppointments);

        $query->bindValue(':id', $this->id, PDO::PARAM_INT);

        $query->execute();
    }

    public function countNumberOfPatient() {
        $queryToCountNumberOfPatient = ' SELECT COUNT(`id`) AS `numberOfPatient` '
                . ' FROM `patients`';

        $query = $this->db->query($queryToCountNumberOfPatient);

        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function selectIdByFirstnameLastnameAndBirthdate() {
        $query = 'SELECT `id` '
                . 'FROM `patients` '
                . 'WHERE `lastname` LIKE UPPER(:lastname) '
                . 'AND `firstname` LIKE :firstname '
                . 'AND `birthdate` LIKE :birthdate';
        
        $pdoStatment = $this->db->prepare($query);
        
        $pdoStatment->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatment->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatment->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        
        $pdoStatment->execute();
        
        return $pdoStatment->fetch(PDO::FETCH_OBJ);
        
    }

}
