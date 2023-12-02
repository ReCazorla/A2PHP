<?php
include("../../db/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Delete Successful'); window.location.href = 'view_users.php';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request.";
}


$conn->close();
?>

<script>
    function alert() {
        alert(isset($_POST["confirm"]));
    }
</script>