$(document).ready(function () {
  function parseJwt(token) {
    try {
      const base64Url = token.split(".")[1];
      const base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
      const jsonPayload = decodeURIComponent(
        atob(base64)
          .split("")
          .map((c) => "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2))
          .join("")
      );
      return JSON.parse(jsonPayload);
    } catch (e) {
      console.error("Invalid token format", e);
      return null;
    }
  }
  function fetchProducts() {
    const token = localStorage.getItem("user_token");

    if (!token) {
      console.error("No authentication token found.");
      return;
    }

    $.ajax({
      url: "http://localhost/web_ecommerce_shop/backend/products",
      method: "GET",
      headers: {
        Authentication: token,
      },
      success: function (response) {
        if (response && Array.isArray(response)) {
          renderProducts(response);
        } else {
          console.error("Invalid response format", response);
        }
      },
      error: function (xhr, status, error) {
        console.error(
          "Error fetching product data:",
          xhr.responseText || error
        );
      },
    });
  }

  function renderProducts(products) {
    const collectionList = $("#collection-list");
    collectionList.empty();

    products.forEach((product) => {
      const productItem = `
      <div class="col-md-6 col-lg-4 mb-4 product-item mx-auto ${
        product.category
      }">
        <div class="card border-0 shadow d-flex flex-column h-100">
          <img src="${
            product.picture
          }" class="card-img-top img-fluid w-75 d-block mx-auto" style="height:250px; object-fit:cover;" alt="${
        product.name
      }">
          <div class="card-body text-center d-flex flex-column justify-content-between flex-grow-1">
            <h5 class="text-capitalize">${product.name}</h5>
            <p>${product.description}</p>
            <span class="fw-bold">${parseFloat(product.price).toFixed(
              2
            )} KM</span>
            <div class="mt-3 d-grid gap-2">
              <button class="btn btn-primary w-100 btn-add-to-cart" data-id="${
                product.product_id
              }">🛒 Add to Cart</button>
              <button class="btn btn-warning w-100 btn-add-to-favorites" data-id="${
                product.product_id
              }">⭐ Add to Favorites</button>
              <a class="nav-link text-dark" href="#productSection">
                <button class="btn btn-info w-100 btn-view-details" data-id="${
                  product.product_id
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

  function addToCart(productId) {
    const token = localStorage.getItem("user_token");
    if (!token) {
      alert("You need to log in first.");
      return;
    }

    const payload = parseJwt(token);
    if (!payload || !payload.user || !payload.user.user_id) {
      alert("Invalid user token.");
      return;
    }

    const userId = payload.user.user_id;

    $.ajax({
      url: "http://localhost/web_ecommerce_shop/backend/cart",
      method: "POST",
      headers: {
        Authentication: token,
      },
      contentType: "application/json",
      data: JSON.stringify({
        product_id: productId,
        quantity: 1,
        user_id: userId,
      }),
      success: function (response) {
        toastr.success("Product added to cart!");
        console.log(response);
      },
      error: function (xhr) {
        toastr.success("Failed to add to cart!");
        console.error(xhr.responseText);
      },
    });
  }

  function addToFavorites(productId) {
    const token = localStorage.getItem("user_token");
    if (!token) {
      alert("You need to log in first.");
      return;
    }

    const payload = parseJwt(token);
    if (!payload || !payload.user || !payload.user.user_id) {
      alert("Invalid user token.");
      return;
    }

    const userId = payload.user.user_id;

    $.ajax({
      url: "http://localhost/web_ecommerce_shop/backend/favorites",
      method: "POST",
      headers: {
        Authentication: token,
      },
      contentType: "application/json",
      data: JSON.stringify({ product_id: productId, user_id: userId }),
      success: function (response) {
        toastr.success("Product added to favorites!");
        console.log(response);
      },
      error: function (xhr) {
        toastr.success("Failed to add to favorites!");
        console.error(xhr.responseText);
      },
    });
  }

  function attachProductEventListeners() {
    $(".btn-add-to-cart").on("click", function () {
      const productId = $(this).data("id");
      addToCart(productId);
    });

    $(".btn-add-to-favorites").on("click", function () {
      const productId = $(this).data("id");
      addToFavorites(productId);
    });

    $(".btn-view-details").on("click", function () {
      const productId = $(this).data("id");
      const token = localStorage.getItem("user_token");

      if (!token) {
        alert("Please log in first.");
        return;
      }

      $.ajax({
        url: `http://localhost/web_ecommerce_shop/backend/products/${productId}`,
        method: "GET",
        headers: {
          Authentication: token,
        },
        success: function (product) {
          if (!product) {
            alert("Product not found");
            return;
          }

          updateProductDetails(product);

          $("#productSection").show();

          $("html, body").animate(
            {
              scrollTop: $("#productSection").offset().top,
            },
            600
          );

          $("#addToCartButton")
            .off("click")
            .on("click", function () {
              addToCart(product.product_id);
            });
          $("#addToFavoritesButton")
            .off("click")
            .on("click", function () {
              addToFavorites(product.product_id);
            });
        },

        error: function () {
          alert("Failed to fetch product details.");
        },
      });
    });
  }
  function updateProductDetails(product) {
    $("#mainImage").attr("src", product.picture).attr("alt", product.name);
    $("#productDescription").text(product.description);
    $("#productPrice").text(`${parseFloat(product.price).toFixed(2)} KM`);
    $("#quantity").hide();
    $("#productName").text(product.name).show();
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
  initializeSearch();
});
