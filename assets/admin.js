function showOngletUser() {
  // "Gestion des Utilisateurs" tab
  document.getElementById("onglet-user").style.display = "block";
  document.getElementById("onglet-ue").style.display = "none";

  // mettre l'onglet en active
  setActiveTab("tab-user");
}

function showOngletUE() {
  // "Gestion des UEs" tab
  document.getElementById("onglet-user").style.display = "none";
  document.getElementById("onglet-ue").style.display = "block";

  // mettre onglet en active
  setActiveTab("tab-ue");
}

function setActiveTab(activeTabId) {
  // retirer la classe "active"
  document.querySelectorAll("#navbar-dashboard .tab").forEach((tab) => {
    tab.classList.remove("active");
  });

  // ajouter class "active" si on a clique l'onglet
  document.getElementById(activeTabId).classList.add("active");
}

// Set the default active tab on page load
document.addEventListener("DOMContentLoaded", function () {
  showOngletUser(); // l'onglet "Gestion des Utilisateurs" par defaut
});

// Ajax requetes pour supprimer les ues et utilisateurs
function confirmAndDeleteFromButton(button) {
  const url = button.getAttribute("data-url");
  const rowSelector = button.getAttribute("data-row-selector");

  if (confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")) {
    fetch(url, {
      method: "DELETE",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (response.ok) {
          // Supprimer la ligne correspondante dans le tableau
          document.querySelector(rowSelector).remove();
          alert("Élément supprimé avec succès !");
        } else {
          alert("Erreur lors de la suppression.");
        }
      })
      .catch((error) => {
        console.error("Erreur AJAX :", error);
        alert("Une erreur s'est produite.");
      });
  }
}

// jQuery pour la liste des UEs disponibles sur la base de donnees
$(document).ready(function() {
  $('.ue-btn').click(function() {
    $(this).toggleClass('btn-primary btn-outline-primary');

    let checkbox = $(this).prev('input[type="checkbox"]');
    checkbox.prop('checked', !checkbox.prop('checked'));
  });
});
