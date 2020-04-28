<?php
require_once 'models/database.php';
//On récupère notre controller et notre model
require_once 'models/patients.php';
require_once 'controllers/ajout-patientCtrl.php';
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
                    <form method="POST" action="/ajout-patient.php" class="needs-validation" >
                        <div class="row">
                            <label for="firstname" class="col-md-5 text-right">Prénom :</label>
                            <input type="text" name="firstname" id="firstname" class="col-md-3 form-control <?php (isset($_POST['firstname']) ? (isset($fromErrorSubmitPatient['firstname']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatient)) {
                                echo $_POST['firstname'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatient['firstname'])) { ?>
                            <div class="row">
                                <p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatient['firstname'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="lastname" class="col-md-5 text-right">Nom :</label>
                            <input type="text" name="lastname" id="lastname" class="col-md-3 form-control <?php (isset($_POST['lastname']) ? (isset($fromErrorSubmitPatient['lasstname']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatient)) {
                                echo $_POST['lastname'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatient['lastname'])) { ?>
                            <div class="row"><p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatient['lastname'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="birthdate" class="col-md-5 text-right">Date de naissance :</label>
                            <input type="date" name="birthdate" id="birthdate" class="col-md-3 form-control <?php (isset($_POST['birthdate']) ? (isset($fromErrorSubmitPatient['birthdate']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatient)) {
                                echo $_POST['birthdate'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatient['birthdate'])) { ?>
                            <div class="row"><p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatient['birthdate'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="phone" class="col-md-5 text-right">Téléphone :</label>
                            <input type="text" name="phone" id="phone" class="col-md-3 form-control <?php (isset($_POST['phone']) ? (isset($fromErrorSubmitPatient['phone']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatient)) {
                                echo $_POST['phone'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatient['phone'])) { ?>
                            <div class="row">
                                <p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatient['phone'] ?></p>
                            </div>
                        <?php } ?>
                        <div class="row mt-4">
                            <label for="mail" class="col-md-5 text-right">Mail :</label>
                            <input type="mail" name="mail" id="mail" class="col-md-3 form-control <?php (isset($_POST['mail']) ? (isset($fromErrorSubmitPatient['mail']) ? 'is-valid' : 'is-invalid') : '') ?> " required value="<?php
                            if (isset($_POST['submitPatientForm']) && isset($fromErrorSubmitPatient)) {
                                echo $_POST['mail'];
                            }
                            ?>" />
                        </div>
                        <?php if (isset($fromErrorSubmitPatient['mail'])) { ?>
                            <div class="row">
                                <p class="offset-5 col-md-3 text-danger"><?= $fromErrorSubmitPatient['mail'] ?></p>
                            </div>
                        <?php } ?>
                        <input type="submit" name="submitPatientForm" value="Valider le patient" class="offset-4 col-md-4 mt-5 btn btn-success" />
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
