<?php
$regexName = '/^[a-zA-ZâêôûÄéÆÇàèÊùÌÍÎÏÐîÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ][A-Za-zâêôûéàèùîÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ\s-]+$/';
$regexBirthdate = '/^[0-9]{4}\-((0[1-9])|(1[0-2]))\-((0[1-9])|([12][0-9])|(3[01]))$/';
//On récupère l'année, le mois et le jour actuel.
$thisYear = date('Y');
$thisMonth = date('m');
$thisDay = date('d');
$regexPhone = '/^(0[1-79])([\s.-_\/]?(\d{2})){4}$/';
$regexPhoneExplode = '/^(0[1-79])([\s.-_\/](\d{2})){4}$/';

function multiexplode($delimiters, $string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}
/* On vérifie l'existence du get id et son type si les deux condition retourne vrai
  On lance notre fonction permettant d'afficher les informations d'un patient avec get en param */
if (!empty($_GET['id'])) {
    $patient = new patients();
    $patient->id = htmlspecialchars($_GET['id']);
    $patientCount = $patient->checkIfThePatientExistsByHisId();
    if ($patientCount->exist == 1) {
        if (isset($_POST['modifyInfoPatient'])) {
            if (!empty($_POST['firstname'])) {
                if (preg_match($regexName, $_POST['firstname'])) {
                    $patient->firstname = htmlspecialchars($_POST['firstname']);
                } else {
                    $fromErrorModifyPatient['firstname'] = 'Vous avez mal rempli le prénom, attention il ne doit pas y avoir d\'espace au début';
                }
            } else {
                $fromErrorModifyPatient['firstname'] = 'Veuillez remplir le champ prénom';
            }
            if (!empty($_POST['lastname'])) {
                if (preg_match($regexName, $_POST['lastname'])) {
                    $patient->lastname = htmlspecialchars($_POST['lastname']);
                } else {
                    $fromErrorModifyPatient['lastname'] = 'Vous avez mal rempli le nom, attention il ne doit pas y avoir d\'espace au début';
                }
            } else {
                $fromErrorModifyPatient['lastname'] = 'Veuillez remplir le champ nom';
            }
            if (!empty($_POST['birthdate'])) {
                if (preg_match($regexBirthdate, $_POST['birthdate'])) {
                    $returnTabBirthdate = explode('-', $_POST['birthdate']);
                    $year = $returnTabBirthdate[0];
                    $month = $returnTabBirthdate[1];
                    $day = $returnTabBirthdate[2];
                    //On vérifie que l'année choisi par l'utilisateur est inférieur a l'année actuelle
                    if ($year < $thisYear && $thisYear >= 1920 && checkdate($month, $day, $year)) {
                        $patient->birthdate = htmlspecialchars($_POST['birthdate']); // strtags va supprimer les tags, cad des elements ex, il voit un chevron, il le supprime alors que htmlspecialchars va proteger le chevron et l'ecrire dans un autre language pour devenir inoffensif 
                        //si l'anné séléctionné est égale à l'année en cours on vérifie que le mois est inférieur          
                    } elseif ($year == $thisYear && $month < $thisMonth && checkdate($month, $day, $year)) {
                        $patient->birthdate = htmlspecialchars($_POST['birthdate']); // strtags va supprimer les tags, cad des elements ex, il voit un chevron, il le supprime alors que htmlspecialchars va proteger le chevron et l'ecrire dans un autre language pour devenir inoffensif
                        //Si l'année séléctionnée est égale à l'année en cours que le mois séléctionné est égale au mois en cours on vérifie que le jour séléctionné est inférieur à aujourd'hui                
                    } elseif ($year == $thisYear && $month == $thisMonth && $day <= $thisDay && checkdate($month, $day, $year)) {
                        $patient->birthdate = htmlspecialchars($_POST['birthdate']);
                        //Si les conditions pour vérifier que la date est comprise entre 1920 est aujourd'hui ne sont pas respecté on envoie un message d'erreur
                    } else {
                        $fromErrorModifyPatient['birthdate'] = 'La date séléctionnée doit être contenue entre 1920 et aujourd\'hui';
                    }
                } else {
                    $fromErrorModifyPatient['birthdate'] = 'Veuillez utilisé le champ qui ouvre un calendrier à votre disposition si vous n\'avez pas de calendrier entrer la date sous la forme année-mois-jour';
                }
            } else {
                $fromErrorModifyPatient['birthdate'] = 'Veuillez renseigner votre date de naissance';
            }
            if (!empty($_POST['phone'])) {
                if (preg_match($regexPhone, $_POST['phone'])) {
                    if (preg_match($regexPhoneExplode, $_POST['phone'])) {
                        $phoneNumbersTab = multiexplode(array('-', '.', '/', ' ', '_'), $_POST['phone']);
                        $phone = $phoneNumbersTab[0] . $phoneNumbersTab[1] . $phoneNumbersTab[2] . $phoneNumbersTab[3] . $phoneNumbersTab[4];
                        $patient->phone = htmlspecialchars($phone);
                    } else {
                        $patient->phone = htmlspecialchars($_POST['phone']);
                    }
                } else {
                    $fromErrorModifyPatient['phone'] = 'Veuillez renseigner un numero de téléphone français valide';
                }
            } else {
                $fromErrorModifyPatient['phone'] = 'Veuillez renseigner un numero de téléphone';
            }
            if (!empty($_POST['mail'])) {
                if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                    $patient->mail = htmlspecialchars($_POST['mail']);
                } else {
                    $fromErrorModifyPatient['mail'] = 'Veuillez renseigner une adresse mail valide';
                }
            } else {
                $fromErrorModifyPatient['mail'] = 'Veuillez renseigner une adresse mail';
            }
            if (!isset($fromErrorModifyPatient)) {
                $patient->changeDataOfAPatient();
                $didPatientGetAdd = 'Le patient à bien été modifié';
                $classDiDPatientGetAdd = 'text-success';
            } else {
                $didPatientGetAdd = 'La modification n\'as pas eu lieu';
                $classDiDPatientGetAdd = 'text-danger';
            }
        }
        $patientInfo = $patient->displayPatientInfoWithHisId();
    } else {
        header('location:liste-patients.php');
    }
} else {
    header('location:liste-patients.php');
}
