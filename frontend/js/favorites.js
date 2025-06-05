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

  function fetchFavoritesData() {
    if (!token) {
      console.error("No authentication token found.");
      return;
    }

    const payload = parseJwt(token);
    if (!payload || !payload.user || !payload.user.user_id) {
      console.error("User ID not found in token.");
      return;
    }

    const userId = payload.user.user_id;

    $.ajax({
      url: `https://urchin-app-a8zw7.ondigitalocean.app/favorites/all/${userId}`,
      method: "GET",
      headers: {
        Authentication: token,
      },
      success: function (response) {
        if (response && Array.isArray(response)) {
          renderFavoritesItems(response);
        } else {
          console.error("Invalid response data:", response);
        }
      },
      error: function (xhr, status, error) {
        console.error(
          "Error fetching favorites data:",
          xhr.responseText || error
        );
      },
    });
  }

  function renderFavoritesItems(favorites) {
    const favoritesItemsList = $("#favorites-items");
    favoritesItemsList.empty();

    favorites.forEach((item) => {
      const listItem = `
        <li class="list-group-item d-flex justify-content-between align-items-center flex-column flex-sm-row" data-item-id="${
          item.favorite_id
        }">
          <div class="d-flex align-items-center mb-2 mb-sm-0">
            <img src="${item.picture || item.image || ""}" alt="${
        item.name
      }" class="img-fluid rounded-circle" style="width: 50px; height: 50px; margin-right: 15px" />
            <span  style="max-width: 850px;">${item.name} - ${parseFloat(
        item.price
      ).toFixed(2)} KM</span>
          </div>
          <button class="btn btn-danger btn-sm btn-remove mt-2 mt-sm-0" data-item-id="${
            item.favorite_id
          }">Remove</button>
        </li>
      `;
      favoritesItemsList.append(listItem);
    });

    attachFavoritesItemEventListeners();
  }

  function attachFavoritesItemEventListeners() {
    $(".btn-remove").on("click", function () {
      const itemId = $(this).data("item-id");
      if (confirm("Are you sure you want to remove this favorite?")) {
        removeFavoriteItem(itemId);
      }
    });
  }

  function removeFavoriteItem(itemId) {
    $.ajax({
      url: `https://urchin-app-a8zw7.ondigitalocean.app/favorites/${itemId}`,
      method: "DELETE",
      headers: {
        Authentication: token,
      },
      success: function (response) {
        console.log(response.message);
        toastr.success("Removed successfully!");
        $("#favorites-items").find(`[data-item-id='${itemId}']`).remove();
      },
      error: function (xhr, status, error) {
        console.error("Error deleting favorite:", xhr.responseText || error);
        alert("Failed to remove favorite.");
        toastr.success("Failed to remove!");
      },
    });
  }

  fetchFavoritesData();
});
