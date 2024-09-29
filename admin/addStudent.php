<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Student</title>

    <style>
        /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
    color: #333;
}

body {
    background-color: #f9f9f9;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Header */
header {
    background-color: #016a70;
    padding: 20px;
    text-align: center;
    color: white;
}

header h1 {
    font-size: 2.5rem;
}

/* Container */
.container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 40px;
}

.container h2 {
    font-size: 2rem;
    color: #016a70;
    margin-bottom: 30px;
}

/* Form Styling */
.student-form {
    width: 100%;
    max-width: 600px;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.student-form label {
    display: block;
    margin-bottom: 10px;
    color: #333;
    font-weight: bold;
    font-size: 1.1rem;
}

.student-form input[type="text"],
.student-form input[type="number"],
.student-form input[type="file"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

.student-form button {
    width: 100%;
    background-color: #016a70;
    color: white;
    padding: 14px;
    font-size: 1.2rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.student-form button:hover {
    background-color: #018c94;
}

/* Back to Dashboard Button */
.back-button {
    background-color: #555;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    margin-bottom: 30px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.back-button:hover {
    background-color: #777;
}

/* Footer */
footer {
    background-color: #016a70;
    color: white;
    text-align: center;
    padding: 20px 0;
    font-size: 1rem;
}

    </style>
</head>
<body>
<?php
include('../dbcon.php');

if (isset($_POST['name']) && isset($_POST['rollno']) && isset($_POST['class']) && isset($_POST['parentcontact']) && isset($_POST['city'])) {
    $fullname = $_POST['name'];
    $rollno = $_POST['rollno'];
    $standard = $_POST['class'];
    $parentContact = $_POST['parentcontact'];
    $city = $_POST['city'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($imageTmpPath); // Get binary image data

        // Prepare SQL statement to insert data into the database
        $addStud = $conn->prepare("INSERT INTO students (name, rollno, class, parentcontact, city, image) VALUES (:name, :rollno, :class, :parentcontact, :city, :image)");
        $addStud->bindParam(":name", $fullname);
        $addStud->bindParam(":rollno", $rollno);
        $addStud->bindParam(":class", $standard);
        $addStud->bindParam(":parentcontact", $parentContact);
        $addStud->bindParam(":city", $city);
        $addStud->bindParam(":image", $imageData, PDO::PARAM_LOB); // Bind binary data as LOB

        if ($addStud->execute()) {
            echo "Record has been added successfully."; 
        } else {
            echo "Failed to add record.";
        }
    } else {
        echo "No image uploaded or upload error.";
    }
}
?>
    <header>
        <h1>Student Management System</h1>
    </header>

    <div class="container">
        <h2>Add New Student</h2>

        <!-- Back to Dashboard Button -->
        <a href="admindash.php" class="button back-button">Back to Dashboard</a>

        <form method="post" action="addStudent.php" enctype="multipart/form-data" class="student-form">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Enter name" required> 

            <label for="rollno">Roll Number:</label>
            <input type="number" name="rollno" id="rollno" placeholder="Enter roll number" required>

            <label for="class">Class:</label>
            <input type="text" name="class" id="class" placeholder="Enter class" required>

            <label for="parentcontact">Parent Contact:</label>
            <input type="number" name="parentcontact" id="parentcontact" placeholder="Enter parent contact" required>

            <label for="city">City:</label>
            <input type="text" name="city" id="city" placeholder="Enter city" required>

            <label for="image">Student Image:</label>
            <input type="file" name="image" id="image" required>

            <button type="submit" name="addStu">Add Student</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Student Management System. All rights reserved.</p>
    </footer>
</body>    
</html>
