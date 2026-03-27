<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="container mt-3">
        <h1 class="text-center bg-dark text-light p-2">Displaying All Records</h1>

        <div class="mt-2 mb-3">
            <a href="register.php" class="btn btn-success">Add New User</a>
        </div>

        <table class="table table-bordered table-striped" id="users_table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#users_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'fetch.php',
                    type: 'POST'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone_no'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'state_name'
                    },
                    {
                        data: 'district_name'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <a href="update.php?id=${row.id}" class="btn btn-success mx-2 update_btn">Update</a>
                        <a href="#" class="btn btn-danger delete_btn" data-id="${row.id}">Delete</a>

                    `;
                        }
                    }
                ]
            });

            $('#users_table').on('click', '.delete_btn', function(event) {
                event.preventDefault();
                var id = $(this).data("id");
                console.log("id of this", id);         
                if (!confirm("Are you sure you want to delete this record?")) {
                    return;
                }


                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log("server response:", response);
                        if (response) {
                            // alert('Record deleted successfully!');
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Record deleted successfully!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#users_table').DataTable().ajax.reload(); // reload table only
                        } else {
                            alert('Failed to delete record: ' + response);

                        }
                    },
                    error: function(error) {
                        alert("Error deleting record: " + error);
                    }
                });
            });
        });
    </script>
</body>

</html>