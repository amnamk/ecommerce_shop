$(document).ready(function () {
  function fetchSpecialProducts() {
    $.getJSON("js/specialproducts.json", function (data) {
      if (data && data.specialProducts) {
        renderSpecialProducts(data.specialProducts);
      } else {
        console.error("Invalid special products data.");
      }
    }).fail(function (error) {
      console.error("Error fetching special products data:", error);
    });
  }

  function renderSpecialProducts(products) {
    const specialList = $("#special-list");
    specialList.empty();

    products.forEach((product) => {
      const priceString = product.price;
      const price = parseFloat(priceString.replace("$", ""));

      const productItem = `
          <div class="col-md-6 col-lg-4 col-xl-3 p-2 product-item ${product.category}">
            <div class="card border-0 shadow">
              <img src="${product.image}" class="card-img-top" alt="${product.name}" />
              <div class="card-body text-center">
                <h5 class="text-capitalize">${product.name}</h5>
                <p>${product.description}</p>
                <span class="fw-bold">${product.price}</span>
                <p><span class="text-danger">${product.discount} OFF</span></p>
  
                <div class="mt-3 d-grid gap-2">
                  <!-- Add to Cart button with emoji -->
                  <button class="btn btn-primary w-100 btn-add-to-cart" data-id="${product.id}">
                    🛒 Add to Cart
                  </button>
                  
                  <!-- Add to Favorites button with emoji -->
                  <button class="btn btn-warning w-100 btn-add-to-favorites" data-id="${product.id}">
                    ⭐ Add to Favorites
                  </button>
                  
                  <!-- View Details button with emoji -->
                  <a class="nav-link text-dark" href="#productSection">
                  <button class="btn btn-info w-100 btn-view-details" data-id="${product.id}">
                    👁 View Details
                    </button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        `;
      specialList.append(productItem);
    });
  }

  $(document).on("click", ".btn-add-to-cart", function () {
    const productId = $(this).data("id");
    console.log(`Product ${productId} added to cart`);
  });

  $(document).on("click", ".btn-add-to-favorites", function () {
    const productId = $(this).data("id");
    console.log(`Product ${productId} added to favorites`);
  });

  $(document).on("click", ".btn-view-details", function () {
    const productId = $(this).data("id");
    console.log(`Viewing details for product ${productId}`);
  });

  fetchSpecialProducts();
});
