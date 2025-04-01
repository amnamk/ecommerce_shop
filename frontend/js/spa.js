$(document).ready(function () {
  var app = $.spapp({
    defaultView: "home",
    templateDir: "./views/",
    pageNotFound: "404.html",
    cacheViews: false,
  });

  function renderProducts(products) {
    var collectionContainer = $("#collection-items-container");

    collectionContainer.empty();

    if (products && products.length > 0) {
      products.forEach(function (product) {
        var productHTML = `
          <div class="product-item" data-id="${product.id}">
            <img src="${product.image}" alt="${product.name}" class="product-item-image">
            <div class="product-item-details">
              <h3>${product.name}</h3>
              <p>${product.description}</p>
              <p>Price: $${product.price}</p>
              <button class="btn btn-add-to-cart" data-id="${product.id}">Add to Cart</button>
              <button class="btn btn-add-to-favorites" data-id="${product.id}">Add to Favorites</button>
            </div>
          </div>
        `;
        collectionContainer.append(productHTML);
      });
    } else {
      collectionContainer.append("<p>No products found.</p>");
    }
  }

  function fetchProducts() {
    $.getJSON("js/products.json", function (data) {
      var products = data.products;
      renderProducts(products);
    }).fail(function (error) {
      console.error("Error fetching products data:", error);
    });
  }

  function fetchSpecialProducts() {
    $.getJSON("js/specialproducts.json", function (data) {
      var specialProducts = data.specialProducts;
      renderProducts(specialProducts);
    }).fail(function (error) {
      console.error("Error fetching special products data:", error);
    });
  }

  function attachCartItemEventListeners() {
    $(".btn-increase").on("click", function () {
      const itemId = $(this).data("item-id");
      const quantityInput = $("#quantity-" + itemId);
      let quantity = parseInt(quantityInput.val());
      quantity += 1;
      quantityInput.val(quantity);
      updateCartItemQuantity(itemId, quantity);
    });
  }

  function initializeSearch() {
    $("#searchInput").on("input", function () {
      var searchQuery = this.value.toLowerCase().trim();

      $(".product-item").each(function () {
        var productName = $(this).find("h3").text().toLowerCase();
        var productDescription = $(this).find("p").text().toLowerCase();

        if (
          productName.includes(searchQuery) ||
          productDescription.includes(searchQuery)
        ) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  }

  function initializeFiltering() {
    $(".filter-btn").on("click", function () {
      var selectedCategory = $(this).data("category");

      $(".product-item").each(function () {
        var itemCategory = $(this).data("category");

        if (selectedCategory === "all" || itemCategory === selectedCategory) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
  }

  function fetchPopularProducts() {
    $.getJSON("js/popular.json", function (data) {
      renderPopularProducts(data.popularProducts);
    }).fail(function (error) {
      console.error("Error fetching popular products data:", error);
    });
  }

  function renderPopularProducts(data) {
    var topRatedContainer = $("#top-rated-container");
    topRatedContainer.empty();
    data.topRated.forEach(function (product) {
      var productHTML = `
        <div class="d-flex align-items-start justify-content-start">
          <img src="${product.image}" alt="${product.name}" class="img-fluid pe-3 w-25" />
          <div>
            <p class="mb-0">${product.name}</p>
            <span>${product.price}</span>
          </div>
        </div>
      `;
      topRatedContainer.append(productHTML);
    });

    var bestSellingContainer = $("#best-selling-container");
    bestSellingContainer.empty();
    data.bestSelling.forEach(function (product) {
      var productHTML = `
        <div class="d-flex align-items-start justify-content-start">
          <img src="${product.image}" alt="${product.name}" class="img-fluid pe-3 w-25" />
          <div>
            <p class="mb-0">${product.name}</p>
            <span>${product.price}</span>
          </div>
        </div>
      `;
      bestSellingContainer.append(productHTML);
    });

    var onSaleContainer = $("#on-sale-container");
    onSaleContainer.empty();
    data.onSale.forEach(function (product) {
      var productHTML = `
        <div class="d-flex align-items-start justify-content-start">
          <img src="${product.image}" alt="${product.name}" class="img-fluid pe-3 w-25" />
          <div>
            <p class="mb-0">${product.name}</p>
            <span>${product.price}</span>
          </div>
        </div>
      `;
      onSaleContainer.append(productHTML);
    });
  }

  function renderCartItems(cartItems) {
    const cartItemsList = $("#cart-items");
    cartItemsList.empty();

    cartItems.forEach((item) => {
      const listItem = `
        <li class="list-group-item d-flex justify-content-between align-items-center" data-item-id="${
          item.id
        }">
          <div class="d-flex align-items-center">
            <img src="${item.image}" alt="${
        item.name
      }" class="img-fluid" style="width: 50px; height: 50px; margin-right: 15px" />
            <span>${item.name} - $${item.price.toFixed(2)}</span>
          </div>
          <div class="d-flex align-items-center">
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
          <button class="btn btn-danger btn-sm btn-remove" data-item-id="${
            item.id
          }">Remove</button>
        </li>
      `;
      cartItemsList.append(listItem);
    });

    attachCartItemEventListeners();
  }

  function renderBlogs(blogs) {
    var blogContainer = $("#blog-posts-container");

    blogContainer.empty();

    if (blogs && blogs.length > 0) {
      blogs.forEach(function (blog) {
        var blogHTML = `
          <div class="blog-post" data-id="${blog.id}">
            <h3>${blog.title}</h3>
            <p>${blog.excerpt}</p>
            <a href="#/blog/${blog.id}" class="btn btn-view">Read More</a>
          </div>
        `;
        blogContainer.append(blogHTML);
      });
    } else {
      blogContainer.append("<p>No blog posts found.</p>");
    }
  }

  function fetchBlogs() {
    $.getJSON("js/blogs.json", function (data) {
      var blogs = data.blogs;
      renderBlogs(blogs);
    }).fail(function (error) {
      console.error("Error fetching blog data:", error);
    });
  }

  app.route({
    view: "collection",
    load: "collection.html",
    onCreate: function () {
      console.log("Collection view loaded");
      $.getScript("js/products.js", function () {
        fetchProducts();
        initializeSearch();
        initializeFiltering();
      });
    },
  });

  app.route({
    view: "home",
    load: "home.html",
  });

  app.route({
    view: "admin",
    load: "admin_dashboard.html",
  });

  app.route({
    view: "favorites",
    load: "favorites.html",
    onCreate: function () {
      console.log("Favorites view loaded");
      renderFavorites();
    },
  });

  app.route({
    view: "blogs",
    load: "blogs.html",
    onCreate: function () {
      console.log("Blogs view loaded");
      fetchBlogs();
    },
  });

  app.route({
    view: "about",
    load: "about.html",
  });

  app.route({
    view: "special",
    load: "special.html",
    onCreate: function () {
      console.log("Special products view loaded");
      fetchSpecialProducts();
    },
  });

  app.route({
    view: "popular",
    load: "popular.html",
    onCreate: function () {
      console.log("Popular view loaded");
      $.getScript("js/popular.js", function () {
        fetchPopularProducts();
      });
    },
  });

  app.route({
    view: "cart",
    load: "cart.html",
    onCreate: function () {
      console.log("Cart view is loaded");
      $.getJSON("js/cart.json", function (response) {
        renderCartItems(response.cartItems);
      }).fail(function (error) {
        console.error("Error fetching cart data:", error);
      });
    },
  });

  app.route({ view: "register", load: "register.html" });
  app.route({ view: "profile", load: "profile.html" });
  app.route({ view: "login", load: "login.html" });
  app.route({
    view: "productSection",
    load: "productSection.html",
  });

  app.route({
    view: "payment",
    load: "payment.html",
  });

  app.route({
    view: "success",
    load: "success_order.html",
  });
  app.route({
    view: "reset",
    load: "reset_password.html",
  });

  $(document).on("click", ".nav-link", function () {
    $("main > section").hide();
    var target = $(this).attr("href").substring(1);
    $("#" + target).show();
  });

  app.run();
});
