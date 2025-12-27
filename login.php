<?php
session_start();
include "config.php";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row["password"])) {

        // CREATE SESSION HERE
        $_SESSION["user"] = $row["username"];

        echo "success";
    } else {
        echo "wrong_password";
    }
} else {
    echo "user_not_found";
}

$stmt->close();
$conn->close();
?>
