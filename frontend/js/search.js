document.addEventListener("DOMContentLoaded", function () {
  function searchCollection() {
    var searchQuery = document
      .getElementById("searchInput")
      .value.toLowerCase()
      .trim();
    var productItems = document.querySelectorAll(
      "#collection-list .col-md-6, #collection-list .col-lg-4, #collection-list .col-xl-3"
    );

    productItems.forEach(function (item) {
      var productName =
        item.querySelector(".text-capitalize")?.textContent.toLowerCase() || "";
      var productPrice =
        item.querySelector(".fw-bold")?.textContent.toLowerCase() || "";
      var productDescription =
        item.querySelector("p.mt-2")?.textContent.toLowerCase() || "";

      var productText = `${productName} ${productPrice} ${productDescription}`;

      if (productText.includes(searchQuery)) {
        item.style.display = "block";
      } else {
        item.style.display = "none";
      }
    });
  }

  if (document.getElementById("searchInput")) {
    document
      .getElementById("searchInput")
      .addEventListener("input", searchCollection);
  }
});
