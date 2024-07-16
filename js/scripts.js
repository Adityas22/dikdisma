$(document).ready(function () {
  // Add smooth scrolling to all links
  $("a.nav-link").on("click", function (event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      $("html, body").animate(
        {
          scrollTop: $(hash).offset().top,
        },
        800,
        function () {
          // Add hash (#) to URL when done scrolling (default click behavior)
          window.location.hash = hash;
        }
      );
    } // End if
  });

  // course
  $(document).ready(function () {
    $(".carousel").carousel({
      interval: 5000, // Atur interval ke 5 detik (5000ms)
      pause: "hover", // Carousel akan berhenti saat hover
    });
  });

  // Filter functionality
  $(".filter-button").click(function () {
    var value = $(this).attr("data-filter");

    if (value == "all") {
      $(".filter").show("1000");
    } else {
      $(".filter")
        .not("." + value)
        .hide("3000");
      $(".filter")
        .filter("." + value)
        .show("3000");
    }
  });

  if ($(".filter-button").removeClass("active")) {
    $(this).removeClass("active");
  }
  $(this).addClass("active");
});

// kegiatan
$(document).ready(function () {
  $(".filter-button").click(function () {
    var value = $(this).attr("data-filter");

    if (value == "all") {
      // jika "All" terpilih, tampilkan semua gambar
      $(".filter").show("1000");
    } else {
      // sembunyikan semua gambar dan tampilkan hanya yang sesuai kategori
      $(".filter")
        .not("." + value)
        .hide("3000");
      $(".filter")
        .filter("." + value)
        .show("3000");
    }
  });

  // tambahkan kelas active ke tombol yang terpilih
  $(".filter-button").click(function () {
    $(".filter-button").removeClass("active");
    $(this).addClass("active");
  });
});
