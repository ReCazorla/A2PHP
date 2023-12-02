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
    <title>User Edit</title>
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
                    <?php if ($is_admin == 1) : ?>
                        <li><a href="../employee/employees.php">Add Employee</a></li>
                    <?php endif; ?>
                    <li><a href="../employee/view_employees.php">View Employees</a></li>
                    <li><a href="view_users.php">View Users</a></li>
                </ul>
                <ul class="right-nav">
                    <li class="logout-link"><a href="../../pages/logout/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <form method="post" action="update_user.php">
        <h1>Edit User</h1>

        <?php
        include("../../db/db_connect.php");

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $id = $_GET["id"];

            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                First Name: <input type="text" name="first_name" value="<?= $row["first_name"] ?>"><br>
                Last Name: <input type="text" name="last_name" value="<?= $row["last_name"] ?>"><br>
                Birthday: <input type="date" name="birthday" value="<?= $row["birthday"] ?>"><br>
                Username: <input type="text" name="username" value="<?= $row["username"] ?>"><br>
                Password: <input type="password" class="edit-password" name="password" required><br>
                <input type="hidden" name="is_admin" value="0">
                <?php
                if ($row["is_admin"] == 1) {
                    echo 'Is Admin: <input type="checkbox" name="is_admin" ' . ($row["is_admin"] == 1 ? 'checked' : '') . ' value="1" /><br>';
                }
                ?>
                <button type="submit">Update User</button>
        <?php
            } else {
                echo "User not found.";
            }
            $stmt->close();
        } else {
            echo "Invalid request.";
        }

        $conn->close();
        ?>
    </form>

    <footer>
        &copy; <?php echo date("Y"); ?> Assignment 2 PHP | Regina Fruet | Student Nº 200552682 |
    </footer>
</body>

</html>
