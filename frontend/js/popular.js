$(document).ready(function () {
  function fetchTopThreeProducts() {
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
      success: function (products) {
        if (Array.isArray(products)) {
          renderTopThree(products.slice(0, 3));
        } else {
          console.error("Unexpected response format:", products);
        }
      },
      error: function (xhr, status, error) {
        console.error("Failed to fetch products:", xhr.responseText || error);
      },
    });
  }

  function renderTopThree(products) {
    const container = $("#top-three-products");
    container.empty();

    products.forEach((product) => {
      const productHTML = `
  <div class="border p-3 mb-2 d-flex align-items-center justify-content-between">
    <div class="product-info" style="flex: 1; padding-right: 15px;">
      <h5 class="mb-1">${product.name}</h5>
      <p class="mb-0">${product.description}</p>
    </div>
    <img src="${product.picture}" alt="${product.name}" style="width: 100px; height: auto; object-fit: contain;">
  </div>
`;

      container.append(productHTML);
    });
  }

  fetchTopThreeProducts();
});
