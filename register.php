<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration using Jquery Ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
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
    <div class="container mt-4">
        <div class="row">
            <div class="card mx-auto" style="width: 40rem;">
                <div class="card-body">
                    <div class="card-text">
                        <div class="col text-center text-white bg-secondary p-1">
                            <h2>User Registration</h2>
                        </div>
                    </div>
                </div>

                <form id="data_form">
                    <div class="row mt-2">
                        <div class="col">
                            <label class="form-label">Name:</label>
                            <input type="text" id="name" name="name" placeholder="Enter Your Name:" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label class="form-label">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Enter Your Email:" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label class="form-label">Phone_no:</label>
                            <input type="number" name="phone_no" id="phone_no" placeholder="Enter Your Number:" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label class="form-label">Address:</label>
                            <textarea name="address" id="address" class="form-control" placeholder="Enter your Address:"></textarea>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label class="form-label">State:</label>
                            <select name="state" id="state" class="form-control form-control-lg">
                                <option value="">Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label class="form-label">District:</label>
                            <select name="district" id="district" class="form-control form-control-lg" disabled>
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <input type="submit" id="submit" class="btn btn-primary" value="Submit" name="submit">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function loaddata() {
                $.ajax({
                    url: 'get_state.php',
                    type: 'GET',
                    success: function(data) {
                        $('#state').append(data);
                        // console.log("data is:",data);
                    }
                });
            }
            loaddata();

            $('#state').on('change', function() {
                var state_id = $(this).val();
                $('#district').empty();
                if (state_id !== "") {
                    $('#district').prop('disabled', false);
                    getDistricts(state_id);
                } else {
                    $('#district').prop('disabled', true);
                }
            });

            function getDistricts(state_id) {
                $.ajax({
                    url: 'get_district.php',
                    type: 'GET',
                    data: {
                        state_id: state_id
                    },
                    success: function(data) {
                        $('#district').append(data);
                    }
                });
            }

            function submitForm(form) {
                var formData = $(form).serialize(); //serialize means collect all form data(input) 
                //  (only those which is in name attribute) and convert them into url encoded string 
                $.ajax({
                    url: 'insert.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log("AJAX Response:", response);
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Data inserted successfully!",
                            showConfirmButton: false, //to hide confirm ok button
                            timer: 1000
                        });
                        // $("#data_form")[0].reset();
                        setTimeout(function() {
                            window.location.href = "index.php";
                        }, 1000);

                    },
                    error: function() {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "error submitting data",
                            showConfirmButton: false,
                            timer: 4000

                        });
                    }
                });
            }

            $.validator.addMethod("emailExists", function(value, element) {
                var response = false;
                $.ajax({
                    url: 'check_email.php',
                    type: 'POST',
                    data: {
                        email: value,

                    },
                    async: false, //this makes the AJAX call synchronous (blocking). The code waits until the AJAX finishes before continuing
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

            $('#data_form').validate({
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
                        required: 'Email is required',
                        email: "Please enter a valid email address",
                        emailExists: "Email already exists"
                    },
                    phone_no: "Phone No is required",
                    address: "Address is required",
                    state: "State is required",
                    district: "District is required"
                },
                submitHandler: function(form) {
                    submitForm(form); // call when form(all fields are valid)
                }
            });

        });
    </script>
</body>

</html>