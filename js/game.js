const class_game = document.querySelector('.game');

function premiereQuestion() {
    // On récupère la première question
    const question = document.querySelector('.question');
    // On la rend visible
    question.style.display = 'block';
}

function questionSuivante() {
    // On récupère la question qui n'est pas en display: none
    const question = document.querySelector('.question:not([style*="display: none"])');
    // On récupère la question suivante
    const question_suivante = question.nextElementSibling;
    // si l'input dans la question actuelle n'est pas vide et n'ai pas un checkbox
    if (question.querySelector('input').value != '' && question.querySelector('input').type != 'checkbox') {
        // si le type de la question est div et que question_suivante est div alors
        if (question.tagName == 'DIV' && question_suivante.tagName == 'DIV') {
            // On mets la question suivante en display: block
            question_suivante.style.display = 'block';
            // On mets la question actuelle en display: none
            question.style.display = 'none';
        } else if (question.tagName == 'DIV' && question_suivante.tagName == 'INPUT') {
            // On mets la question suivante en display: block
            question_suivante.style.display = 'block';
            // On mets la question actuelle en display: none
            question.style.display = 'none';
            // On cache le bouton suivant
            document.querySelector('#suivant').style.display = 'none';
            // On affiche le bouton fini
            document.querySelector('#fini').style.display = 'inline-block';
        }
    } else if (question.querySelector('input').type == 'checkbox') {
        // on récupère les checkbox et on vérifie si au moins une est cochée
        const checkbox = question.querySelectorAll('input[type="checkbox"]');
        let checked = false;
        checkbox.forEach(element => {
            if (element.checked) {
                checked = true;
            }
        }
        );
        // si au moins une est cochée
        if (checked) {
            // On mets la question suivante en display: block
            question_suivante.style.display = 'block';
            // On mets la question actuelle en display: none
            question.style.display = 'none';
        } else {
            alert('Veuillez cocher au moins une réponse');
        }
    } else {
        alert('Veuillez remplir la question');
    }
}