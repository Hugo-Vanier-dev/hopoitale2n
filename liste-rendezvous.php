<?php
require_once 'models/database.php';
require_once 'models/appointments.php';
require_once 'controllers/liste-rendezvousCtrl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <title>Hospital E2N|liste-rendezvous</title>
    </head>
    <body>
        <div class="container-fluid">
            <?php include_once 'navbar.php'; ?>
            <div class="row">
                <div class="col-md-2 rectBlue"></div>
                <div class="col-md-8">
                    <h1>Liste des Rendez-vous</h1>
                    <div>
                        <a href="ajout-rendezvous.php" title="Aller vers ajouter un rendez-vous"><button class="mb-4 offset-10 btn btn-success">Ajouter un RDV</button></a>                      
                    </div>
                    <?php if(count($appointmentList) > 0){ ?>                 
                    <div class="d-flex jutify-content-center">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Prénom :</th>
                                    <th>Nom :</th>
                                    <th>Le :</th>
                                    <th>Le :</th>
                                    <th>Plus d'info :</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointmentList as $appointmentList) { ?>      
                                <tr>
                                    <td><?= $appointmentList->firstname ?></td>
                                    <td><?= $appointmentList->lastname ?></td>
                                    <td><?= $appointmentList->frenchDate ?></td>
                                    <td><?= $appointmentList->hour ?></td>
                                     <td>
                                         <a href="rendezvous.php?id=<?= $appointmentList->id ?>">
                                            <button class="btn btn-success buttonSubmitIdPatient">Plus d'info</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="liste-rendezvous.php?id=<?= $appointmentList->id ?>">
                                            <button class="btn btn-danger buttonSubmitIdPatient">Supprimer</button>
                                        </a>
                                    </td>
                                </tr>                 
                               <?php } ?>
                            </tbody>
                        </table> 
                    </div>
                    <?php }else{ ?>
                    <p>Votre recherche n'a abouti à aucun résultat</p>
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

