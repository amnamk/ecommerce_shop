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

  function fetchSpecialProducts() {
    const token = localStorage.getItem("user_token");
    if (!token) {
      console.error("Authentication token missing.");
      return;
    }

    $.ajax({
      url: "http://localhost/web_ecommerce_shop/backend/special-products/available",
      method: "GET",
      headers: {
        Authentication: token,
      },
      success: function (response) {
        if (response && Array.isArray(response)) {
          renderSpecialProducts(response);
        } else {
          console.error("Invalid special products data.", response);
        }
      },
      error: function (xhr, status, error) {
        console.error(
          "Error fetching special products data:",
          xhr.responseText || error
        );
      },
    });
  }

  function renderSpecialProducts(products) {
    const specialList = $("#special-list");
    specialList.empty();

    products.forEach((product) => {
      const price = parseFloat(product.price).toFixed(2);

      const productItem = `
        <div class="col-md-6 col-lg-4 col-xl-3 p-2 product-item ${product.category}">
          <div class="card border-0 shadow">
            <img src="${product.picture}" class="card-img-top img-fluid w-75 d-block mx-auto" style="height:250px; object-fit:cover;" alt="${product.name}" />
            <div class="card-body text-center">
              <h5 class="text-capitalize">${product.name}</h5>
              <p>${product.description}</p>
              <span class="fw-bold">${price} KM</span>
              <p><span class="text-danger">${product.discount} OFF</span></p>

              <div class="mt-3 d-grid gap-2">
                <button class="btn btn-primary w-100 btn-add-to-cart" data-id="${product.specialproduct_id}">
                  🛒 Add to Cart
                </button>
                <button class="btn btn-warning w-100 btn-add-to-favorites" data-id="${product.specialproduct_id}">
                  ⭐ Add to Favorites
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
      specialList.append(productItem);
    });

    attachSpecialEventListeners();
  }

  function addToCart(productId) {
    const token = localStorage.getItem("user_token");
    if (!token) return alert("Login required.");

    const payload = parseJwt(token);
    const userId = payload?.user?.user_id;

    if (!userId) return alert("Invalid token.");

    $.ajax({
      url: "http://localhost/web_ecommerce_shop/backend/cart",
      method: "POST",
      headers: { Authentication: token },
      contentType: "application/json",
      data: JSON.stringify({
        specialproduct_id: productId,
        quantity: 1,
        user_id: userId,
      }),
      success: (res) => {
        toastr.success("Product added to cart!");
        console.log(res);
      },
      error: (xhr) => {
        toastr.success("Failed to add to cart!");
        console.error(xhr.responseText);
      },
    });
  }

  function addToFavorites(productId) {
    const token = localStorage.getItem("user_token");
    if (!token) return alert("Login required.");

    const payload = parseJwt(token);
    const userId = payload?.user?.user_id;

    if (!userId) return alert("Invalid token.");

    $.ajax({
      url: "http://localhost/web_ecommerce_shop/backend/favorites",
      method: "POST",
      headers: { Authentication: token },
      contentType: "application/json",
      data: JSON.stringify({ specialproduct_id: productId, user_id: userId }),
      success: (res) => {
        toastr.success("Product added to favorites!");
        console.log(res);
      },
      error: (xhr) => {
        toastr.success("Failed to add to favorites!");
        console.error(xhr.responseText);
      },
    });
  }

  function attachSpecialEventListeners() {
    $(".btn-add-to-cart").on("click", function () {
      const productId = $(this).data("id");
      addToCart(productId);
    });

    $(".btn-add-to-favorites").on("click", function () {
      const productId = $(this).data("id");
      addToFavorites(productId);
    });
  }

  fetchSpecialProducts();
});
