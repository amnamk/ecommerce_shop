$(document).ready(function () {
  const token = localStorage.getItem("user_token");

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

  function fetchCartData() {
    const token = localStorage.getItem("user_token");

    if (!token) {
      console.error("No authentication token found.");
      return;
    }

    const payload = parseJwt(token);
    if (!payload || !payload.user || !payload.user.user_id) {
      console.error("Invalid user token.");
      return;
    }

    const userId = payload.user.user_id;

    $.ajax({
      url: `https://urchin-app-a8zw7.ondigitalocean.app/cart/items/user/${userId}`,
      method: "GET",
      headers: {
        Authentication: token,
      },
      success: function (response) {
        if (Array.isArray(response)) {
          renderCartItems(response);
        } else {
          console.error("Invalid response data");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching cart data:", xhr.responseText || error);
      },
    });
  }

  function updateTotalCost() {
    let totalCost = 0;

    $("#cart-items li").each(function () {
      const price = parseFloat($(this).data("price"));
      const quantity = parseInt($(this).find("input[type=number]").val()) || 1;
      totalCost += price * quantity;
    });

    $("#cart-total").html(`Total Cost: $${totalCost.toFixed(2)}`);
  }

  function renderCartItems(cartItems) {
    const cartItemsList = $("#cart-items");
    cartItemsList.empty();

    cartItems.forEach((item) => {
      const listItem = `
<li class="list-group-item" data-item-id="${
        item.cart_id
      }" data-price="${parseFloat(
        item.price.replace(/[^0-9.-]+/g, "")
      )}" style="padding: 20px;">
  <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
    <img src="${item.picture}" alt="${
        item.name
      }" class="rounded-circle" style="width: 50px; height: 50px;" />
    <span style="font-weight: 600;">${item.name} - $${parseFloat(
        item.price
      ).toFixed(2)}</span>
  </div>

  <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
    <label for="quantity-${
      item.cart_id
    }" style="min-width: 70px;">Quantity:</label>
    <input 
      type="number" 
      class="form-control text-center" 
      id="quantity-${item.cart_id}" 
      value="${item.quantity > 0 ? item.quantity : 1}" 
      min="1" 
      style="width: 80px;"
    />
    <button class="btn btn-outline-secondary btn-sm btn-increase" data-item-id="${
      item.cart_id
    }" type="button" style="padding: 5px 10px;">+</button>
    <button class="btn btn-outline-secondary btn-sm btn-decrease" data-item-id="${
      item.cart_id
    }" type="button" style="padding: 5px 10px;">−</button>
  </div>

  <div style="text-align: right;">
    <button class="btn btn-danger btn-sm btn-remove" data-item-id="${
      item.cart_id
    }" type="button">Remove</button>
  </div>
</li>
`;
      cartItemsList.append(listItem);
    });

    $("#cart-items input[type=number]").each(function () {
      const val = parseInt($(this).val());
      if (isNaN(val) || val < 1) {
        $(this).val(1);
      }
    });

    attachCartItemEventListeners();
    updateTotalCost();
  }

  function attachCartItemEventListeners() {
    $(".btn-increase").on("click", function () {
      const itemId = $(this).data("item-id");
      const quantityInput = $("#quantity-" + itemId);
      let quantity = parseInt(quantityInput.val());
      quantity += 1;
      quantityInput.val(quantity);
      updateCartItemQuantity(itemId, quantity);
      updateTotalCost();
    });

    $(".btn-decrease").on("click", function () {
      const itemId = $(this).data("item-id");
      const quantityInput = $("#quantity-" + itemId);
      let quantity = parseInt(quantityInput.val());
      if (quantity > 1) {
        quantity -= 1;
        quantityInput.val(quantity);
        updateCartItemQuantity(itemId, quantity);
        updateTotalCost();
      }
    });

    $("#cart-items").on("click", ".btn-remove", function () {
      const itemId = $(this).data("item-id");
      console.log("Removing cart item with ID:", itemId);
      if (!itemId) {
        alert("Error: Item ID is undefined.");
        return;
      }
      $(`#cart-items [data-item-id='${itemId}']`).remove();
      updateTotalCost();
      removeCartItem(itemId);
    });

    $("#cart-items").on("change", "input[type=number]", function () {
      const itemId = $(this).closest("li").data("item-id");
      let quantity = parseInt($(this).val());

      if (isNaN(quantity) || quantity < 1) {
        quantity = 1;
        $(this).val(quantity);
      }

      updateCartItemQuantity(itemId, quantity);
      updateTotalCost();
    });
  }

  function removeCartItem(itemId) {
    $.ajax({
      url: `https://urchin-app-a8zw7.ondigitalocean.app/cart/item/${itemId}`,
      type: "DELETE",
      headers: {
        Authentication: token,
      },
      success: function (response) {
        toastr.success("Removed successfully!");
        console.log(response.message);
      },
      error: function (xhr) {
        console.error("Failed to delete item:", xhr.responseText);
        toastr.success("Error removing!");
        alert("Error deleting item. Please try again.");
      },
    });
  }

  function updateCartItemQuantity(itemId, newQuantity) {
    const token = localStorage.getItem("user_token");

    $.ajax({
      url: `https://urchin-app-a8zw7.ondigitalocean.app/cart/item/${itemId}`,
      method: "PUT",
      contentType: "application/json",
      headers: {
        Authentication: token,
      },
      data: JSON.stringify({
        quantity: newQuantity,
      }),
      success: function (response) {
        toastr.success("Quantity updated successfully!");
        console.log("Quantity updated successfully:", response.message);
      },
      error: function (xhr) {
        console.error("Failed to update quantity:", xhr.responseText);
        toastr.error("Quantity not updated!");
        alert("Error updating quantity. Please try again.");
      },
    });
  }

  fetchCartData();
});
