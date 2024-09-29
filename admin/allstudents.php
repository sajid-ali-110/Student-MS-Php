<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        header, footer {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-button {
            position: absolute;
            top: 15px;
            left: 15px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        button {
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
        }

        .green {
            background-color: #4CAF50;
            color: white;
        }

        .red {
            background-color: #f44336;
            color: white;
        }

        footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>

        <?php  
require_once("../dbcon.php");

if (isset($_POST['delete'])) {
    // Get the student ID to delete
    $id = $_POST['delete'];

    // Prepare delete query
    $delete = $conn->prepare("DELETE FROM students WHERE id = :id");
    $delete->bindParam(":id", $id);

    // Execute the delete query and provide feedback
    if ($delete->execute()) {
        echo "Record deleted successfully.";
        // Optionally, redirect to refresh the page and show the updated table
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Unable to delete the record.";
    }
}


// edit record 

if (isset($_POST['edit'])) {
    $id = $_POST['edit'];

    header("Location: updateStudetn.php?id=$id");
    exit();
}
?>

<header>
    <div class="container">
        <h2>Student Management System</h2>
    </div>
</header>

<div class="back-button">
    <a href="admindash.php">Back to Dashboard</a>
</div>

<div class="container">
    <h1>Student List</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Roll No</th>
                <th>Class</th>
                <th>Parent Contact</th>
                <th>City</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once("../dbcon.php");

            // Prepare and execute the SQL statement to fetch student data
            $allstud = $conn->prepare("SELECT * FROM students");
            $allstud->execute();
            $students = $allstud->fetchAll(PDO::FETCH_ASSOC);

            // Loop through each student and display their data in the table
            foreach ($students as $student) {
            ?>
                <tr>
                    <td><?php echo $student['id']; ?></td> <!-- Student ID -->
                    <td><?php echo $student['name']; ?></td> <!-- Student Name -->
                    <td><?php echo $student['rollno']; ?></td> <!-- Roll Number -->
                    <td><?php echo $student['class']; ?></td> <!-- Class -->
                    <td><?php echo $student['parentcontact']; ?></td> <!-- Parent Contact -->
                    <td><?php echo $student['city']; ?></td> <!-- City -->

                    <!-- Check if image data exists -->
                    <td>
                        <?php if (!empty($student['image'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($student['image']); ?>" alt="Student Image" width="100">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>

                    <td>
                        <form method="post" action="" style="display: inline-block;">
                            <input type="hidden" name="edit" value="<?php echo $student['id']; ?>">
                            <button type="submit" class="green" onclick="return confirm('Are you sure you want to edit this record?')">Edit</button>
                        </form>
                        <form method="post" action="" style="display: inline-block;">
                            <input type="hidden" name="delete" value="<?php echo $student['id']; ?>">
                            <button type="submit" class="red" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<footer>
    <div class="container">
        <p>&copy; 2024 Student Management System. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
