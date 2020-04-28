<?php

$regexNumber = '/^[0-9]+$/';
$regexDate = '/^[0-9]{4}\-((0[1-9])|(1[0-2]))\-((0[1-9])|([12][0-9])|(3[01]))$/';
$regexHour = '/^[0-9]{2}:[0-9]{2}$/';
//On récupère l'année, le mois et le jour actuel.
$thisYear = date('Y');
$thisMonth = date('m');
$thisDay = date('d');
$thisHour = date('H');
$thisMin = date('i');
//On instancie un nouvel objet patient
$patient = new patients();
//On appelle la méthode displayPatientList de class patient
$patientList = $patient->displayFirstnameLastnameBirthdateAndGetId();

//Si on a appuyé sur le bouton Ajouter un RDV
if (isset($_POST['submitInfoRdv'])) {
    //J'instancie ma class appointment
    $appointment = new appointments();
    //Si mon champ date de Rdv n'est pas vide
    if (!empty($_POST['rdvDate'])) {
        //Je vérifie que l'entrée($_POST['rdvDate']) est bien conforme au format ($regexDate) attendue
        if (preg_match($regexDate, $_POST['rdvDate'])) {
            /*
             * On utilise une fonction php appellé explode qui prend en paramètre un séparateur et une chaîne de caractère
             * A chaque fois que dans notre chaîne de caractère on rencontre notre séparateur ('-')
             * Tout ce qui se situe entre le début de notre chaîne ou un séparateur devient une nouvelle chaîne
             * stocker dans notre tableau indexé $returnTabRdvDate.
             */
            $returnTabRdvDate = explode('-', $_POST['rdvDate']);
            //On stoque l'année retourner dans une variable $year
            $year = $returnTabRdvDate[0];
            //On stoque l'année retourner dans une variable $month
            $month = $returnTabRdvDate[1];
            //On stoque l'année retourner dans une variable $day
            $day = $returnTabRdvDate[2];
            /*
             * Si l'année entrée est supérieure à celle en cours ou
             * Si l'année entrée est égale à celle en cours et  le mois est supérieur ou
             * Si l'année entrée est égale et le mois entré est égal et le jour est supérieur ou égal.
             * Alors on attribue à $appointmentDate notre $_POST['rdvDate']
             * Sinon on stocke dans notre tableau d'erreur un message.
             */
            if ($year > $thisYear || ( $year == $thisYear && $month > $thisMonth) || ($year == $thisYear && $month == $thisMonth && $day >= $thisDay)) {
                $appointmentDate = htmlspecialchars($_POST['rdvDate']);
            } else {
                $formErrorAddRDV['rdvDate'] = 'Veuillez ne pas prendre une date passée';
            }
        } else {
            $formErrorAddRDV['rdvDate'] = 'Veuillez utiliser le champ qui ouvre un calendrier à votre disposition si vous n\'avez pas de calendrier entrer la date sous la forme année-mois-jour';
        }
    } else {
        $formErrorAddRDV['rdvDate'] = 'Veuillez remplir le champ pour la date du rendez-vous';
    }
    if (!empty($_POST['rdvHour'])) {
        if (preg_match($regexHour, $_POST['rdvHour'])) {
            $returnTabRdvTime = explode(':', $_POST['rdvHour']);
            $hour = $returnTabRdvTime[0];
            $minute = $returnTabRdvTime[1];
            if ($year == $thisYear && $month == $thisMonth && $day == $thisDay) {
                if ($hour > $thisHour || ($hour == $thisHour && $minute > $thisMin)) {
                    $appointementTime = htmlspecialchars($_POST['rdvHour']);
                } else {
                    $formErrorAddRDV['rdvHour'] = 'Cette heure est déjà passé';
                }
            } else {
                $appointementTime = htmlspecialchars($_POST['rdvHour']);
            }
        } else {
            $formErrorAddRDV['rdvHour'] = 'Veuillez utilisé le champ à votre disposition si vous n\'avez pas de champ spécifique à l\'heure entrer l\'heure sous la forme heure:minute';
        }
    } else {
        $formErrorAddRDV['rdvHour'] = 'Veuillez remplir l\heure';
    }
    if (!empty($_POST['getPatientId'])) {
        if (preg_match($regexNumber, $_POST['getPatientId'])) {
            $appointment->idPatients = htmlspecialchars($_POST['getPatientId']);
        } else {
            $formErrorAddRDV['getPatientId'] = 'Veuillez choisir un patient';
        }
    } else {
        $formErrorAddRDV['getPatientId'] = 'Veuillez choisir un patient';
    }
    //Si notre tableau d'erreur n'existe pas
    if (!isset($formErrorAddRDV)) {
        //On concatène notre date et notre time en datetime puis on l'envoie dans notre objet $appointment
        $appointment->dateHour = $appointmentDate . ' ' . $appointementTime;
        $rdvExist = $appointment->checkIfRdvExistByAllHisAttribute();
        if ($rdvExist->exist == 0) {
            $appointment->takeAppointementForAPatient();
            $messageEndInfo = 'Le rendez-vous a bien été pris';
            $classMessageEndInfo = 'text-success';
        } else {
            $messageEndInfo = 'Il y a eu un problème lors de la transmission de données';
            $classMessageEndInfo = 'text-danger';
        }
    } else {
        $messageEndInfo = 'Il y a une erreur dans le formulaire';
        $classMessageEndInfo = 'text-danger';
    }
}