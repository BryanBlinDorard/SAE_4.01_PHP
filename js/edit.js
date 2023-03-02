function verifierCheckBoXButton() {
    // Je récupère la checkbox que je vient de décocher

    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    
    checkboxes.forEach(element => {
        element.addEventListener('change', function() {
            // Je récupère les checkbox et on vérifie si au moins une est cochée
            const checkbox = document.querySelectorAll('input[type="checkbox"]');
            let checked = false;
            for (let i = 0; i < checkbox.length; i++) {
                if (checkbox[i].checked) {
                    checked = true;
                }
            }
            if (!checked) {
                alert('Veuillez cocher au moins une réponse');
                element.checked = true;
            }            
        });
    });
}