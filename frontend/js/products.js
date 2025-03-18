$(document).ready(function () {
  function fetchProducts() {
    $.getJSON("js/products.json", function (data) {
      if (data && data.products) {
        renderProducts(data.products);
      } else {
        console.error("Invalid product data.");
      }
    }).fail(function (error) {
      console.error("Error fetching product data:", error);
    });
  }

  function renderProducts(products) {
    const collectionList = $("#collection-list");
    collectionList.empty();

    products.forEach((product) => {
      const priceString = product.price;
      const price = parseFloat(priceString.replace("$", ""));

      const productItem = `
        <div class="col-md-6 col-lg-4 mb-4 product-item ${product.category}">
          <div class="card border-0 shadow">
            <img src="${product.image}" class="card-img-top" alt="${
        product.name
      }">
            <div class="card-body text-center">
              <h5 class="text-capitalize">${product.name}</h5>
              <p>${product.description}</p>
              <span class="fw-bold">${
                !isNaN(price) ? price.toFixed(2) : "N/A"
              }</span>
              <div class="mt-3 d-grid gap-2">
                <button class="btn btn-primary w-100 btn-add-to-cart" data-id="${
                  product.id
                }">🛒 Add to Cart</button>
                <button class="btn btn-warning w-100 btn-add-to-favorites" data-id="${
                  product.id
                }">⭐ Add to Favorites</button>
                <!-- View Details button with emoji -->
                  <a class="nav-link text-dark" href="#productSection">
                  <button class="btn btn-info w-100 btn-view-details" data-id="${
                    product.id
                  }">
                    👁 View Details
                    </button>
                  </a>
              </div>
            </div>
          </div>
        </div>
      `;
      collectionList.append(productItem);
    });

    attachProductEventListeners();
  }

  function attachProductEventListeners() {
    $(".btn-add-to-cart").on("click", function () {
      const productId = $(this).data("id");
      console.log(`Product ${productId} added to cart`);
    });

    $(".btn-add-to-favorites").on("click", function () {
      const productId = $(this).data("id");
      console.log(`Product ${productId} added to favorites`);
    });

    $(".btn-view-details").on("click", function () {
      const productId = $(this).data("id");
      console.log(`Viewing details for product ${productId}`);
    });
  }

  function initializeFiltering() {
    $(".filter-btn").on("click", function () {
      let selectedCategory = $(this).data("category");

      $(".product-item").each(function () {
        let itemCategories = $(this).attr("class").split(" ");
        let itemCategory = itemCategories.find(
          (cls) =>
            cls !== "col-md-6" &&
            cls !== "col-lg-4" &&
            cls !== "mb-4" &&
            cls !== "product-item"
        );

        if (selectedCategory === "all" || itemCategory === selectedCategory) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  }

  function initializeSearch() {
    $("#searchInput").on("input", function () {
      let searchQuery = this.value.toLowerCase().trim();

      $(".product-item").each(function () {
        let productName = $(this).find("h5").text().toLowerCase();
        let productDescription = $(this).find("p").text().toLowerCase();
        let productPrice = $(this).find("span").text().toLowerCase();

        let productText = `${productName} ${productDescription} ${productPrice}`;

        if (productText.includes(searchQuery)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  }

  fetchProducts();
  initializeFiltering();
  initializeSearch();
});
