<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $treatment = $_POST['treatment'];
    $phone = htmlspecialchars($_POST['phone']);
    $additionalInfo = htmlspecialchars($_POST['additionalInfo']);

    // Check if the email exists in the database
    $sql_check = "SELECT * FROM bookings WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // if email exists, update the booking
        $sql_update = "UPDATE bookings SET treatment = ?, phone = ?, additionalInfo = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssss", $treatment, $phone, $additionalInfo, $email);

        if ($stmt_update->execute()) {
            echo "<script>alert('Booking updated successfully!'); window.location.href = 'appointments.php';</script>";
        } else {
            echo "Error updating booking: " . $conn->error;
        }

        $stmt_update->close();
    } else {
        // If the email doesn't exist
        echo "<script>alert('No booking found with that email!'); window.location.href = 'appointments.php';</script>";
    }

    $stmt_check->close();
}






//deleting booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Get the email of the booking to delete
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Check if the email exists in the database
    $sql_check = "SELECT * FROM bookings WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // if email exists, delete the booking
        $sql_delete = "DELETE FROM bookings WHERE email = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("s", $email);

        if ($stmt_delete->execute()) {
            echo "<script>alert('Booking deleted successfully!'); window.location.href = 'appointments.php';</script>";
        } else {
            echo "Error deleting booking: " . $conn->error;
        }

        $stmt_delete->close();
    } else {
        // If the email doesn't exist
        echo "<script>alert('No booking found with that email!'); window.location.href = 'appointments.php';</script>";
    }

    $stmt_check->close();
}

$conn->close();


?>