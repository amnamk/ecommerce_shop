function parseJwt(token) {
  try {
    return JSON.parse(atob(token.split(".")[1]));
  } catch (e) {
    return null;
  }
}

$(document).ready(function () {
  $("#payment-form").submit(function (e) {
    e.preventDefault();

    const token = localStorage.getItem("user_token");
    if (!token) {
      alert("Please login to continue.");
      return;
    }

    const decoded = parseJwt(token);
    if (!decoded || !decoded.user.user_id) {
      alert("Invalid token. Please login again.");
      return;
    }

    const paymentData = {
      user_id: decoded.user.user_id,
      cardholder_name: $("input[name='cardholder_name']").val(),
      card_number: $("input[name='card_number']").val(),
      expiry_date: $("input[name='expiry_date']").val(),
      cvv: $("input[name='cvv']").val(),
      address: $("input[name='address']").val(),
      state: $("input[name='state']").val(),
    };

    $.ajax({
      url: "http://localhost/web_ecommerce_shop/backend/payments",
      method: "POST",
      headers: {
        Authentication: token,
      },
      contentType: "application/json",
      data: JSON.stringify(paymentData),
      success: function (response) {
        toastr.success("Payment added successfully!");
        $("#payment-form").after(
          '<p class="text-success mt-3">Your order was paid successfully!</p>'
        );
      },
      error: function (xhr) {
        toastr.error("Failed to add payment: " + xhr.responseText);
      },
    });
  });
});
