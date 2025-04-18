<?php
// API endpoint for user registration
header("Content-Type: application/json");
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = md5($_POST['password'] ?? '');
    $email = $conn->real_escape_string($_POST['email'] ?? '');
    $userType = $conn->real_escape_string($_POST['userType'] ?? '');
    // $studentID = $conn->real_escape_string($_POST['studentID'] ?? '');
    
    // Email exists and proceed with registration if email unique
    $checkQuery = "SELECT * FROM Users WHERE username='$username'";
    $checkResult = $conn->query($checkQuery);
    if ($checkResult && $checkResult->num_rows > 0) {
        echo json_encode (["success" => false, "message" => "Email already registered."]);
        exit();
    }
    // Validate that studentID is exactly 7 digits
    // if (!preg_match('/^\d{7}$/', $studentID)) {
    //     echo json_encode(["success" => false, "message" => "Student ID must be exactly 7 digits."]);
    //     exit();
    // }
    
    // Check if studentID already exists
    // $checkQuery = "SELECT * FROM Users WHERE studentID='$studentID'";
    // $checkResult = $conn->query($checkQuery);
    // if ($checkResult && $checkResult->num_rows > 0) {
    //     echo json_encode(["success" => false, "message" => "Student ID already registered."]);
    //     exit();
    // }
    
    // Proceed with registration if studentID is unique
    // $sql = "INSERT INTO Users (studentID, username, password, email, userType)
    //         VALUES ('$studentID', '$username', '$password', '$email', '$userType')";
    // if ($conn->query($sql) === TRUE) {
    //     echo json_encode(["success" => true, "message" => "Registration successful."]);
    // } else {
    //     echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    // }

    // Proceed with registration for email uniqueness
    $sql = "INSERT INTO Users (username, password, email, userType)
            VALUES ('$username', '$password', '$email', '$userType')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Registration successful."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
