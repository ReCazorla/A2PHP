<?php
session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: /A2/pages/login/login.html");
    exit;
}

$is_admin = $_SESSION["is_admin"] ?? 0;
$first_name = $_SESSION["first_name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/styles.css" />
    <title>Georgian Employee Register</title>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="images/logo.png" alt="Regina S.A." />
            </div>
            <nav>
                <ul class="left-nav">
                    <li><a href="welcome.php">Home</a></li>
                    <?php if ($is_admin == 1) : ?>
                        <li><a href="pages/employee/employees.php">Add Employee</a></li>
                    <?php endif; ?>
                    <li><a href="pages/employee/view_employees.php">View Employees</a></li>
                    <li><a href="pages/users/view_users.php">View Users</a></li>
                </ul>
                <ul class="right-nav">
                    <li class="logout-link">
                        <a href="pages/logout/logout.php">Logout</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <form>
        <h3>
            Welcome to Employee Register - <?php echo $first_name; ?>
        </h3>
    </form>

    <footer>
        &copy; <?php echo date("Y"); ?> Assignment 2 PHP | Regina Fruet | Student Nº 200552682 |
    </footer>
</body>

</html>
