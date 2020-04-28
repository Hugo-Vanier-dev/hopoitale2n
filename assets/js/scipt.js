$(function () {
    let windowHeight = window.innerHeight;
    $('h1').css({'margin-top': 1 / 20 * windowHeight,
        'margin-bottom': 1 / 10 * windowHeight});
    $('.displayForm').click(function () {
        $('.displayedForm').toggle();
    });
    $('#getPatientId').chosen({no_result_text: 'Désoler nous ne trouvons pas ce patient'});
});
//On récupère et stocke notre champ de recherche dans une variable
let inputForm = document.getElementById('inputToSearchPatient');
//On ajoute un événement sur notre champ de recherche qui s'active à chaque keyup
inputForm.addEventListener('keyup', function () {
    //On récupère la valeur de notre champ de recherche
    let research = inputForm.value;
    //On instancie l'objet XMLHttpRequest
    let xhr = new XMLHttpRequest();
    //On lance une fonction à chaque changement d'etats de l'attribut readyState
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(this.response);
            //On parse notre retour pour que le Json devienne un tableau d'objet
            let patientList = JSON.parse(this.responseText);
            if (patientList.length == 0) {
                //Si notre tableau d'objet est vide c'est que aucun patient n'as été retourné on 
                document.querySelector('#smallErrorMessage').textContent = 'Votre recherche n\'a abouti à aucun résultat';
                document.querySelector('#tabToDiplayPatientList').textContent = '';
            } else {
                //On stocke dans une variable notre tbody
                let tbody = document.querySelector('#tabToDiplayPatientList');
                let elementsNumber = tbody.childElementCount;
                let elementsToDelete = document.querySelectorAll('.tr-info');
                if (elementsNumber > 0) {
                    for (let i = 0; i < elementsToDelete.length; i++) {
                        tbody.removeChild(elementsToDelete[i]);
                    }
                }
                //On affiche la réponse reçu dans notre div d'id tabToDiplayPatientList
                for (let i = 0; i < patientList.length; i++) {
                    //On crée un element tr  
                    let tr = document.createElement('tr');
                    //On ajoute une class a notre tr
                    tr.classList.add('tr-info');
                    //On met notre élément tr dans notre tbody
                    tbody.appendChild(tr);
                    //On crée un élément td que l'on stocke dans une variable tdfirstname
                    let tdFirstname = document.createElement('td');
                    //On met dans notre td la valeur du firstname du patient
                    tdFirstname.innerHTML = patientList[i].firstname;
                    //On met notre td dans notre tr en dernière position
                    tr.appendChild(tdFirstname);
                    //On créer un td que l'on stocke dans une variable tdlastname
                    let tdLastname = document.createElement('td');
                    //On met donne la valeur de notre tdlastname qui équivaut au lastname du patient
                    tdLastname.innerHTML = patientList[i].lastname;
                    //On met notre td dans notre tr en dernière position
                    tr.appendChild(tdLastname);
                    //On crée un élément td que l'on stocke dans une variable tdMoreInfo
                    let tdMoreInfo = document.createElement('td');
                    //On met notre td dans notre tr en dernière position
                    tr.appendChild(tdMoreInfo);
                    //On crée un élément a que l'on stocke dans une variable tdMoreInfoLink
                    let tdMoreInfoLink = document.createElement('a');
                    //On donne un attribut href qui renvoie vers la page profil-patient à notre lien
                    tdMoreInfoLink.setAttribute('href', 'profil-patient.php?id=' + patientList[i].id);
                    //On met notre lien dans notre td en dernière position
                    tdMoreInfo.appendChild(tdMoreInfoLink);
                    //On crée un élément button que l'on stocke dans une variable tdMoreInfoButton
                    let tdMoreInfoButton = document.createElement('button');
                    //On ajoute nos class bootstrap à notre bouton
                    tdMoreInfoButton.classList.add('btn', 'btn-success', 'buttonSubmitIdPatient');
                    //On donne la value de notre bouton
                    tdMoreInfoButton.textContent = 'Plus d\info';
                    //On met notre bouton dans notre lien en dernière position
                    tdMoreInfoLink.appendChild(tdMoreInfoButton);
                    // On crée un élément td que l'on stocke dans notre variable tdDelete
                    let tdDelete = document.createElement('td');
                    //On met notre td en dernière position de notre tr
                    tr.appendChild(tdDelete);
                    //On crée un élément a que l'on stocke dans une variable tdDeleteLink
                    let tdDeleteLink = document.createElement('a');
                    //On donne un attribut href qui renvoie sur la page liste patient avec un param en get à notre lien
                    tdDeleteLink.setAttribute('href', 'liste-patients.php?id=' + patientList[i].id);
                    //On met notre lien en dernière position de notre td
                    tdDelete.appendChild(tdDeleteLink);
                    //On crée un élément button que l'on stocke dans une variable tdDeleteButton
                    let tdDeleteButton = document.createElement('button');
                    //On ajoute nos class bootstrap à notre bouton
                    tdDeleteButton.classList.add('btn', 'btn-danger', 'buttonSubmitIdPatient');
                    //On donne la value de notre bouton
                    tdDeleteButton.textContent = 'Supprimer';
                    //On met notre bouton dans notre lien
                    tdDeleteLink.appendChild(tdDeleteButton);
                }
                //On vide le message d'erreur si il existait
                document.querySelector('#smallErrorMessage').innerHTML = '';
            }
        }
    };
    //On envoie en get dans notre page patientsList un paramètre = à notre entrée dans le champ de recherche
    xhr.open('GET', '../../controllers/liste-patientsCtrl.php?searchPatients=' + research, true);
    xhr.send();
});