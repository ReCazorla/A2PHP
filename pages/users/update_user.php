<?php
include("../../db/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $birthday = $_POST["birthday"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $is_admin = $_POST["is_admin"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET 
                first_name = '$first_name',
                last_name = '$last_name',
                birthday = '$birthday',
                username = '$username',
                password = '$passwordHash',
                is_admin = '$is_admin'
                WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Update Successful";
        header("Location: view_users.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else {
    echo "Invalid request.";
}

$conn->close();
?>