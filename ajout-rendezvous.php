<?php
require_once 'models/database.php';
require_once 'models/patients.php';
require_once 'models/appointments.php';
require_once 'controllers/ajout-rendezvousCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/chosen.min.css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
        <link rel="stylesheet" href="/assets/css/style.css" />
        <title>Hospital E2N|Information Patient</title>
    </head>
    <body>
        <div class="container-fluid">
            <?php include_once 'navbar.php'; ?>
            <div class="row">
                <div class="col-md-2 rectBlue"></div>
                <div class="col-md-8">
                    <h1>Information du patient</h1>
                    <form action="ajout-rendezvous.php" method="POST">
                        <div class="row d-flex justify-content-center">
                            <select name="getPatientId" class="col-md-5" id="getPatientId">
                                <option disabled <?php
                                if (empty($_POST['getPatientId'])) {
                                    echo 'selected';
                                }
                                ?>>Veulliez séléctionné un patient</option>
                                        <?php foreach ($patientList as $patientInfo) { ?>
                                    <option value="<?= $patientInfo->id ?>" <?php
                                    if (!empty($_POST['getPatientId']) && $_POST['getPatientId'] == $patientInfo->id) {
                                        echo 'selected';
                                    }
                                    ?>><?= $patientInfo->lastname . ' ' . $patientInfo->firstname . ' ' . $patientInfo->birthdate ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <?php if (isset($formErrorAddRDV['getPatientId'])) { ?>
                            <div class="row d-flex justify-content-center mt-2">
                                <p class="text-danger"><?= $formErrorAddRDV['getPatientId'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row d-flex justify-content-center mt-5">
                            <label for="rdvDate" class="col-md-3 text-right">Date du RDV:</label>
                            <input type="date" min="<?= $thisYear . '-' . $thisMonth . '-' . $thisDay ?>" id="rdvDate" name="rdvDate" class="col-md-4" value="<?php
                            if (isset($formErrorAddRDV)) {
                                echo $_POST['rdvDate'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($formErrorAddRDV['rdvDate'])) { ?>
                            <div class="row d-flex justify-content-center mt-2">
                                <p class="text-danger"><?= $formErrorAddRDV['rdvDate'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row d-flex justify-content-center mt-5">
                            <label for="rdvHour" class="col-md-3 text-right">Heure du RDV :</label>
                            <input type="time" max="19:00" min="08:00" step=900 id="rdvHour" name="rdvHour" class="col-md-4" value="<?php
                            if (isset($formErrorAddRDV)) {
                                echo $_POST['rdvHour'];
                            }
                            ?>"  />
                        </div>
                        <?php if (isset($formErrorAddRDV['rdvHour'])) { ?>
                            <div class="row d-flex justify-content-center mt-2">
                                <p class="text-danger"><?= $formErrorAddRDV['rdvHour'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row d-flex justify-content-center mt-5">
                            <input type="submit" name="submitInfoRdv" id="submitInfoRdv"  value="Ajouter un RDV" class="btn btn-success cold-md-3"/>
                        </div>
                    </form>
                    <?php if (isset($messageEndInfo)) { ?>
                        <div class="row d-flex justify-content-center mt-5">
                            <p class="<?= $classMessageEndInfo ?>"><?= $messageEndInfo ?></p>
                        </div>
                    <?php } ?>
                </div>             
                <div class="col-md-2 rectBlue"></div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="assets/js/chosen.jquery.min.js"></script>
        <script src="assets/js/scipt.js"></script>    
    </body>
</html> 
