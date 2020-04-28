<?php
$ajax = false;
//On vérifie que l'ajax marche sur l'ordinateur de l'utilisateur
if (isset($_GET['searchPatients'])) {
    include_once '../models/database.php';
    include_once '../models/patients.php';
    $patient = new patients();
    $ajax = true;
//On inclue dans l'ajax notre models patient
    header('Content-type: application/json');
//On instancie l'objet patient
//On récupère et stocke la valeur renvoyé par l'ajax
    $searchArray = array();
    $searchArray['lastname'] = '%' . htmlspecialchars($_GET['searchPatients']) . '%';
    $searchArray['firstname'] = '%' . htmlspecialchars($_GET['searchPatients']) . '%';
    $searchArray['mail'] = '%' . htmlspecialchars($_GET['searchPatients']) . '%';
    $searchArray['phone'] = '%' . htmlspecialchars($_GET['searchPatients']) . '%';
//On vérifie que notre param page passer en get existe
    $offset = 0;
    $patientList = $patient->searchAPatient($searchArray, $offset);
//On renvoie à notre script ce qu'il doit affiché
    echo json_encode($patientList);
} else {
    $ajax = false;
    $patient = new patients();
    $page = 1;
    $offset = 0;
    $search = array();
    $patientNumbers = $patient->countNumberOfPatient();
    $pageNumbers = ceil($patientNumbers->numberOfPatient / 10);
    if (isset($_GET['page'])) {
        if (filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ($_GET['page'] <= $pageNumbers) {
                $page = htmlspecialchars(intval($_GET['page']));
                $offset = ($page - 1) * 10;
            } else {
                header('location:liste-patients.php?page=1');
            }
        } else {
            header('location:liste-patients.php?page=1');
        }
    } else {
        header('location:liste-patients.php?page=1');
    }
    $patientList = $patient->searchAPatient($search, $offset);
}
//Si le $get id existe
if (isset($_GET['id'])) {
//qu'il est un entier
    if (is_numeric($_GET['id'])) {
//qu'il est un entier
        if (preg_match($regexNumber, $_GET['id'])) {
//On supprime un patient dont l'id est = au param passer en get
            $patient = new patients();
            $patient->id = htmlspecialchars($_GET['id']);
            $didPatientExist = $patient->checkIfThePatientExistsByHisId();
            if ($didPatientExist->exist == 1) {
                $patient->deleteAPatintAndHisAppointments();
            }
        }
    }
}

