<?php
include("../../db/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM employees WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Delete Successful";
        header("Location: view_employees.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request.";
}


$conn->close();
?>