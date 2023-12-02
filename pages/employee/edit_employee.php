<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: /A2/pages/login/login.html");
    exit;
}

$is_admin = isset($_SESSION["is_admin"]) ? $_SESSION["is_admin"] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Employee Edit</title>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="../../images/logo.png" alt="Regina S.A.">
            </div>
            <nav>
                <ul class="left-nav">
                    <li><a href="../../welcome.php">Home</a></li>
                    <?php if ($is_admin == 1): ?>
                        <li><a href="employees.php">Add Employee</a></li>
                    <?php endif; ?>
                    <li><a href="view_employees.php">View Employees</a></li>
                    <li><a href="../users/view_users.php">View Users</a></li>
                </ul>
                <ul class="right-nav">
                    <li class="logout-link"><a href="../../pages/logout/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <form method="post" action="update_employee.php" enctype="multipart/form-data">
        <h1>Edit Employee</h1>

        <?php
        include("../../db/db_connect.php");

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];

            $sql = "SELECT * FROM employees WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" value="<?php echo $row["first_name"]; ?>"><br>

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $row["last_name"]; ?>"><br>

                <label for="company_name">Company Name:</label>
                <input type="text" name="company_name" value="<?php echo $row["company_name"]; ?>"><br>

                <label for="hours_worked">Hours Worked:</label>
                <input type="text" name="hours_worked" value="<?php echo $row["hours_worked"]; ?>"><br>

                <label for="image">Profile Image:</label>
                <input type="file" name="image" accept="image/*"><br>

                <button type="submit">Update</button>
                <?php
            } else {
                echo "Employee not found.";
            }
        } else {
            echo "Invalid request.";
        }

        $conn->close();
        ?>
    </form>

    <footer>
        &copy;
        <?php echo date("Y"); ?> Assignment 2 PHP | Regina Fruet | Student Nº 200552682 |
    </footer>
</body>

</html>