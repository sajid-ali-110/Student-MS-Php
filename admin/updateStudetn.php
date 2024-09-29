<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <style>
        /* Header and Footer Styling */
        header, footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        header a, footer a {
            color: #ffcc00;
            text-decoration: none;
        }
        header a:hover, footer a:hover {
            text-decoration: underline;
        }

        /* Back to Dashboard button styling */
        .back-dashboard {
            display: block;
            margin: 20px auto;
            width: 150px;
            text-align: center;
            padding: 10px;
            background-color: #555;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-dashboard:hover {
            background-color: #333;
        }

        /* Form styling */
        form {
            width: 50%;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="number"], input[type="file"], button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Back to Dashboard Button -->
    <a href="admindash.php" class="back-dashboard">Back to Dashboard</a>

    <!-- Header -->
    <header>
        <h1>Update Student</h1>
        <p><a href="allstudents.php">Dashboard</a> | <a href="allstudents.php">View Students</a></p>
    </header>

    <!-- Form to update student details -->
    <?php
    include('../dbcon.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            $name = $student['name'];
            $rollno = $student['rollno'];
            $class = $student['class'];
            $parentcontact = $student['parentcontact'];
            $city = $student['city'];
        } else {
            echo "Student not found.";
            exit;
        }
    } else {
        echo "No student ID provided.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = $_POST['name'];
        $rollno = $_POST['rollno'];
        $standard = $_POST['class'];
        $parentContact = $_POST['parentcontact'];
        $city = $_POST['city'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageData = file_get_contents($imageTmpPath);

            $updateStud = $conn->prepare("UPDATE students SET name = :name, rollno = :rollno, class = :class, parentcontact = :parentcontact, city = :city, image = :image WHERE id = :id");
            $updateStud->bindParam(":image", $imageData, PDO::PARAM_LOB);
        } else {
            $updateStud = $conn->prepare("UPDATE students SET name = :name, rollno = :rollno, class = :class, parentcontact = :parentcontact, city = :city WHERE id = :id");
        }

        $updateStud->bindParam(":name", $fullname);
        $updateStud->bindParam(":rollno", $rollno);
        $updateStud->bindParam(":class", $standard);
        $updateStud->bindParam(":parentcontact", $parentContact);
        $updateStud->bindParam(":city", $city);
        $updateStud->bindParam(":id", $id);

        if ($updateStud->execute()) {
            echo "Record has been updated successfully.";
            header("Location: allstudents.php");
        } else {
            echo "Failed to update record.";
        }
    }
    ?>

    <!-- Update Student Form -->
    <form method="post" action="" enctype="multipart/form-data">
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter name" required> 
        <input type="number" name="rollno" value="<?php echo htmlspecialchars($rollno); ?>" placeholder="Enter roll number" required>
        <input type="text" name="class" value="<?php echo htmlspecialchars($class); ?>" placeholder="Enter class" required>
        <input type="number" name="parentcontact" value="<?php echo htmlspecialchars($parentcontact); ?>" placeholder="Enter parent contact" required>
        <input type="text" name="city" value="<?php echo htmlspecialchars($city); ?>" placeholder="Enter city" required>
        <input type="file" name="image"><br>

        <button type="submit" name="updateStu">Update Student</button>
    </form>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Student Management System. All Rights Reserved.</p>
    </footer>

</body>
</html>
