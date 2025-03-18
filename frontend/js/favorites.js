$(document).ready(function () {
  function fetchFavoritesData() {
    $.getJSON("js/favorites.json", function (response) {
      if (response && response.favorites) {
        renderFavoritesItems(response.favorites);
      } else {
        console.error("Invalid response data");
      }
    }).fail(function (error) {
      console.error("Error fetching favorites data:", error);
    });
  }

  function renderFavoritesItems(favorites) {
    const favoritesItemsList = $("#favorites-items");
    favoritesItemsList.empty();

    favorites.forEach((item) => {
      const listItem = `
          <li class="list-group-item d-flex justify-content-between align-items-center flex-column flex-sm-row" data-item-id="${item.id}">
            <div class="d-flex align-items-center mb-2 mb-sm-0">
              <img src="${item.image}" alt="${item.name}" class="img-fluid rounded-circle" style="width: 50px; height: 50px; margin-right: 15px" />
              <span class="text-truncate" style="max-width: 150px;">${item.name} - ${item.price}</span>
            </div>
            <button class="btn btn-danger btn-sm btn-remove mt-2 mt-sm-0" data-item-id="${item.id}">Remove</button>
          </li>
        `;
      favoritesItemsList.append(listItem);
    });

    attachFavoritesItemEventListeners();
  }

  function attachFavoritesItemEventListeners() {
    $(".btn-remove").on("click", function () {
      const itemId = $(this).data("item-id");
      removeFavoriteItem(itemId);
    });
  }

  function removeFavoriteItem(itemId) {
    console.log(`Removing item ${itemId}`);
    const favoritesItemsList = $("#favorites-items");
    favoritesItemsList.find(`[data-item-id='${itemId}']`).remove();
  }

  fetchFavoritesData();
});
