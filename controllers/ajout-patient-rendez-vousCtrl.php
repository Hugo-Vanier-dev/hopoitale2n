<?php

$regexName = '/^[a-zA-ZâêôûÄéÆÇàèÊùÌÍÎÏÐîÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ][A-Za-zâêôûéàèùîÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ\s-]+$/';
$regexDate = '/^[0-9]{4}\-((0[1-9])|(1[0-2]))\-((0[1-9])|([12][0-9])|(3[01]))$/';
$regexHour = '/^[0-9]{2}:[0-9]{2}$/';
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

if (isset($_POST['submitPatientRdvForm'])) {
    $patient = new patients();
    $appointment = new appointments();
    if (!empty($_POST['firstname'])) {
        if (preg_match($regexName, $_POST['firstname'])) {
            $patient->firstname = htmlspecialchars($_POST['firstname']);
        } else {
            $fromErrorSubmitPatientRdv['firstname'] = 'Vous avez mal rempli le prénom, attention il ne doit pas y avoir d\'espace au début';
        }
    } else {
        $fromErrorSubmitPatientRdv['firstname'] = 'Veuillez remplir le champ prénom';
    }

    if (!empty($_POST['lastname'])) {
        if (preg_match($regexName, $_POST['lastname'])) {
            $patient->lastname = htmlspecialchars($_POST['lastname']);
        } else {
            $fromErrorSubmitPatientRdv['lastname'] = 'Vous avez mal rempli le nom, attention il ne doit pas y avoir d\'espace au début';
        }
    } else {
        $fromErrorSubmitPatientRdv['lastname'] = 'Veuillez remplir le champ nom';
    }
    if (!empty($_POST['birthdate'])) {
        if (preg_match($regexDate, $_POST['birthdate'])) {
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
                $fromErrorSubmitPatientRdv['birthdate'] = 'La date séléctionnée doit être contenue entre 1920 et aujourd\'hui';
            }
        } else {
            $fromErrorSubmitPatientRdv['birthdate'] = 'Veuillez utilisé le champ qui ouvre un calendrier à votre disposition si vous n\'avez pas de calendrier entrer la date sous la forme année-mois-jour';
        }
    } else {
        $fromErrorSubmitPatientRdv['birthdate'] = 'Veuillez renseigner votre date de naissance';
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
            $fromErrorSubmitPatientRdv['phone'] = 'Veuillez renseigner un numero de téléphone français valide';
        }
    } else {
        $fromErrorSubmitPatientRdv['phone'] = 'Veuillez renseigner un numero de téléphone';
    }

    if (!empty($_POST['mail'])) {
        if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $patient->mail = htmlspecialchars($_POST['mail']);
        } else {
            $fromErrorSubmitPatientRdv['mail'] = 'Veuillez renseigner une adresse mail valide';
        }
    } else {
        $fromErrorSubmitPatientRdv['mail'] = 'Veuillez renseigner une adresse mail';
    }
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
                $fromErrorSubmitPatientRdv['rdvDate'] = 'Veuillez ne pas prendre une date passée';
            }
        } else {
            $fromErrorSubmitPatientRdv['rdvDate'] = 'Veuillez utiliser le champ qui ouvre un calendrier à votre disposition si vous n\'avez pas de calendrier entrer la date sous la forme année-mois-jour';
        }
    } else {
        $fromErrorSubmitPatientRdv['rdvDate'] = 'Veuillez remplir le champ pour la date du rendez-vous';
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
            $fromErrorSubmitPatientRdv['rdvHour'] = 'Veuillez utilisé le champ à votre disposition si vous n\'avez pas de champ spécifique à l\'heure entrer l\'heure sous la forme heure:minute';
        }
    } else {
        $fromErrorSubmitPatientRdv['rdvHour'] = 'Veuillez remplir l\heure';
    }
    if (!isset($fromErrorSubmitPatientRdv)) {
        $isPatientExist = $patient->checkIfPatientExists();
        $appointment->dateHour = $appointmentDate . ' ' . $appointementTime;
        if (!$isPatientExist->patientExist) {
            $didPatientGetAdd = 'pb au niveau de la transac';
            $classDiDPatientGetAdd = ' text-danger';
            try {
                $patient->db->beginTransaction();
                $patient->pushAnewPatientToDb();
                $appointment->idPatients = $patient->db->lastInsertId();
                $appointment->takeAppointementForAPatient();
                $patient->db->commit();
            } catch (Exception $ex) {
                $didPatientGetAdd = 'Le patient n\'as pas été ajouté';
                $classDiDPatientGetAdd = 'text-danger';
                $patient->db->rollBack();
            }
            $didPatientGetAdd = 'Le patient a bien été ajouté';
            $classDiDPatientGetAdd = 'text-success';
        } else {
            $appointment->idPatients = $patient->selectIdByFirstnameLastnameAndBirthdate()->id;
            $appointment->takeAppointementForAPatient();
            $didPatientGetAdd = 'Le patient existait déjà le rendez-vous a bien été ajouté';
            $classDiDPatientGetAdd = 'text-success';
        }
    } else {
        $didPatientGetAdd = 'Le patient n\'as pas été ajouté';
        $classDiDPatientGetAdd = 'text-danger';
    }
}
