let ueList = []; // Liste des UEs récupérées depuis la base

function fetchUEs() {
  $.ajax({
    url: "/ue/list",
    method: "GET",
    success: function (data) {
      console.log("Données récupérées :", data);
      ueList = data.map((ue) => `${ue.code} - ${ue.name}`);
      renderDropdown();
    },
    error: function (xhr, status, error) {
      console.error("Erreur AJAX :", status, error);
    },
  });
}

function renderDropdown(filter = "") {
  const filtered = ueList.filter((ue) =>
    ue.toLowerCase().includes(filter.toLowerCase())
  );
  const html = filtered
    .map((ue) => `<button class="dropdown-item ue-item">${ue}</button>`)
    .join("");
  $("#ueDropdown").html(html).show();
}

$(document).ready(function () {
  fetchUEs();

  $("#ueInput").on("input", function () {
    const value = $(this).val();
    renderDropdown(value);
  });

  $(document).on("click", ".ue-item", function () {
    const ue = $(this).text();
    if (!$(`#selectedUEs span[data-ue="${ue}"]`).length) {
      $("#selectedUEs").append(
        `<span class="badge bg-primary me-1" data-ue="${ue}">
           ${ue} <span class="ms-1" style="cursor:pointer;" onclick="$(this).parent().remove()">×</span>
         </span>`
      );
    }
    $("#ueInput").val("");
    $("#ueDropdown").hide();
  });

  $(document).on("click", function (e) {
    if (!$(e.target).closest("#ueInput, #ueDropdown").length) {
      $("#ueDropdown").hide();
    }
  });

  $("form").on("submit", function () {
    const selectedUEs = [];
    $("#selectedUEs span").each(function () {
      selectedUEs.push($(this).data("ue"));
    });
    console.log("UEs sélectionnées :", selectedUEs);
    $("#selectedUEsInput").val(JSON.stringify(selectedUEs));
  });
});
