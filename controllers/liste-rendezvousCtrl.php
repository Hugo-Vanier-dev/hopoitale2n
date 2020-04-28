<?php

$regexNumber = '/^[0-9]+$/';
$appointment = new appointments();

if (isset($_GET['id'])) {
    if (is_numeric($_GET['id'])) {
        if (preg_match($regexNumber, $_GET['id'])) {
            $appointment->id = htmlspecialchars($_GET['id']);
            $didAppointmentExist = $appointment->checkIfTheAppointmentExistsByHisId();
            if ($didAppointmentExist->exist == 1) {
                $appointment->deleteAnAppoitment();
            }
        }
    }
}
$appointmentList = $appointment->showRdvList();

