
function premiereQuestion() {
    // On récupère la première question
    const question = document.querySelector('.question');
    // On la rend visible
    question.style.display = 'block';
}

function monterNumeroQuestion() {
    // On récupère le numéro de la question actuelle
    const affichage_question_actuelle = document.querySelector('.numQuestionActuelle');
    
    // On récupère le texte de numQuestionActuelle
    const affichage_question_actuelle_text = affichage_question_actuelle.textContent;
    
    // récupère le numéro de la question actuelle qui est entre Question et le / et on le transforme en nombre
    const numQuestionActuelleNumber = parseInt(affichage_question_actuelle_text.substring(affichage_question_actuelle_text.indexOf('Question') + 8, affichage_question_actuelle_text.indexOf('/')));

    const numQuestionSuivante = numQuestionActuelleNumber + 1;
    
    // On remplace le numéro de la question actuelle par le nouveau numéro
    const phraseModifiee = affichage_question_actuelle_text.replace(numQuestionActuelleNumber, numQuestionSuivante);

    // On remplace la phrase par la nouvelle phrase
    affichage_question_actuelle.textContent = phraseModifiee;    
}

function questionSuivante() {
    // On récupère la question qui n'est pas en display: none
    const question = document.querySelector('.question:not([style*="display: none"])');
    const question_suivante = question.nextElementSibling;

    // si l'input dans la question actuelle n'est pas vide et n'ai pas un checkbox, ni un radio button alors
    if (question.querySelector('input').value != '' && question.querySelector('input').type != 'checkbox' && question.querySelector('input').type != 'radio') {
        // On mets la question suivante en display: block
        question_suivante.style.display = 'block';
        // On mets la question actuelle en display: none
        question.style.display = 'none';
        monterNumeroQuestion();
        
    } else if (question.querySelector('input').type == 'checkbox') {
        // on récupère les checkbox et on vérifie si au moins une est cochée
        const checkbox = question.querySelectorAll('input[type="checkbox"]');
        let checked = false;
        checkbox.forEach(element => {
            if (element.checked) {
                checked = true;
            }
        });
        if (checked) {
            question_suivante.style.display = 'block';
            question.style.display = 'none';
            monterNumeroQuestion();
        } else {
            alert('Veuillez cocher au moins une réponse');
        }
    } else if (question.querySelector('input').type == 'radio') {
        // on récupère les radio button et on vérifie si au moins une est cochée 
        const radio = question.querySelectorAll('input[type="radio"]');
        let checked = false;
        radio.forEach(element => {
            if (element.checked) {
                checked = true;
            }
        });
        if (checked) {
            question_suivante.style.display = 'block';
            question.style.display = 'none';
            monterNumeroQuestion();
        } else {
            alert('Veuillez cocher au moins une réponse');
        }
    } else {
        alert('Veuillez remplir la question');
    }
    if (question.tagName == 'DIV' && question_suivante.tagName == 'INPUT') {
        question_suivante.style.display = 'block';
        question.style.display = 'none';
        
        // On cache le bouton suivant
        document.querySelector('#suivant').style.display = 'none';
        // On affiche le bouton fini
        document.querySelector('#fini').style.display = 'inline-block';
        monterNumeroQuestion
        // on cache l'affichage du numéro de la question actuelle
        document.querySelector('.numQuestionActuelle').style.display = 'none';
    }
}