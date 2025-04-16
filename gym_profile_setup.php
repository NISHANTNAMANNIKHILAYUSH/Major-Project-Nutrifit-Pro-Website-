<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gym_fitness_db"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name           = $_POST['name'];
    $age            = $_POST['age'];
    $gender         = $_POST['gender'];
    $email          = $_POST['email'];
    $goal           = $_POST['goal'];
    $current_weight = $_POST['current_weight'];
    $target_weight  = $_POST['target_weight'];
    $workout_time   = $_POST['workout_time'];
    $fitness_level  = $_POST['fitness_level'];

    $stmt = $conn->prepare("INSERT INTO gym_profiles 
        (name, age, gender, email, goal, current_weight, target_weight, workout_time, fitness_level)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sisssiiis", $name, $age, $gender, $email, $goal, $current_weight, $target_weight, $workout_time, $fitness_level);

    if ($stmt->execute()) {
        if ($fitness_level == 'Beginner') {
            header("Location: n,y,n home/Home.html");
        } elseif ($fitness_level == 'Intermediate') {
            header("Location: n,y,n home/hello.html");
        } elseif ($fitness_level == 'Advanced') {
            header("Location: n,y,n home/bye.html");
        } else {
            header("Location: gym_profile_setup.php");
        }
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gym Profile Setup</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    #bgVideo {
      position: fixed;
      top: 0;
      left: 0;
      min-width: 100%;
      min-height: 100%;
      z-index: -1;
      object-fit: cover;
      opacity: 0.6;
    }

    form {
      background: rgba(0, 0, 0, 0.7);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
      max-width: 600px;
      width: 100%;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 2rem;
      color: #fff;
    }

    label {
      margin-top: 15px;
      display: block;
      font-weight: 600;
    }

    input, select {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      background-color: rgba(255, 255, 255, 0.9);
      color: #333;
    }

    input:focus, select:focus {
      outline: none;
      border: 2px solid #28a745;
      box-shadow: 0 0 5px #28a745;
    }

    button {
      margin-top: 25px;
      width: 100%;
      padding: 14px;
      font-size: 16px;
      font-weight: bold;
      color: white;
      background-color: #28a745;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #1f7e37;
    }

    @media (max-width: 600px) {
      form {
        padding: 20px;
      }

      h2 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>

<!-- 🔥 Background Video -->
<video autoplay muted loop id="bgVideo">
  <source src="gymm.webm" type="video/webm">
  Your browser does not support the video tag.
</video>

<form method="POST">
  <h2>Create Your Gym Profile</h2>

  <label>Name</label>
  <input type="text" name="name" required>

  <label>Age</label>
  <input type="number" name="age" min="12" max="100" required>

  <label>Gender</label>
  <select name="gender" required>
    <option value="">--Select--</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
  </select>

  <label>Email</label>
  <input type="email" name="email" required>

  <label>Fitness Goal</label>
  <select name="goal" required>
    <option value="">--Select--</option>
    <option value="Weight Loss">Weight Loss</option>
    <option value="Muscle Gain">Muscle Gain</option>
    <option value="Endurance">Endurance</option>
    <option value="General Fitness">General Fitness</option>
  </select>

  <label>Current Weight (kg)</label>
  <input type="number" name="current_weight" required>

  <label>Target Weight (kg)</label>
  <input type="number" name="target_weight" required>

  <label>Preferred Workout Time</label>
  <select name="workout_time" required>
    <option value="">--Select--</option>
    <option value="Morning">Morning</option>
    <option value="Afternoon">Afternoon</option>
    <option value="Evening">Evening</option>
  </select>

  <label>Fitness Level</label>
  <select name="fitness_level" required>
    <option value="">--Select--</option>
    <option value="Beginner">Beginner</option>
    <option value="Intermediate">Intermediate</option>
    <option value="Advanced">Advanced</option>
  </select>

  <button type="submit">Save Profile</button>
</form>

</body>
</html>
