function ajoutDuBoutonAjoutRep(type) {
    var btn = document.createElement('input');
    btn.setAttribute('type', 'button');
    btn.setAttribute('value', 'Ajouter une réponse');
    btn.setAttribute('id', 'btnAdd');
    if (type == 'choix') {
        btn.setAttribute('onclick', 'addReponse("choix")');
    } else if (type == 'choixMultiple') {
        btn.setAttribute('onclick', 'addReponse("choixMultiple")');
    }
    document.getElementById('droite').appendChild(btn);
}

function suppressionDuBoutonAjoutRep() {
    var btn = document.getElementById('btnAdd');
    btn.remove();
}

function ajoutDuBoutonSuprDernier(type){
    var btn = document.createElement('input');
    btn.setAttribute('type', 'button');
    btn.setAttribute('value', 'Supprimer la dernière réponse');
    btn.setAttribute('id', 'btnDel');
    btn.setAttribute('onclick', 'delReponse("'+type+'")');
    document.getElementById('droite').appendChild(btn);
}

function suppressionDuBoutonSuprDernier(){
    var btn = document.getElementById('btnDel');
    btn.remove();
}

function delReponse(type) {
    var reponses = document.getElementsByClassName('reponseDiv');
    if (reponses.length > 2) {
        // regarde si la checkbox est coché
        var checkbox = document.getElementById('r'+reponses.length);
        // je regarde si il y a une autre checkbox coché
        var autreCheckbox = false;
        for (var i = 0; i < reponses.length; i++) {
            var indice = i + 1;
            if (document.getElementById('r'+indice).checked && indice != reponses.length) {
                autreCheckbox = true;
            }
        }
        if (checkbox.checked && !autreCheckbox) {
            document.getElementById('r'+(reponses.length - 1)).checked = true;
        }
        reponses[reponses.length - 1].remove();
    } else {
        alert('Il faut au moins 2 réponses');
    }
    
    var btnAdd = document.getElementById('btnAdd');
    if (btnAdd == null) {
        suppressionDuBoutonSuprDernier();
        ajoutDuBoutonAjoutRep(type);
        ajoutDuBoutonSuprDernier(type);
    }
}

function addReponse(type){
    if(type == 'choix'){
        var id = parseInt(getIDMax()) + 1;
        suppressionDuBoutonAjoutRep();
        suppressionDuBoutonSuprDernier();

        // Création de la div
        var div = document.createElement('div');
        div.setAttribute('id', id);
        div.setAttribute('class', 'reponseDiv');


        // Création du label
        var label = document.createElement('label');
        label.setAttribute('for', 'reponse');
        label.innerHTML = 'Réponse ' + id;

        // Création de l'élément radio
        var radio = document.createElement('input');
        radio.setAttribute('type', 'radio');
        radio.setAttribute('name', 'reponse');
        var idI = "r"+id;
        radio.setAttribute('id', idI);
        radio.setAttribute('value', id);
        radio.setAttribute('required', 'required');

        // Création de l'élément texte
        var text = document.createElement('input');
        text.setAttribute('type', 'text');
        text.setAttribute('name', 'reponseTexte'+id);
        var IDR = "reponse"+id;
        text.setAttribute('id', IDR);
        // ajout du placeholder
        text.setAttribute('placeholder', 'ici votre réponse...');
        text.setAttribute('required', 'required');
        
        
        // Ajout des éléments dans la page
        document.getElementById('droite').appendChild(div);
        div.appendChild(label);
        div.appendChild(radio);
        div.appendChild(text);
        div.appendChild(document.createElement('br'));
        

        if (id < 10) {
            ajoutDuBoutonAjoutRep(type);
            ajoutDuBoutonSuprDernier(type);
        } else {
            ajoutDuBoutonSuprDernier(type);
        }
    } else if (type == "choixMultiple") {
        var id = parseInt(getIDMax()) + 1;
        suppressionDuBoutonAjoutRep();
        suppressionDuBoutonSuprDernier();

        // Création de la div
        var div = document.createElement('div');
        div.setAttribute('id', id);
        div.setAttribute('class', 'reponseDiv');

        // Création du label
        var label = document.createElement('label');
        label.setAttribute('for', 'reponse');
        label.innerHTML = 'Réponse ' + id;

        // Création de l'élément checkbox
        var checkbox = document.createElement('input');
        checkbox.setAttribute('type', 'checkbox');
        checkbox.setAttribute('name', 'reponse'+id);
        var idI = "r"+id;
        checkbox.setAttribute('id', idI);
        checkbox.setAttribute('value', id);
        checkbox.setAttribute('onclick', 'verifierCheckBoXButton()');

        // Création de l'élément texte
        var text = document.createElement('input');
        text.setAttribute('type', 'text');
        text.setAttribute('name', 'reponseTexte'+id);
        var IDR = "reponse"+id;
        text.setAttribute('id', IDR);
        // ajout du placeholder
        text.setAttribute('placeholder', 'ici votre réponse...');
        text.setAttribute('required', 'required');

        // Ajout des éléments dans la page
        document.getElementById('droite').appendChild(div);
        div.appendChild(label);
        div.appendChild(checkbox);
        div.appendChild(text);
        div.appendChild(document.createElement('br'));

        if (id < 10) {
            ajoutDuBoutonAjoutRep(type);
            ajoutDuBoutonSuprDernier(type);
        } else {
            ajoutDuBoutonSuprDernier(type);
        }
    }
}

function getIDMax(){
    var reponses = document.getElementsByClassName('reponseDiv');
    return reponses.length;
}