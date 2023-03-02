


// Fonction pour ouvrir la boîte de dialogue modale
function openModal() {
    // Récupère la boîte de dialogue modale
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}
// Fonction pour fermer la boîte de dialogue modale
function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}
// Fermer la boîte de dialogue modale lorsqu'on clique en dehors du contenu
window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        closeModal();
    }
}