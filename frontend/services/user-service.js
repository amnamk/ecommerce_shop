var UserService = {
  init: function () {
    var token = localStorage.getItem("user_token");
    if (token && token !== undefined) {
      window.location.replace("index.html");
    }

    $("#login-form").validate({
      rules: {
        email: {
          required: true,
          email: true,
        },
        password: {
          required: true,
          minlength: 6,
          maxlength: 20,
        },
      },
      messages: {
        email: {
          required: "Please enter your email",
          email: "Please enter a valid email address",
        },
        password: {
          required: "Please enter your password",
          minlength: "Password must be at least 6 characters",
        },
      },
      submitHandler: function (form) {
        console.log("Login form is valid, submitting via AJAX...");
        var entity = Object.fromEntries(new FormData(form).entries());
        UserService.login(entity);
      },
    });

    $("#register-form").validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
        },
        email: {
          required: true,
          email: true,
        },
        password: {
          required: true,
          minlength: 8,
          maxlength: 20,
        },
        confirmPassword: {
          required: true,
          equalTo: "#password",
        },
      },
      messages: {
        name: {
          required: "Please enter your name",
          minlength: "Name must be at least 2 characters",
        },
        email: {
          required: "Please enter your email",
          email: "Please enter a valid email address",
        },
        password: {
          required: "Please enter a password",
          minlength: "Password must be at least 8 characters",
          maxlength: "Password cannot be longer than 20 characters",
        },
        confirmPassword: {
          required: "Please confirm your password",
          equalTo: "Passwords do not match",
        },
      },
      submitHandler: function (form) {
        const formData = new FormData(form);
        formData.delete("confirmPassword");
        const entity = Object.fromEntries(formData.entries());
        UserService.register(entity);
      },
    });
  },

  register: function (entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/register",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        toastr.success("Registered successfully, please login!");
        console.log(result);
        window.location.replace("index.html");
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(
          XMLHttpRequest?.responseText ? XMLHttpRequest.responseText : "Error"
        );
      },
    });
  },

  login: function (entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/login",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function (result) {
        console.log(result);
        toastr.success("Logged in successfully!");
        localStorage.setItem("user_token", result.data.token);
        UserService.generateMenuItems();
        window.location.replace("index.html");
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(
          XMLHttpRequest?.responseText ? XMLHttpRequest.responseText : "Error"
        );
      },
    });
  },

  logout: function () {
    localStorage.clear();
    window.location.replace("index.html");
  },
  generateMenuItems: function () {
    const token = localStorage.getItem("user_token");

    if (!token) {
      const nav =
        '<li class="nav-item px-2 py-2">' +
        '<a class="nav-link text-dark" href="#home">Home</a>' +
        "</li>" +
        '<li class="nav-item px-2 py-2">' +
        '<a class="nav-link text-dark" href="#login">Login</a>' +
        "</li>" +
        '<li class="nav-item px-2 py-2">' +
        '<a class="nav-link text-dark" href="#register">Register</a>' +
        "</li>";

      document.getElementById("tabs").innerHTML = nav;

      const main =
        '<section id="home" data-load="home.html"></section>' +
        '<section id="login" data-load="login.html"></section>' +
        '<section id="register" data-load="register.html"></section>';

      document.getElementById("spapp").innerHTML = main;

      return;
    }

    const user = Utils.parseJwt(token).user;

    if (user && user.role) {
      let nav = "";
      let main = "";

      switch (user.role) {
        case Constants.USER_ROLE:
          nav =
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#home">Home</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#collection">Collection</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#special">Specials</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#blogs">Blogs</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#about">About</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#popular">Popular</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#cart">Cart</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#favorites">Favorites</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#profile">Profile</a>' +
            "</li>";

          document.getElementById("tabs").innerHTML = nav;
          main =
            '<section id="home" data-load="home.html"></section>' +
            '<section id="collection" data-load="collection.html"></section>' +
            '<section id="special" data-load="special.html"></section>' +
            '<section id="blogs" data-load="blogs.html"></section>' +
            ' <section id="about" data-load="about.html"></section>' +
            '<section id="popular" data-load="popular.html"></section>' +
            '<section id="cart" data-load="cart.html"></section>' +
            '<section id="favorites" data-load="favorites.html"></section>' +
            '<section id="profile" data-load="profile.html"></section>' +
            '<section id="productSection" data-load="productSection.html"></section>' +
            '<section id="payment" data-load="payment.html"></section>' +
            '<section id="success" data-load="success_order.html"></section>';

          document.getElementById("spapp").innerHTML = main;
          break;
        case Constants.ADMIN_ROLE:
          console.log("User role:", user.role);
          nav =
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#home">Home</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#collection">Collection</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#special">Specials</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#admin">Admin</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#blogs">Blogs</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#about">About</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#popular">Popular</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#cart">Cart</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#favorites">Favorites</a>' +
            "</li>" +
            '<li class="nav-item px-2 py-2">' +
            '<li class="nav-item px-2 py-2">' +
            '<a class="nav-link text-dark" href="#profile">Profile</a>' +
            "</li>";

          document.getElementById("tabs").innerHTML = nav;

          main =
            '<section id="home" data-load="home.html"></section>' +
            '<section id="collection" data-load="collection.html"></section>' +
            '<section id="special" data-load="special.html"></section>' +
            '<section id="blogs" data-load="blogs.html"></section>' +
            ' <section id="about" data-load="about.html"></section>' +
            '<section id="popular" data-load="popular.html"></section>' +
            '<section id="cart" data-load="cart.html"></section>' +
            '<section id="favorites" data-load="favorites.html"></section>' +
            '<section id="profile" data-load="profile.html"></section>' +
            '<section id="productSection" data-load="productSection.html"></section>' +
            '<section id="payment" data-load="payment.html"></section>' +
            '<section id="success" data-load="success_order.html"></section>' +
            ' <section id="admin" data-load="admin_dashboard.html"></section>';
          document.getElementById("spapp").innerHTML = main;
          break;
        default:
          document.getElementById("tabs").innerHTML = nav;

          document.getElementById("spapp").innerHTML = main;
      }
    } else {
      window.location.replace("login.html");
    }
  },
};
