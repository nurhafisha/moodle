// variables globaux pour supprimer post (ajax)
let pendingDelete = {
  postId: null,
  codeUe: null,
  token: null,
  button: null
};

// tabulation de deux types de formes (types de post message et fichier)
function toggleFormView(tabName) {
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  if (tabName === 'msgtxt') {
      document.getElementById('tab-msgtxt').className += " active";
      document.getElementById('post_depotPost').style.display = "none";
      document.getElementById('post_typeMessage').style.display = "flex";
      document.getElementById('post_depotPostInput').removeAttribute('required');
      document.getElementById('post_typeMessageSelect').setAttribute('required', 'required');
      document.getElementById('post_typePost').value = 'message';

  } else if (tabName === 'partagefic') {
      document.getElementById('tab-partagefic').className += " active";
      document.getElementById('post_depotPost').style.display = "flex";
      document.getElementById('post_typeMessage').style.display = "none";
      document.getElementById('post_typeMessageSelect').removeAttribute('required');
      document.getElementById('post_depotPostInput').setAttribute('required', 'required');
      document.getElementById('post_typePost').value = 'fichier';
  }
}

// supprimer post avec ajax sans changer de page
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('div-form');
  const fileInput = document.getElementById('post_depotPostInput');
  const typePostInput = document.getElementById('post_typePost');
  const typeMessageSelect = document.getElementById('post_typeMessageSelect');

  if (form && fileInput && typePostInput) {
      form.addEventListener('submit', function () {
        if (typePostInput.value === 'message') {
          const fileWrapper = document.getElementById('post_depotPost');
          if (fileInput) {
            fileWrapper.removeChild(fileInput);
          }
        } else if (typePostInput.value === 'fichier') {
          typeMessageSelect.value = ''; // Vide la sélection du type de message
        }
      });
  }
});

// Gestion de pop-up de confirmation
function openModal() {
  document.getElementById('deleteModal').style.display = 'block';
}
function closeModal() {
  document.getElementById('deleteModal').style.display = 'none';
}

// Confirm Delete (AJAX)
function confirmDelete() {
  const { postId, codeUe, token } = pendingDelete;

  if (!postId || !codeUe || !token) {
      alert('Missing data');
      closeModal();
      return;
  }

  fetch(`/mes-cours/${codeUe}/delete/${postId}`, {
      method: 'DELETE',
      headers: {
          'X-CSRF-TOKEN': token
      }
  })
  .then(response => {
    if (response.ok) {
        return response.json();
    } else {
        return response.text().then(text => {
            throw new Error(`Error: ${text}`);
        });
    }
  })
  .then(data => {
      console.log('Supprimer Echoue', data);
      document.getElementById(`post-${postId}`).remove();
  })
  .catch(error => {
      console.error('Supprime Echoue:', error.message);
      alert('Supprime Echoue: ' + error.message);
  })
  .finally(() => {
      closeModal();
  });
}

// Fermer pop-up confirmation quand click ailleurs
window.onclick = function(event) {
  let modal = document.getElementById('deleteModal');
  let modalCreate = document.getElementById('post-modal');
  if (event.target === modal || event.target === modalCreate) {
      closeModal();
      closeModalNewPost();
  }
};

// Bouton lire plus pour les posts
document.addEventListener('DOMContentLoaded', function () {
  const posts = document.querySelectorAll('.post');

  posts.forEach(post => {
      const desc = post.querySelector('.description');
      const btn = post.querySelector('.read-more-btn');

      // Count number of newlines
      const lineCount = desc.textContent.split('\n').length;

      if (lineCount < 6) {
          btn.style.display = 'none';
      }

      btn.addEventListener('click', function () {
          posts.forEach(otherPost => {
              const otherDesc = otherPost.querySelector('.description');
              const otherBtn = otherPost.querySelector('.read-more-btn');
              if (otherPost !== post) {
                  otherDesc.classList.remove('expanded');
                  otherBtn.textContent = 'Lire plus';
              }
          });

          desc.classList.toggle('expanded');
          btn.textContent = desc.classList.contains('expanded') ? 'Lire moins' : 'Lire plus';
      });
  });
});

// action event listener bouton supprimer post
document.querySelectorAll('.delete-button').forEach(button => {
  button.addEventListener('click', (e) => {
      e.preventDefault();

      pendingDelete = {
          postId: button.dataset.id,
          codeUe: button.dataset.code,
          token: button.dataset.token,
          button: button
      };

      openModal();
  });
});

// auto resize appel au chargement de page
function autoResize(textarea) {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

  textarea.style.height = 'auto';
  textarea.style.height = textarea.scrollHeight + 'px';

  window.scrollTo({ top: scrollTop });
}

window.addEventListener('DOMContentLoaded', function () {
  const textarea = document.getElementById('post_descriptionPost');
  autoResize(textarea);
});

// enlever lien ancien fichier quand nouveau fichier existe (modifier post)
document.addEventListener('DOMContentLoaded', function () {
  const fileInput = document.getElementById('post_depotPostInput');
  const fileLink = document.getElementById('existingFileLink');

  fileInput.addEventListener('change', function () {
      if (fileInput.files.length > 0 && fileLink) {
          fileLink.remove();
      }
  });
});

// Gestion de pop-up de l'ajout Post
function openModalNewPost() {
  document.getElementById('post-modal').style.display = 'block';
}
function closeModalNewPost() {
  document.getElementById('post-modal').style.display = 'none';
}