var AdminDashboardService = {
  init: function () {
    $("#addUserForm").validate({
      submitHandler: function (form) {
        var user = Object.fromEntries(new FormData(form).entries());
        AdminDashboardService.addUser(user);
        form.reset();
      },
    });

    $("#editUserForm").validate({
      submitHandler: function (form) {
        var user = Object.fromEntries(new FormData(form).entries());
        AdminDashboardService.editUser(user);
        console.log("🧾 Submitted user object:", user);
      },
    });

    AdminDashboardService.getAllUsers();
  },

  openAddUserModal: function () {
    $("#addUserModal").show();
  },

  addUser: function (user) {
    $.blockUI({ message: "<h3>Processing...</h3>" });
    RestClient.post(
      "user",
      user,
      function (response) {
        toastr.success("User added successfully");
        $.unblockUI();
        AdminDashboardService.getAllUsers();
        AdminDashboardService.closeUserModal();
      },
      function (response) {
        AdminDashboardService.closeUserModal();
        toastr.error(response.message);
      }
    );
  },

  getAllUsers: function () {
    RestClient.get(
      "users/all",
      function (data) {
        Utils.datatable(
          "users-table",
          [
            { data: "user_id", title: "User ID" },
            { data: "name", title: "Name" },
            { data: "email", title: "Email" },
            { data: "role", title: "Role" },
            {
              title: "Actions",
              render: function (data, type, row, meta) {
                const rowStr = encodeURIComponent(JSON.stringify(row));
                return `<div class="d-flex justify-content-center gap-2 mt-3">
                <button class="btn btn-primary" onclick="AdminDashboardService.openEditUserModal('${row.user_id}')">Edit</button> 
                <button class="btn btn-danger" onclick="AdminDashboardService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete</button>
                </div>`;
              },
            },
          ],
          data,
          10
        );
      },
      function (xhr, status, error) {
        console.error("Error fetching users:", error);
      }
    );
  },

  openEditUserModal: function (user_id) {
    $.blockUI({ message: "<h3>Processing...</h3>" });
    $("#editUserId").val(user_id);
    $("#editUserModal").modal("show");
    AdminDashboardService.getUserById(user_id);
  },

  getUserById: function (user_id) {
    RestClient.get(
      "user/" + user_id,
      function (data) {
        localStorage.setItem("selected_user", JSON.stringify(data));
        $('input[name="name"]').val(data.name);
        $('input[name="email"]').val(data.email);
        $('select[name="role"]').val(data.role);
        $('input[name="user_id"]').val(data.user_id);
        $.unblockUI();
      },
      function (xhr, status, error) {
        console.error("Error fetching user:", error);
        $.unblockUI();
      }
    );
  },

  closeUserModal: function () {
    $("#addUserModal").modal("hide");
    $("#editUserModal").modal("hide");
    $("#deleteUserModal").modal("hide");
  },

  openConfirmationDialog: function (user) {
    console.log("Opening confirmation for: ", user);

    user = JSON.parse(user);

    $("#deleteUserModal").modal("show");
    $("#delete-user-body").html("Do you want to delete user: " + user.name);
    $("#delete_user_id").val(user.user_id);
  },

  deleteUser: function () {
    RestClient.delete(
      "user/" + $("#delete_user_id").val(),
      null,
      function (response) {
        AdminDashboardService.closeUserModal();
        toastr.success("Usser deleted successfully");
        AdminDashboardService.getAllUsers();
      },
      function (response) {
        AdminDashboardService.closeUserModal();
        toastr.error(response.message);
      }
    );
  },

  editUser: function (user) {
    console.log("User object:", user);

    $.blockUI({ message: "<h3>Processing...</h3>" });

    RestClient.patch(
      "user/" + user.id,
      user,
      function (response) {
        $.unblockUI();
        toastr.success("User updated successfully");
        AdminDashboardService.getAllUsers();
        AdminDashboardService.closeUserModal();
      },
      function (response) {
        $.unblockUI();
        toastr.error(response.message || "Failed to update user");
      }
    );
  },
};
