<?php
require_once 'models/database.php';
require_once 'models/patients.php';
require_once 'controllers/profil-patientCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <title>Hospital E2N|Information Patient</title>
    </head>
    <body>
        <div class="container-fluid">
            <?php include_once 'navbar.php'; ?>
            <div class="row">
                <div class="col-md-2 rectBlue"></div>
                <div class="col-md-8">
                    <h1>Information du patient</h1>
                    <?php
                    if (isset($patientInfo)) {
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    <li class="mt-3">Nom : <?= $patientInfo[0]->lastname ?></li>
                                    <li class="mt-3">Prénom : <?= $patientInfo[0]->firstname ?></li>
                                    <li class="mt-3">Date de naissance : <?= $patientInfo[0]->frenchBirthdate ?></li>
                                    <li class="mt-3">Téléphone : <?= $patientInfo[0]->phone ?></li>
                                    <li class="mt-3">Mail : <?= $patientInfo[0]->mail ?></li>                                    
                                    <?php
                                    if ($patientInfo[0]->frenchDate != null && $patientInfo[0]->hour != null) {
                                        foreach ($patientInfo as $appoitmentOfThePatient) {
                                            ?>
                                            <li class="mt-3">A rendez-vous le <?= $appoitmentOfThePatient->frenchDate ?> à <?= $appoitmentOfThePatient->hour ?></li>   
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <button class="btn btn-success offset-2 displayForm">Modifier</button>
                            </div>
                            <div class="col-md-6 displayedForm">
                                <form method="POST" action="profil-patient.php?id=<?= $_GET['id'] ?>">
                                    <div class="row">
                                        <label for="lastname" class="col-md-6">Nouveau nom :</label>
                                        <input type="text" name="lastname" id="lastname" class="col-md-6" value="<?= $patientInfo[0]->lastname ?>" />
                                    </div>
                                    <?php if (isset($fromErrorModifyPatient['lastname'])) { ?>
                                        <p class="offset-6 text-danger"><?= $fromErrorModifyPatient['lastname'] ?></p>
                                    <?php } ?>
                                    <div class="row mt-3">
                                        <label for="firstname" class="col-md-6">Nouveau prénom :</label>
                                        <input type="text" name="firstname" id="firstname" class="col-md-6" value="<?= $patientInfo[0]->firstname ?>" />
                                    </div>
                                    <?php if (isset($fromErrorModifyPatient['firstname'])) { ?>
                                        <p class="offset-6 text-danger"><?= $fromErrorModifyPatient['firstname'] ?></p>
                                    <?php } ?>    
                                    <div class="row mt-3">
                                        <label for="birthdate" class="col-md-6">Nouvelle date de naissace :</label>
                                        <input type="date" name="birthdate" id="birthdate" class="col-md-6" value="<?= $patientInfo[0]->birthdate ?>" />                                        
                                    </div>
                                    <?php if (isset($fromErrorModifyPatient['birthdate'])) { ?>
                                        <p class="offset-6 text-danger"><?= $fromErrorModifyPatient['birthdate'] ?></p>
                                    <?php } ?>    
                                    <div class="row mt-3">
                                        <label for="phone" class="col-md-6">Nouveau téléphone :</label>
                                        <input type="text" name="phone" id="phone" class="col-md-6" value="<?= $patientInfo[0]->phone ?>" />
                                    </div> 
                                    <?php if (isset($fromErrorModifyPatient['phone'])) { ?>
                                        <p class="offset-6 text-danger"><?= $fromErrorModifyPatient['phone'] ?></p>
                                    <?php } ?>
                                    <div class="row mt-3">
                                        <label for="mail" class="col-md-6">Nouveau mail :</label>
                                        <input type="text" name="mail" id="mail" class="col-md-6" value="<?= $patientInfo[0]->mail ?>" />
                                    </div> 
                                    <?php if (isset($fromErrorModifyPatient['mail'])) { ?>
                                        <p class="offset-6 text-danger"><?= $fromErrorModifyPatient['mail'] ?></p>
                                    <?php } ?>
                                    <input type="submit" name="modifyInfoPatient" id="modifyInfoPatient" value="valider les changements" class="btn btn-success offset-4 mt-4" />
                                </form>
                            </div>
                        </div>    
                        <?php
                    } else {
                        ?>
                        <div class="row text-center mt-4">
                            <p class="text-danger resultMessageForForm">Il y a eu un problème lors de l'envoie d'information, veuillez réessayer</p>
                        </div>
                    <?php }
                    ?>
                    <?php if (isset($didPatientGetAdd)) { ?>
                        <div class="row text-center mt-4">
                            <p class="<?= $classDiDPatientGetAdd ?> col-md-12 resultMessageForForm"><?= $didPatientGetAdd ?></p>
                        </div>                          
                    <?php } ?>     
                </div>
                <div class="col-md-2 rectBlue"></div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="/assets/js/scipt.js"></script>    
    </body>
</html> 
