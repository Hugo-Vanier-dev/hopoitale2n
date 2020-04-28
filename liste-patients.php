<?php
require_once 'models/patients.php';
require_once 'models/database.php';
require_once 'controllers/liste-patientsCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <title>Hospital E2N|liste-patients</title>
    </head>
    <body>
        <div class="container-fluid">
            <?php include_once 'navbar.php'; ?>
            <div class="row">
                <div class="col-md-2 rectBlue"></div>
                <div class="col-md-8">
                    <h1>Liste des patients</h1>
                    <div>
                        <form action="liste-patients.php?page=1" method="POST">
                            <input type="text" name="inputToSearchPatient" id="inputToSearchPatient" value="<?php
                            if (isset($_POST['searchPatientForm'])) {
                                echo $_POST['inputToSearchPatient'];
                            } else if (isset($_GET['searchPatients'])) {
                                echo $_GET['inputToSearchPatient'];
                            }
                            ?>" />                            
                            <input type="submit" name="searchPatientForm" id="searchPatientForm" value="Rechercher" class="btn btn-secondary" />
                        </form>
                        <small id="smallErrorMessage" class="text-danger"></small>
                        <a href="ajout-patient.php" class="offset-10" title="Aller vers ajouter un patient"><button class="mb-4 btn btn-success">Ajouter un patient</button></a>                      
                    </div> 
                    <div class="d-flex jutify-content-center table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Plus d'info</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody id="tabToDiplayPatientList">
                                <?php
                                if ($ajax === false) {
                                    foreach ($patientList as $patientInfo) {
                                        ?>
                                <tr class="tr-info">
                                            <td><?= $patientInfo->firstname ?></td>
                                            <td><?= $patientInfo->lastname ?></td>
                                            <td>
                                                <a href="profil-patient.php?id=<?= $patientInfo->id ?>">
                                                    <button class="btn btn-success buttonSubmitIdPatient">Plus d'info</button>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="liste-patients.php?<?= $patientInfo->id ?>">
                                                    <button class="btn btn-danger buttonSubmitIdPatient">Supprimer</button>
                                                </a>
                                            </td>
                                        </tr>    
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    if (isset($_GET['page']) && $ajax === false) {
                        if ($_GET['page'] == 1 || $_GET['page'] == 2 || $_GET['page'] == 3) {
                            ?>
                            <div class="pageNumber">
                                <a class="linkPagination" href="liste-patients.php?page=<?php
                                if ($_GET['page'] == 1) {
                                    echo $pageNumbers;
                                } else {
                                    echo $_GET['page'] - 1;
                                }
                                ?>"><</a>
                                <a class="linkPagination<?php if ($_GET['page'] == 1) { ?> thisPage <?php } ?>" href="liste-patients.php?page=1">1</a>
                                <a class="linkPagination<?php if ($_GET['page'] == 2) { ?> thisPage <?php } ?>" href="liste-patients.php?page=2">2</a>
                                <a class="linkPagination<?php if ($_GET['page'] == 3) { ?> thisPage <?php } ?>" href="liste-patients.php?page=3">3</a>
                                <a href="liste-patients.php?page=4">4</a>
                                <p>. . .</p>
                                <a class="linkPagination" href="liste-patients.php?page=<?= $pageNumbers ?>"><?= $pageNumbers ?></a>
                                <a class="linkPagination" href="liste-patients.php?page=<?= $_GET['page'] + 1 ?>">></a>
                            </div>
                            <?php
                        } elseif ($_GET['page'] == $pageNumbers || $_GET['page'] == $pageNumbers - 1 || $_GET['page'] == $pageNumbers - 2) {
                            ?>
                            <div class="pageNumber">
                                <a class="linkPagination" href="liste-patients.php?page=<?= $_GET['page'] - 1 ?>"><</a>
                                <a class="linkPagination" href="liste-patients.php?page=1">1</a>
                                <p>. . .</p>
                                <a class="linkPagination" href="liste-patients.php?page=<?= $pageNumbers - 3 ?>"><?= $pageNumbers - 3 ?></a>
                                <a class="linkPagination<?php if ($_GET['page'] == $pageNumbers - 2) { ?> thisPage <?php } ?>" href="liste-patients.php?page=<?= $pageNumbers - 2 ?>"><?= $pageNumbers - 2 ?></a>
                                <a class="linkPagination<?php if ($_GET['page'] == $pageNumbers - 1) { ?> thisPage <?php } ?>" href="liste-patients.php?page=<?= $pageNumbers - 1 ?>"><?= $pageNumbers - 1 ?></a>
                                <a class="linkPagination<?php if ($_GET['page'] == $pageNumbers) { ?> thisPage <?php } ?>" href="liste-patients.php?page=<?= $pageNumbers ?>"><?= $pageNumbers ?></a>
                                <a class="linkPagination" href="liste-patients.php?page=<?php
                                if ($_GET['page'] == $pageNumbers) {
                                    echo 1;
                                } else {
                                    echo $_GET['page'] - 1;
                                }
                                ?>">></a>
                            </div>
                        <?php } else { ?>
                            <div class="pageNumber">
                                <a class="linkPagination" href="liste-patients.php?page=<?= $_GET['page'] - 1 ?>"><</a>
                                <a class="linkPagination" href="liste-patients.php?page=1">1</a>
                                <p>. . .</p>
                                <a class="linkPagination" href="liste-patients.php?page=<?= $_GET['page'] - 1 ?>"><?= $_GET['page'] - 1 ?></a>
                                <a class="thisPage linkPagination" href="liste-patients.php?page=<?= $_GET['page'] ?>"><?= $_GET['page'] ?></a>
                                <a class="linkPagination" href="liste-patients.php?page=<?= $_GET['page'] + 1 ?>"><?= $_GET['page'] + 1 ?></a>
                                <p>. . .</p>
                                <a class="linkPagination" href="liste-patients.php?page=<?= $pageNumbers ?>"><?= $pageNumbers ?></a>
                                <a class="linkPagination" href="liste-patients.php?page=<?= $_GET['page'] + 1 ?>">></a>
                            </div>
                        <?php }
                        ?>
                    <?php }
                    ?>
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
