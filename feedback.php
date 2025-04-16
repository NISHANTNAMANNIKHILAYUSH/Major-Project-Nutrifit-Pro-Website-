<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMsg = "";
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $rating  = $_POST['rating'];
    $message = $_POST['message'];

    $sql = "INSERT INTO feedbacks (name, email, rating, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $name, $email, $rating, $message);

    if ($stmt->execute()) {
        $successMsg = "Thank you for your feedback!";
    } else {
        $errorMsg = "Something went wrong. Please try again.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback Form</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(120deg, #1d3557, #457b9d);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      width: 100%;
      max-width: 600px;
      background: rgba(255, 255, 255, 0.08);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      backdrop-filter: blur(12px);
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #f1faee;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 500;
      color: #f1faee;
    }

    input, textarea, select {
      width: 100%;
      padding: 12px;
      margin-top: 6px;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      background-color: #f1faee;
      color: #1d3557;
      transition: 0.3s ease;
    }

    input:focus, textarea:focus, select:focus {
      outline: none;
      box-shadow: 0 0 5px #a8dadc;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    button {
      margin-top: 25px;
      padding: 14px;
      width: 100%;
      background-color: #a8dadc;
      border: none;
      color: #1d3557;
      font-size: 17px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #f1faee;
      color: #457b9d;
    }

    .message {
      margin-top: 15px;
      padding: 12px;
      border-radius: 8px;
      text-align: center;
      font-weight: 600;
    }

    .success {
      background-color: #2a9d8f;
      color: white;
    }

    .error {
      background-color: #e63946;
      color: white;
    }

    @media (max-width: 600px) {
      .container {
        margin: 20px;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>We'd Love Your Feedback</h2>

  <?php if (!empty($successMsg)): ?>
    <div class="message success"><?= $successMsg ?></div>
  <?php endif; ?>

  <?php if (!empty($errorMsg)): ?>
    <div class="message error"><?= $errorMsg ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <label for="name">Your Name</label>
    <input type="text" name="name" required>

    <label for="email">Email</label>
    <input type="email" name="email" required>

    <label for="rating">How would you rate us?</label>
    <select name="rating" required>
      <option value="">--Select--</option>
      <option value="5">Excellent (5)</option>
      <option value="4">Very Good (4)</option>
      <option value="3">Good (3)</option>
      <option value="2">Fair (2)</option>
      <option value="1">Poor (1)</option>
    </select>

    <label for="message">Message</label>
    <textarea name="message" placeholder="Your comments here..." required></textarea>

    <button type="submit">Submit Feedback</button>
  </form>
</div>

</body>
</html>
