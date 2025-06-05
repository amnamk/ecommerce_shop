let Constants = {
  get_api_base_url: function () {
    if (location.hostname === "localhost") {
      return "http://localhost/web_ecommerce_shop/backend/";
    } else {
      return "https://urchin-app-a8zw7.ondigitalocean.app/backend/";
    }
  },
  USER_ROLE: "user",
  ADMIN_ROLE: "admin",
};
