<?php
$patient = new patients();
$search = htmlspecialchars($_GET['searchPatient']);
$patientList = $patient->searchAPatient($search);

