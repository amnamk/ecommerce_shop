$(document).ready(function () {
  function fetchBlogData() {
    $.getJSON("js/blogs.json", function (response) {
      if (response && Array.isArray(response)) {
        renderBlogPosts(response);
      } else {
        console.error("Invalid response data");
      }
    }).fail(function (error) {
      console.error("Error fetching blog data:", error);
    });
  }

  function renderBlogPosts(blogs) {
    const blogsContainer = $("#blogs .row");
    blogsContainer.empty();

    blogs.forEach((blog) => {
      const blogHTML = `
          <section class="card border-0 col-md-6 col-lg-4 bg-transparent my-3">
            <img src="${blog.image}" alt="${blog.title}" />
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
