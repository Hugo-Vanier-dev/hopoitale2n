<?php
if(isset($_SERVER['REQUEST_URI'])){
$URL = $_SERVER['REQUEST_URI'];
}
?>
<div class="row">
    <nav class="navbar navbar-expand-lg navbar-light col-md-12">
        <a class="navbar-brand" href="index.php"><img src="../assets/img/logoHopital.png" alt="H majuscule sur un fond bleu" id="logoHospital"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" id="flexNav">
                <li class="nav-item <?php if ($URL == '/index.php' || $URL == '/') { ?>
                        active
                    <?php }
                    ?>">
                    <a class="nav-link" href="index.php">Accueil <?php if ($URL == '/index.php' || $URL == '/') { ?>
                            <span class="sr-only">(current)</span> 
                        <?php } ?></a>
                </li>           
                <li class="nav-item dropdown <?php if ($URL == '/ajout-patient.php' || $URL == '/liste-patients.php' || $URL == '/profil-patient.php') { ?>
                        active
                    <?php }
                    ?>">
                    <a class="nav-link dropdown-toggle" href="ajout-patient.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Patients<?php if ($URL == '/ajout-patient.php' || $URL == '/liste-patients.php' || $URL == '/profil-patient.php') { ?>
                            <span class="sr-only">(current)</span> 
                        <?php } ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="ajout-patient.php">Ajouter un patient</a>
                        <a class="dropdown-item" href="liste-patients.php">liste des patients</a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if ($URL == '/ajout-rendezvous.php' || $URL == '/liste-rendezvous.php' || $URL == '/rendezvous.php') { ?>
                        active
                    <?php }
                    ?>">
                    <a class="nav-link dropdown-toggle" href="ajout-rendezvous.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Rendez-vous<?php if ($URL == '/ajout-rendezvous.php' || $URL == '/liste-rendezvous.php' || $URL == '/rendezvous.php') { ?>
                            <span class="sr-only">(current)</span> 
                        <?php } ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="ajout-rendezvous.php">Ajouter un rendez-vous</a>
                        <a class="dropdown-item" href="liste-rendezvous.php">liste des rendez-vous</a>
                    </div>
                </li>
                <li class="nav-item <?php if ($URL == '/ajout-patient-rendez-vous.php') { ?>
                        active
                    <?php }
                    ?>">
                    <a class="nav-link" href="ajout-patient-rendez-vous.php">Ajout rdv et patient <?php if ($URL == '/ajout-patient-rendez-vous.php') { ?>
                            <span class="sr-only">(current)</span> 
                        <?php } ?></a>
                </li>
            </ul>
        </div>
    </nav>
</div>    
