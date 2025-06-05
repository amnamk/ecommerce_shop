$(document).ready(function () {
  function fetchBlogData() {
    const token = localStorage.getItem("user_token");

    if (!token) {
      console.error("No authentication token found.");
      return;
    }

    $.ajax({
      url: "https://urchin-app-a8zw7.ondigitalocean.app//general",
      method: "GET",
      headers: {
        Authentication: token,
      },
      success: function (response) {
        if (response && Array.isArray(response)) {
          renderBlogPosts(response);
        } else {
          console.error("Invalid response format", response);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching blog data:", xhr.responseText || error);
      },
    });
  }

  function renderBlogPosts(blogs) {
    const blogsContainer = $("#blogs .row");
    blogsContainer.empty();

    blogs.forEach((blog) => {
      const blogHTML = `
  <section class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
    <img src="${blog.image_url}" alt="${blog.title}" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover; width: 100%;" />
    <section class="card-body px-0">
      <h4 class="card-title">${blog.title}</h4>
      <p class="card-text mt-3 text-muted">${blog.description}</p>
      <p class="card-text">
        <small class="text-muted">
          <span class="fw-bold">Author: </span>${blog.author}
        </small>
      </p>
    </section>
  </section>
`;
      blogsContainer.append(blogHTML);
    });
  }

  fetchBlogData();
});
