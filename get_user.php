 <?php
    include('db.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM student WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row); //  returns JSON
        } else {
            echo json_encode(["error" => "No user found"]);
        }
    } else {
        echo json_encode(["error" => "No ID provided"]);
    }
    ?>




