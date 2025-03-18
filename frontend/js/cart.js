$(document).ready(function () {
  function fetchCartData() {
    $.getJSON("js/cart.json", function (response) {
      if (response && response.cartItems) {
        renderCartItems(response.cartItems);
      } else {
        console.error("Invalid response data");
      }
    }).fail(function (error) {
      console.error("Error fetching cart data:", error);
    });
  }

  function renderCartItems(cartItems) {
    const cartItemsList = $("#cart-items");
    cartItemsList.empty();
    let totalAmount = 0;

    cartItems.forEach((item) => {
      const listItem = `
        <li class="list-group-item d-flex justify-content-between align-items-center flex-column flex-sm-row" data-item-id="${
          item.id
        }">
          <div class="d-flex align-items-center mb-2 mb-sm-0">
            <img src="${item.image}" alt="${
        item.name
      }" class="img-fluid rounded-circle" style="width: 50px; height: 50px; margin-right: 15px" />
            <span class="text-truncate" style="max-width: 150px;">${
              item.name
            } - $${item.price.toFixed(2)}</span>
          </div>
          <div class="d-flex align-items-center mb-2 mb-sm-0">
            <button class="btn btn-outline-secondary btn-sm btn-decrease" data-item-id="${
              item.id
            }">-</button>
            <input type="number" class="form-control mx-2 text-center" style="width: 50px" value="${
              item.quantity
            }" min="1" id="quantity-${item.id}" />
            <button class="btn btn-outline-secondary btn-sm btn-increase" data-item-id="${
              item.id
            }">+</button>
          </div>
          <div class="d-flex justify-content-end mt-2 mt-sm-0">
            <button class="btn btn-danger btn-sm btn-remove" data-item-id="${
              item.id
            }">Remove</button>
          </div>
        </li>
      `;
      cartItemsList.append(listItem);
      totalAmount += item.price * item.quantity;
    });

    const totalAmountElement = `
      <li class="list-group-item d-flex justify-content-between">
        <strong>Total Amount:</strong>
        <span id="total-amount">$${totalAmount.toFixed(2)}</span>
      </li>
    `;
    cartItemsList.append(totalAmountElement);

    attachCartItemEventListeners();
  }

  function attachCartItemEventListeners() {
    $(".btn-increase").on("click", function () {
      const itemId = $(this).data("item-id");
      const quantityInput = $("#quantity-" + itemId);
      let quantity = parseInt(quantityInput.val());
      quantity += 1;
      quantityInput.val(quantity);
      updateCartItemQuantity(itemId, quantity);
      updateTotalAmount();
    });

    $(".btn-decrease").on("click", function () {
      const itemId = $(this).data("item-id");
      const quantityInput = $("#quantity-" + itemId);
      let quantity = parseInt(quantityInput.val());
      if (quantity > 1) {
        quantity -= 1;
        quantityInput.val(quantity);
        updateCartItemQuantity(itemId, quantity);
        updateTotalAmount();
      }
    });

    $(".btn-remove").on("click", function () {
      const itemId = $(this).data("item-id");
      removeCartItem(itemId);
      updateTotalAmount();
    });
  }

  function updateCartItemQuantity(itemId, quantity) {
    console.log(`Updating item ${itemId} quantity to ${quantity}`);
  }

  function removeCartItem(itemId) {
    console.log(`Removing item ${itemId}`);
    const cartItemsList = $("#cart-items");
    cartItemsList.find(`[data-item-id='${itemId}']`).remove();
  }

  function updateTotalAmount() {
    let totalAmount = 0;
    $("#cart-items li[data-item-id]").each(function () {
      const itemId = $(this).data("item-id");
      const quantity = parseInt($("#quantity-" + itemId).val());
      const price = parseFloat($(this).find("span").text().split(" - $")[1]);
      totalAmount += price * quantity;
    });
    $("#total-amount").text(`$${totalAmount.toFixed(2)}`);
  }

  fetchCartData();
});
