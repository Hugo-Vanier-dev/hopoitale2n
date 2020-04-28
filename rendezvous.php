<?php
require_once 'models/database.php';
require_once 'models/patients.php';
require_once 'models/appointments.php';
require_once 'controllers/rendezvousCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
        <link rel="stylesheet" href="assets/css/style.css" />
        <title>Hospital E2N|Information RDV</title>
    </head>
    <body>
        <div class="container-fluid">
            <?php include_once 'navbar.php'; ?>
            <div class="row">
                <div class="col-md-2 rectBlue"></div>
                <div class="col-md-8">
                    <h1>Information du rendez-vous</h1>
                    <?php
                    if (isset($appointmentInfo)) {
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    <li class="mt-3">Date du Rdv : <span class="text-info"><?= $appointmentInfo->frenchDate ?></span></li>
                                    <li class="mt-3">Heure du Rdv : <span class="text-info"><?= $appointmentInfo->hour ?></span></li>
                                    <li class="mt-3">Nom : <?= $appointmentInfo->lastname ?></li>
                                    <li class="mt-3">Prénom : <?= $appointmentInfo->firstname ?></li>
                                    <li class="mt-3">Date de naissance : <?= $appointmentInfo->frenchBirthdate ?></li>
                                    <li class="mt-3">Téléphone : <?= $appointmentInfo->phone ?></li>
                                    <li class="mt-3">Mail : <?= $appointmentInfo->mail ?></li>                                    
                                </ul>
                                <button class="btn btn-success offset-2 displayForm">Modifier</button>
                            </div>
                            <div class="col-md-6 displayedForm">
                                <form method="POST" action="rendezvous.php?id=<?= $_GET['id'] ?>">
                                    <div class="row">
                                        <label for="frenchDate" class="col-md-6">Nouvelle date :</label>
                                        <input type="date" name="frenchDate" id="frenchDate" class="col-md-6" value="<?= $appointmentInfo->sqlDate ?>" />
                                    </div>
                                    <?php if (isset($fromErrorModifyAppointment['frenchDate'])) { ?>
                                        <p class="offset-6 text-danger"><?= $fromErrorModifyAppointment['frenchDate'] ?></p>
                                    <?php } ?>
                                    <div class="row mt-3">
                                        <label for="hour" class="col-md-6">Nouvelle heure :</label>
                                        <input type="time" max="19:00" min="08:00" step=900 name="hour" id="hour" class="col-md-6" value="<?= $appointmentInfo->hour ?>" />
                                    </div>
                                    <?php if (isset($fromErrorModifyAppointment['hour'])) { ?>
                                        <p class="offset-6 text-danger"><?= $fromErrorModifyAppointment['hour'] ?></p>
                                    <?php } ?>
                                    <input type="submit" name="modifyInfoAppointment" id="modifyInfoAppointment" value="valider les changements" class="btn btn-success offset-4 mt-4" />
                                </form>
                            </div>
                        </div>    
                        <?php
                    } else {
                        ?>
                    <div class="row text-center mt-4">
                    <p class="text-danger resultMessageForForm"><?= $messageError ?></p>
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
        <script src="assets/js/scipt.js"></script>    
    </body>
</html>
