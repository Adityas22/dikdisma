// Reset form ketika modal ditutup
$("#inputModal").on("hidden.bs.modal", function () {
  $(this).find("form").trigger("reset");
});

// Mengosongkan form ketika data berhasil diinsert
$("#inputDataForm").on("submit", function (e) {
  e.preventDefault();
  // Ambil data dari form
  var formData = $(this).serialize();

  // Kirim data menggunakan AJAX
  $.ajax({
    type: "POST",
    url: "tambah_proses.php",
    data: formData,
    success: function (response) {
      alert(response);
      $("#inputModal").modal("hide");
      $("#inputDataForm").trigger("reset"); // Reset form setelah submit
    },
    error: function (xhr, status, error) {
      var errorMessage = xhr.status + ": " + xhr.statusText;
      alert("Terjadi kesalahan - " + errorMessage);
    },
  });
});

// search
document.getElementById("searchButton").addEventListener("click", function () {
  var search = document.getElementById("search").value;
  window.location.href = window.location.pathname + "?search=" + search;
});

// update
$("#updateModal").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget);
  var id = button.data("id");

  $.ajax({
    url: "get_data_update.php",
    type: "GET",
    data: { id: id },
    success: function (response) {
      var data = JSON.parse(response);
      $("#updateId").val(data.id);
      $("#updateTanggalSurat").val(data.tanggal);
      $("#updateNomorSurat").val(data.nomor);
      $("#updateAsalSurat").val(data.asal);
      $("#updateIsiSurat").val(data.isi);
      $("#updateTujuanSurat").val(data.tujuan);
    },
  });
});

$("#updateDataForm").submit(function (event) {
  event.preventDefault();
  var formData = $(this).serialize();

  $.ajax({
    url: "update_proses.php",
    type: "POST",
    data: formData,
    success: function (response) {
      $("#updateModal").modal("hide");
      location.reload();
    },
  });
});

// hapus data
// Get the delete button
$(".deleteButton").click(function () {
  // Get the data-id attribute
  var id = $(this).data("id");
  // Update the href of the "Ya" button in the modal
  $(".deleteConfirm").attr("href", "hapus.php?id=" + id);
});

// export
