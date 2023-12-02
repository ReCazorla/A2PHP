<?php
require_once "../../db/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["first_name"];
    $last = $_POST["last_name"];
    $birthday = $_POST["birthday"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $isAdmin = 0;

    if ($password !== $confirmPassword) {
        echo "Error: Passwords do not match.";
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, birthday, username, password, is_admin) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $last, $birthday, $username, $passwordHash, $isAdmin);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Registration successful!'); window.location.href = '/A2/pages/login/login.html';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
