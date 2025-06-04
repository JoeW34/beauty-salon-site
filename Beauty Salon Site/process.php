<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $treatment = $_POST['treatment'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $additionalInfo = htmlspecialchars($_POST['additionalInfo']);

    setcookie("email", $email, time() + 86400, "/");
    setcookie("phone", $phone, time() + 86400, "/");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    $sql = "INSERT INTO bookings (treatment, email, phone, additionalInfo) 
            VALUES ('$treatment', '$email', '$phone', '$additionalInfo')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>alert('Form submitted successfully!'); window.location.href = 'appointments.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error: " . $conn->error . "'); window.location.href = 'appointments.php';</script>";
    }

    $conn->close();
} else {
    echo "No data received.";
}




?>