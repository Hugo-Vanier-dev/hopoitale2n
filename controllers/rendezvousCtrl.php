<?php

$regexNumber = '/^[0-9]+$/';
$regexBirthdate = '/^[0-9]{4}\-((0[1-9])|(1[0-2]))\-((0[1-9])|([12][0-9])|(3[01]))$/';
$regexHour = '/^[0-9]{2}:[0-9]{2}$/';
//On récupère l'année, le mois et le jour actuel.
$thisYear = date('Y');
$thisMonth = date('m');
$thisDay = date('d');
$thisHour = date('H');
$thisMin = date('i');

if (isset($_GET['id'])) {
    if (filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $appointment = new appointments();
        $appointment->id = htmlspecialchars($_GET['id']);
        $isAppointmentExist = $appointment->checkIfTheAppointmentExistsByHisId();
        if ($isAppointmentExist->exist == 1) {
            if (isset($_POST['modifyInfoAppointment'])) {
                if (!empty($_POST['frenchDate'])) {
                    if (preg_match($regexBirthdate, $_POST['frenchDate'])) {
                        $returnTabRdvDate = explode('-', $_POST['frenchDate']);
                        $year = $returnTabRdvDate[0];
                        $month = $returnTabRdvDate[1];
                        $day = $returnTabRdvDate[2];
                        if ($year > $thisYear || $year == $thisYear && $month > $thisMonth || $year == $thisYear && $month == $thisMonth && $day >= $thisDay) {
                            $appointmentDate = htmlspecialchars($_POST['frenchDate']);
                        } else {
                            $fromErrorModifyAppointment['frenchDate'] = 'Veuillez ne pas prendre une date passé';
                        }
                    } else {
                        $fromErrorModifyAppointment['frenchDate'] = 'Veuillez utilisé le champ qui ouvre un calendrier à votre disposition si vous n\'avez pas de calendrier entrer la date sous la forme année-mois-jour';
                    }
                } else {
                    $fromErrorModifyAppointment['frenchDate'] = 'Veuillez remplir le champ pour la date du rendez-vous';
                }
                if (!empty($_POST['hour'])) {
                    if (preg_match($regexHour, $_POST['hour']) && preg_match($regexBirthdate, $_POST['frenchDate'])) {
                        $returnTabRdvTime = explode(':', $_POST['hour']);
                        $hour = $returnTabRdvTime[0];
                        $minute = $returnTabRdvTime[1];
                        if ($year == $thisYear && $month == $thisMonth && $day == $thisDay) {
                            if ($hour > $thisHour || $hour == $thisHour && $minute > $thisMin) {
                                $appointementTime = htmlspecialchars($_POST['hour']);
                            } else {
                                $fromErrorModifyAppointment['hour'] = 'Cette heure est déjà passé';
                            }
                        } else {
                            $appointementTime = htmlspecialchars($_POST['hour']);
                        }
                    } else {
                        $fromErrorModifyAppointment['hour'] = 'Veuillez utilisé le champ à votre disposition si vous n\'avez pas de champ spécifique à l\'heure entrer l\'heure sous la forme heure:minute';
                    }
                } else {
                    $fromErrorModifyAppointment['hour'] = 'Veuillez remplir l\heure';
                }
                if (!isset($fromErrorModifyAppointment)) {
                    $appointementDateTime = $appointmentDate . ' ' . $appointementTime;
                    $appointment->dateHour = $appointementDateTime;
                    $appointment->changeDataOfAnAppoitment();
                } else {
                    $messageError = 'Le patient n\'as pas été modifié';
                }
            }
            $appointmentInfo = $appointment->getAllAppointmentInfoByHisId();
        } else {
            $messageError = 'Il semblerait que le rendez-vous séléctionné n\'existe pas';
        }
    } else {
        $messageError = 'Il que le rendez-vous séléctionné n\'existe pas';
    }
} else {
    $messageError = 'Il y a eu un problème lors de l\'envoie de donné';
}
