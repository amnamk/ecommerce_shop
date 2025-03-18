$(document).ready(function () {
  function renderPopularProducts(data) {
    var topRatedContainer = $("#top-rated-container");
    topRatedContainer.empty();
    data.topRated.forEach(function (product) {
      var productHTML = `
          <div class="d-flex align-items-start justify-content-start">
            <img src="${product.image}" alt="${product.name}" class="img-fluid pe-3 w-25" />
            <div>
              <p class="mb-0">${product.name}</p>
              <span>${product.price}</span>
            </div>
          </div>
        `;
      topRatedContainer.append(productHTML);
    });

    var bestSellingContainer = $("#best-selling-container");
    bestSellingContainer.empty();
    data.bestSelling.forEach(function (product) {
      var productHTML = `
          <div class="d-flex align-items-start justify-content-start">
            <img src="${product.image}" alt="${product.name}" class="img-fluid pe-3 w-25" />
            <div>
              <p class="mb-0">${product.name}</p>
              <span>${product.price}</span>
            </div>
          </div>
        `;
      bestSellingContainer.append(productHTML);
    });

    var onSaleContainer = $("#on-sale-container");
    onSaleContainer.empty();
    data.onSale.forEach(function (product) {
      var productHTML = `
          <div class="d-flex align-items-start justify-content-start">
            <img src="${product.image}" alt="${product.name}" class="img-fluid pe-3 w-25" />
            <div>
              <p class="mb-0">${product.name}</p>
              <span>${product.price}</span>
            </div>
          </div>
        `;
      onSaleContainer.append(productHTML);
    });
  }

  function fetchPopularProducts() {
    $.getJSON("js/popular.json", function (data) {
      renderPopularProducts(data.popularProducts);
    }).fail(function (error) {
      console.error("Error fetching popular products data:", error);
    });
  }

  fetchPopularProducts();
});
