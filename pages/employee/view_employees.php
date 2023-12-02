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
    <title>Employee List</title>
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

    <section>
        <form>
            <h1>Employee List</h1>

            <?php
            include("../../db/db_connect.php");

            $sql = "SELECT id, first_name, last_name, company_name, hours_worked, image_id FROM employees";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            $id_user = 0;

            if ($result->num_rows > 0):
                ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Company's Name</th>
                        <th>Hours Worked</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    while ($row = $result->fetch_assoc()):
                        $id_user = ++$id_user;
                        ?>
                        <tr>
                            <td>
                                <?= $id_user ?>
                            </td>
                            <td>
                                <?= $row["first_name"] ?>
                            </td>
                            <td>
                                <?= $row["last_name"] ?>
                            </td>
                            <td>
                                <?= $row["company_name"] ?>
                            </td>
                            <td>
                                <?= $row["hours_worked"] ?>
                            </td>
                            <td class="employee_image">
                                <img src="../../uploads/<?= $row["image_id"] ?>" width="70px" alt="Image" />
                            </td>

                            <td class="buttons-column">
                                <?php if ($is_admin == 1): ?>
                                    <a class="edit-button" href="edit_employee.php?id=<?= $row["id"] ?>">Edit</a> |
                                    <a class="delete-button" href="javascript:void(0);"
                                        onclick="confirmDelete(<?= $row["id"] ?>)">Delete</a>
                                <?php else: ?>
                                    <a class="edit-button-disabled">Edit</a> |
                                    <a class="delete-button-disabled">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                </table>
            <?php else: ?>
                <p>No records found</p>
            <?php endif;

            $stmt->close();
            $conn->close();
            ?>

            <script>
                function confirmDelete(id) {
                    var userConfirmed = confirm("Are you sure you want to delete the record?");
                    if (userConfirmed) {
                        window.location.href = 'delete_employee.php?id=' + id + '&confirm=yes';
                    }
                }
            </script>
        </form>
    </section>

    <footer>
        &copy;
        <?php echo date("Y"); ?> Assignment 2 PHP | Regina Fruet | Student Nº 200552682 |
    </footer>
</body>

</html>