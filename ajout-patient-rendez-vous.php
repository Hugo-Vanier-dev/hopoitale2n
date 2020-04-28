<?php
require_once 'models/database.php';
require_once 'models/appointments.php';
require_once 'models/patients.php';
require_once 'controllers/ajout-patient-rendez-vousCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <title>Hospital E2N|ajout-patient</title>
    </head>
    <body>
        <div class="container-fluid">
            <?php include_once 'navbar.php'; ?>
            <div class="row">
                <div class="col-md-2 rectBlue"></div>
                <div class="col-md-8">
                    <h1>Ajouter un patient</h1>
                    <form method="POST" action="/ajout-patient-rendez-vous.php" class="needs-validation" >
                        <div class="row">
                            <label for="firstname" class="col-md-5 text-right">Prénom :</label>
                            <input type="text" name="firstname" id="firstname" class="col-md-3 form-control <?php (isset($_POST['firstname']) ? (isset($fromErrorSubmitPatientRdv['firstname']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatientRdv)) {
                                echo $_POST['firstname'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatientRdv['firstname'])) { ?>
                            <div class="row">
                                <p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatientRdv['firstname'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="lastname" class="col-md-5 text-right">Nom :</label>
                            <input type="text" name="lastname" id="lastname" class="col-md-3 form-control <?php (isset($_POST['lastname']) ? (isset($fromErrorSubmitPatientRdv['lasstname']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatientRdv)) {
                                echo $_POST['lastname'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatientRdv['lastname'])) { ?>
                            <div class="row"><p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatientRdv['lastname'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="birthdate" class="col-md-5 text-right">Date de naissance :</label>
                            <input type="date" name="birthdate" id="birthdate" class="col-md-3 form-control <?php (isset($_POST['birthdate']) ? (isset($fromErrorSubmitPatientRdv['birthdate']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatientRdv)) {
                                echo $_POST['birthdate'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatientRdv['birthdate'])) { ?>
                            <div class="row"><p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatientRdv['birthdate'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="phone" class="col-md-5 text-right">Téléphone :</label>
                            <input type="text" name="phone" id="phone" class="col-md-3 form-control <?php (isset($_POST['phone']) ? (isset($fromErrorSubmitPatientRdv['phone']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatientRdv)) {
                                echo $_POST['phone'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatientRdv['phone'])) { ?>
                            <div class="row">
                                <p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatientRdv['phone'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="mail" class="col-md-5 text-right">Mail :</label>
                            <input type="mail" name="mail" id="mail" class="col-md-3 form-control <?php (isset($_POST['mail']) ? (isset($fromErrorSubmitPatientRdv['mail']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatientRdv)) {
                                echo $_POST['mail'];
                            }
                            ?>" />
                        </div>
                            <?php if (isset($fromErrorSubmitPatientRdv['mail'])) { ?>
                            <div class="row">
                                <p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatientRdv['mail'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="rdvDate" class="col-md-5 text-right">Date du RDV:</label>
                            <input type="date" min="<?= $thisYear . '-' . $thisMonth . '-' . $thisDay ?>" id="rdvDate" name="rdvDate" class="col-md-3 form-control" value="<?php
                            if (isset($fromErrorSubmitPatientRdv)) {
                                echo $_POST['rdvDate'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatientRdv['rdvDate'])) { ?>
                            <div class="row d-flex justify-content-center mt-2">
                                <p class="text-danger"><?= $fromErrorSubmitPatientRdv['rdvDate'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="rdvHour" class="col-md-5 text-right">Heure du RDV :</label>
                            <input type="time" max="19:00" min="08:00" step=900 id="rdvHour" name="rdvHour" class="col-md-3 form-control" value="<?php
                            if (isset($fromErrorSubmitPatientRdv)) {
                                echo $_POST['rdvHour'];
                            }
                            ?>"  />
                        </div>
                        <?php if (isset($fromErrorSubmitPatientRdv['rdvHour'])) { ?>
                            <div class="row d-flex justify-content-center mt-2">
                                <p class="text-danger"><?= $fromErrorSubmitPatientRdv['rdvHour'] ?></p>
                            </div>
                        <?php } ?>
                        <input type="submit" name="submitPatientRdvForm" value="Valider le patient et le rendez-vous" class="offset-4 col-md-4 mt-5 btn btn-success" />
                    </form>
                    <?php if(isset($didPatientGetAdd)){ ?>
                    <div class="row">
                        <p class=" offset-5 col-md-3 mt-3 <?= $classDiDPatientGetAdd ?>"><?= $didPatientGetAdd ?></p>
                    </div>
                   <?php } ?>
                </div>
                <div class="col-md-2 rectBlue"></div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="../assets/js/scipt.js"></script>
    </body>
</html>

