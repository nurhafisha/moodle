function toggleFormView(tabName) {
  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  if (tabName === 'msgtxt') {
      document.getElementById('tab-msgtxt').className += " active";
      document.getElementById('post_depotPost').style.display = "none";
      document.getElementById('post_typeMessage').style.display = "flex";
      document.getElementById('post_typeMessageSelect').removeAttribute('required');
      document.getElementById('post_typePost').value = 'message';

  } else if (tabName === 'partagefic') {
      document.getElementById('tab-partagefic').className += " active";
      document.getElementById('post_depotPost').style.display = "flex";
      document.getElementById('post_typeMessage').style.display = "none";
      document.getElementById('post_depotPostInput').setAttribute('required', 'required');
      document.getElementById('post_typePost').value = 'fichier';
  }
}

window.onload = function() {
  toggleFormView('msgtxt');
};

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('div-form');
  const fileInput = document.getElementById('post_depotPost');
  const typePostInput = document.getElementById('post_typePost');
  const typeMessageSelect = document.getElementById('post_typeMessageSelect');

  if (form && fileInput && typePostInput) {
      form.addEventListener('submit', function () {
          if (fileInput.files.length > 0) {
              typePostInput.value = 'fichier';
          }
      });
  }
});

function openModal() {
  document.getElementById('deleteModal').style.display = 'block';
}

// Close Modal
function closeModal() {
  document.getElementById('deleteModal').style.display = 'none';
}

// Confirm Delete
function confirmDelete() {
  alert("Item deleted!");
  closeModal();
}

// Close modal when clicking outside the modal-content
window.onclick = function(event) {
  let modal = document.getElementById('deleteModal');
  if (event.target === modal) {
      closeModal();
  }
};

document.addEventListener('DOMContentLoaded', function () {
  const posts = document.querySelectorAll('.post');

  posts.forEach(post => {
      const desc = post.querySelector('.description');
      const btn = post.querySelector('.read-more-btn');

      // Count number of newlines
      const lineCount = desc.textContent.split('\n').length;

      // Hide the button if there are fewer than, say, 4 lines
      if (lineCount < 6) {
          btn.style.display = 'none';
      }

      btn.addEventListener('click', function () {
          desc.classList.toggle('expanded');
          btn.textContent = desc.classList.contains('expanded') ? 'Lire moins' : 'Lire plus';
      });
  });
});
