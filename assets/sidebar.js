
//Affiche la barre latérale
function showSidebar() {
  // Sélection de la barre latérale.
  const sidebar = document.querySelector(".sidebar");

  sidebar.style.display = "flex";
}


//Masque la barre latérale
function hideSidebar() {
  const sidebar = document.querySelector(".sidebar");

  // Définition du style 'display' pour cacher la barre latérale.
  sidebar.style.display = "none";
}
