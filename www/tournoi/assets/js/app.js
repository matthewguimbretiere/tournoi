window.addEventListener("DOMContentLoaded", function () {
  // Barème
  $("#btnbareme").click(function () {
    $(".bareme").css("display", "flex");
  });
  $(".btn-close-bareme").click(function () {
    $(".bareme").css("display", "none");
  });
});
