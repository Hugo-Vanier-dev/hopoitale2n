<?php
include_once 'models/patients.php';
$searchPatient = $_GET['searchPatients'];
$patient = new patients();
$patientList = $patient->searchAPatient($searchPatient);

echo '<table>
<thead>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Plus d\'info</th>
<th>Supprimer</th>
</tr>
</thead>
<tbody>';
foreach($patientList as $patientInfo){
    echo '<tr>';
    echo '<td>' . $patientInfo->firstname . '</td>';
    echo '<td>' . $patientInfo->lastname . '</td>';
    echo '<td>';
    echo '<a href="profil-patient.php?id=' . $patientInfo->id . '">';
    echo '<button class="buttonSubmitIdPatient btn btn-success">Plus d\'info</button>';
    echo '</a>';
    echo '</td>';
    echo '<a href="liste-patients.php?id=' . $patientInfo->id . '">';
    echo '<button class="buttonSubmitIdPatient btn btn-danger">Supprimer</button>';
    echo '</a>';
    echo '</td>';    
}
echo '</tbody>
     </table>';
    


