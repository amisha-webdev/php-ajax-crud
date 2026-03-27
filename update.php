<?php
include('db.php');

if (isset($_POST['id'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    $state_id = $_POST['state'];
    $district_id = $_POST['district'];

    $query = "UPDATE student SET 
             name = '$name',
             email = '$email',
             phone_no = '$phone_no',
             address = '$address',
             state_id = '$state_id',
             district_id = '$district_id'
             WHERE id = '$id'";


    if (mysqli_query($conn, $query)) {
        echo "data updated successfully";

    } else {
        echo "error updating data" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Registration using Jquery Ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body style="background-color:lightgray;">
    <div class="container mt-4 ">
        <div class="row">
            <div class="card mx-auto  " style="width: 40rem;">
                <div class="card-body">

                    <div class="card-text ">
                        <div class="col text-center text-white bg-secondary p-1 ">
                            <h2>Update User Data</h2>
                        </div>
                    </div>
                </div>
                <form action="" id="update_data">
                    <input type="hidden" id="id" name="id">
                    <div class="row mt-2">
                        <div class="col">
                            <label for="" class="form-label">Name:</label>
                            <input type="text" id="name" name="name" placeholder="Enter Your Name:" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Enter Your Email:" class="form-control">
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="col">
                            <label for="" class="form-label">Phone_no:</label>
                            <input type="number" name="phone_no" id="phone_no" placeholder="Enter Your Number:" class="form-control">
                        </div>
                    </div>
                    <div class="row-mt-2">
                        <div class="col">
                            <label for="" class="form-label">Address:</label>
                            <textarea name="address" id="address" class="form-control" placeholder="Enter your Address:"></textarea>
                        </div>
                    </div>
                    <div class="row mt-2 ">

                        <div class="col">
                            <label for="" class="form-label">State:</label>
                            <select name="state" id="state" class="form-control form-control-lg">
                                <option value="">Select State</option>

                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <label for="" class="form-label">District:</label>
                            <select name="district" id="district" class="form-control form-control-lg" disabled>
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <input type="submit" class="btn btn-primary update_btn" value="Update" name="update" id="update_btn">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Get user ID from URL
            const urlParams = new URLSearchParams(window.location.search);
            const userId = urlParams.get('id');

            console.log("Fetched user ID:", userId);

            if (!userId) {
                alert("No ID found in URL!");
                return;
            }
            $.ajax({
                url: "get_user.php",
                type: "GET",
                data: {
                    id: userId
                },
                dataType: "json",
                success: function(response) {
                    console.log("User Data:", response);

                    if (response) {
                        $("#id").val(response.id);
                        $("#name").val(response.name);
                        $("#email").val(response.email);
                        $("#phone_no").val(response.phone_no);
                        $("#address").val(response.address);

                        $.ajax({
                            url: "get_state.php",
                            type: "GET",
                            success: function(states) {
                                $("#state").html(states);
                                $("#state").val(response.state_id);

                                $.ajax({
                                    url: "get_district.php",
                                    type: "GET",
                                    data: {
                                        state_id: response.state_id
                                    },
                                    success: function(districts) {
                                        $("#district").html(districts);
                                        $("#district").prop('disabled', false);
                                        $("#district").val(response.district_id);
                                    }
                                });
                            }
                        });
                    } else {
                        alert("User not found!");
                    }
                },
                error: function(status, error) {
                    console.error("Error:", error);
                    alert("Failed to fetch user data!");
                }
            });
            $('#state').on('change', function() {
                var state_id = $(this).val();
                $('#district').empty();
                if (state_id !== "") {
                    $('#district').prop('disabled', false);

                    $.ajax({
                        url: 'get_district.php',
                        type: 'GET',
                        data: {
                            state_id: state_id
                        },
                        success: function(data) {
                            $('#district').html(data);
                        }
                    });

                } else {
                    $('#district').prop('disabled', true);
                }
            });
            $.validator.addMethod("emailExists", function(value, element) {
                var response = false;
                $.ajax({
                    url: 'check_email.php',
                    type: 'POST',
                    data: {
                        email: value,
                        user_id: userId
                    },
                    async: false,
                    success: function(data) {
                        if (data.trim() == "available") {
                            response = true;
                        } else {
                            response = false;
                        }
                    }
                });
                return response;
            }, "Email already exists!");



            $("#update_data").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                        emailExists: true
                    },
                    phone_no: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    district: {
                        required: true
                    }
                },

                messages: {
                    name: "Name is required",
                    email: {
                        required: "Email is required",
                        email: "Enter a valid email address",
                        emailExists: "Email already exists"
                    },
                    phone_no: "Phone number is required",
                    address: "Address is required",
                    state: "Please select a state",
                    district: "Please select a district"
                },

                submitHandler: function(form) {
                    $.ajax({
                        url: "update.php",
                        type: "POST",
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.includes("data updated successfully")) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Record updated successfully!",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(function() {
                                    window.location.href = "index.php";
                                }, 1500);
                            } else {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "error",
                                    title: "Updation failed!",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            });

        });
    </script>

</body>

</html>