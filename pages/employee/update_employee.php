<?php
include("../../db/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $company_name = $_POST["company_name"];
    $hours_worked = $_POST["hours_worked"];
    $imageName = basename($_FILES["image"]["name"]);

    $new_image = false;
    $uploadOk = 1;

    if ($imageName === '' || $imageName === null) {
        $sql = "SELECT image_id FROM employees WHERE id = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $imageName = $row["image_id"];
    } else {
        $new_image = true;
        $imageName = uniqid() . "_" . $imageName;
    }

    $targetDirectory = "../../uploads/";
    $targetFile = $targetDirectory . $imageName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($new_image) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.');</script>";
            $uploadOk = 0;
        }

        if (file_exists($targetFile)) {
            echo "<script>alert('Sorry, file already exists.');</script>";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 10000000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }

        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
            $uploadOk = 0;
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile) === false) {
            $uploadOk = 0;
        }
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.');</script>";
        header("Location: view_employees.php");
    } else {
        $sql = "UPDATE employees SET 
                first_name = '$first_name',
                last_name = '$last_name',
                company_name = '$company_name',
                hours_worked = '$hours_worked',
                image_id = '$imageName'
                WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Update Successful');</script>";
            header("Location: view_employees.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "<script>alert(' Ja se foi o disco voador " . $imageName . "');</script>";
}

$conn->close();
?>