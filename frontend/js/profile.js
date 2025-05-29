$(document).ready(function () {
  console.log("jQuery is ready and running!");
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
      console.error("Invalid token format:", e);
      return null;
    }
  }

  function populateProfileEmail() {
    if (!token) {
      console.error("No authentication token found.");
      return;
    }

    const payload = parseJwt(token);
    console.log("Decoded token payload:", payload);

    if (payload?.user?.email) {
      $("#profile-email").val(payload.user.email);
      console.log("Email set:", payload.user.email);
    } else {
      console.error("Email not found in token payload.");
    }
  }

  populateProfileEmail();
});
