<?php
include 'connect.php'; // Assuming this includes the correct MySQL connection setup

// Check if the connection is valid
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Search for Package</title>
</head>
<body>

    <div class="container my-5">
        <form method="post">
            <input type="text" placeholder="Search Package" name="search" class="form-control">
            <button type="submit" class="btn btn-dark btn-sm mt-2">Search</button>
        </form>

        <div class="my-5">
            <table class="table table-bordered">
                <?php
                if (isset($_POST['search'])) { // Check if search was submitted
                    $search = $_POST['search'];
                    
                    $sql = "SELECT Package_ID, Registration_ID, Now_Time, Current_City, Delivery_Time, Status
                           FROM Tracking
                           WHERE Package_ID = ?";
                    
                    $stmt = mysqli_prepare($con, $sql);

                    if (!$stmt) {
                        die("Error preparing statement: " . mysqli_error($con)); // Handle preparation failure
                    }

                    mysqli_stmt_bind_param($stmt, 's', $search); // Bind parameter
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result && mysqli_num_rows($result) > 0) { // If results found
                        echo '
                        <thead>
                        <tr>
                        <th>Package ID</th>
                        <th>Registration ID</th>
                        <th>Now Time</th>
                        <th>Current City</th>
                        <th>Delivery Time</th>
                        <th>Status</th>
                        </tr>
                        </thead>
                        ';

                        echo '<tbody>';
                        while ($row = mysqli_fetch_assoc($result)) { 
                            echo '<tr>';
                            echo '<td>' . ($row['Package_ID'] ?? 'N/A') . '</td>';
                            echo '<td>' . ($row['Registration_ID'] ?? 'N/A') . '</td>';
                            echo '<td>' . ($row['Now_Time'] ?? 'N/A') . '</td>';
                            echo '<td>' . ($row['Current_City'] ?? 'N/A') . '</td>';
                            echo '<td>' . ($row['Delivery_Time'] ?? 'N/A') . '</td>';
                            echo '<td>' . ($row['Status'] ?? 'N/A') . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                    } else {
                        echo '<tr><td colspan="6" class="text-center text-danger">Data not found</td></tr>'; // No data found
                    }
                }
                ?>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
