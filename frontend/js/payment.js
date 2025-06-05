function parseJwt(token) {
  try {
    return JSON.parse(atob(token.split(".")[1]));
  } catch (e) {
    return null;
  }
}

function validateExpiryDate(expiry) {
  if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) return false;

  const parts = expiry.split("/");
  const month = parseInt(parts[0], 10);
  const year = 2000 + parseInt(parts[1], 10);
  const now = new Date();
  const expiryDate = new Date(year, month);

  return expiryDate > now;
}

$(document).ready(function () {
  $("#payment-form").submit(function (e) {
    e.preventDefault();

    const cardholder_name = $("input[name='cardholder_name']").val().trim();
    const card_number = $("input[name='card_number']").val().trim();
    const expiry_date = $("input[name='expiry_date']").val().trim();
    const cvv = $("input[name='cvv']").val().trim();
    const address = $("input[name='address']").val().trim();
    const state = $("input[name='state']").val().trim();

    if (!cardholder_name) {
      toastr.error("Cardholder Name is required.");
      return;
    }

    if (!/^\d{16}$/.test(card_number)) {
      toastr.error("Card Number must be exactly 16 digits.");
      return;
    }

    if (!validateExpiryDate(expiry_date)) {
      toastr.error("Expiry Date must be in MM/YY format and in the future.");
      return;
    }

    if (!/^\d{3,4}$/.test(cvv)) {
      toastr.error("CVV must be 3 or 4 digits.");
      return;
    }

    if (!address) {
      toastr.error("Address is required.");
      return;
    }

    if (!state) {
      toastr.error("State is required.");
      return;
    }

    const token = localStorage.getItem("user_token");
    if (!token) {
      alert("Please login to continue.");
      return;
    }

    const decoded = parseJwt(token);
    if (!decoded || !decoded.user?.user_id) {
      alert("Invalid token. Please login again.");
      return;
    }

    const paymentData = {
      user_id: decoded.user.user_id,
      cardholder_name,
      card_number,
      expiry_date,
      cvv,
      address,
      state,
    };

    $.blockUI({ message: "<h3>Processing Payment...</h3>" });
    $.ajax({
      url: "https://urchin-app-a8zw7.ondigitalocean.app/payments",
      method: "POST",
      headers: {
        Authentication: token,
      },
      contentType: "application/json",
      data: JSON.stringify(paymentData),
      success: function (response) {
        toastr.success("Payment added successfully!");
        $.unblockUI();
        $("#payment-form").after(
          '<p class="text-success mt-3">Your order was paid successfully!</p>'
        );
      },
      error: function (xhr) {
        toastr.error("Failed to add payment: " + xhr.responseText);
        $.unblockUI();
      },
    });
  });
});
