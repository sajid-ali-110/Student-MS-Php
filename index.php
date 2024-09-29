<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Management System</title>
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        
        .header {
            background-color: #004080;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-around;
            font-size: 24px;
            align-items: center;
        }
        .header a{
        	text-decoration: none;
        	color: #fff;
        }

        footer {
            background-color: #004080;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
        
        .container {
            margin: 30px auto;
            width: 60%;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        
        h1 {
            text-align: center;
            color: #333;
        }
        
        table {
            width: 100%;
            margin-top: 20px;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #004080;
            color: white;
            text-align: center;
        }
        
        td {
            background-color: #f9f9f9;
        }
        
        select, input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        input[type="submit"] {
            width: 100%;
            background-color: #004080;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #003060;
        }

        .result {
            margin-top: 20px;
            background-color: #e6f2ff;
            padding: 15px;
            border-radius: 5px;
        }

        .result p {
            font-size: 18px;
            color: #004080;
        }

          .card-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .student-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 300px;
        margin: 20px;
        text-align: center;
        transition: transform 0.3s;
    }

    .student-card:hover {
        transform: scale(1.05);
    }

    .student-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        border: 3px solid #004080;
    }

    .student-info h2 {
        color: #004080;
        margin-bottom: 10px;
    }

    .student-info p {
        font-size: 16px;
        color: #333;
        margin: 5px 0;
    }
    .read_mr {
    	color: blue;
    	text-decoration: none	;
    }
    </style>
</head>

<body>

<div class="header">
	<p>Home</p>
	<p> Student Management System </p>
	<a href="login.php">Login</a>
</div>

<div class="container">
    <h1>Welcome to Student Management System</h1>
    <form method="post" action="">
        <table>
            <tr>
                <th colspan="2">Student Information</th>
            </tr>
            <tr>
                <td>Choose Standard</td>
                <td>
                    <select name="standard">
                        <option>1st</option>
                        <option>2nd</option>
                        <option>3rd</option>
                        <option>4th</option>
                        <option>5th</option>
                        <option>7th</option>
                        <option>8th</option>
                        <option>9th</option>
                        <option>10th</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name of Student</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Enter Roll Number</td>
                <td><input type="number" name="rollno"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="showinfo" value="Show Info">
                </td>
            </tr>
        </table>
    </form>

    <!-- Display Dummy User Info -->
<?php
require_once("dbcon.php");

if (isset($_POST['showinfo'])) {
    $standard = $_POST['standard'];
    $name = $_POST['name'];
    $rollno = $_POST['rollno'];

    // Prepare the SQL statement
    $students = $conn->prepare("SELECT * FROM students WHERE class = :standard AND name = :name AND rollno = :rollno");

    // Bind the parameters
    $students->bindParam(":standard", $standard);
    $students->bindParam(":name", $name);
    $students->bindParam(":rollno", $rollno);

    // Execute the statement
    $students->execute();

    // Fetch the results
    $result = $students->fetchAll(PDO::FETCH_ASSOC);

    // Check if any result is found
    if ($result) {
        echo "<div class='card-container'>";
        foreach ($result as $row) {
            echo "<div class='student-card'>";

            // Display student image as a base64-encoded image (if available)
            if (!empty($row['image'])) {
                echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' alt='Student Image' class='student-image'>";
            } else {
                echo "<img src='uploads/default.png' alt='Default Image' class='student-image'>"; // Default image if no image available
            }

            // Display student info
            echo "<div class='student-info'>";
            echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
            echo "<p><strong>Roll Number:</strong> " . htmlspecialchars($row['rollno']) . "</p>";
            echo "<p><strong>Class:</strong> " . htmlspecialchars($row['class']) . "</p>";
            echo "<a href='#' class='read_mr'> Read More </a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<div class='result'><p>No user found. Please enter the correct information.</p></div>";
    }
}
?>


</div>

<footer>
    &copy; 2024 Student Management System
</footer>

</body>
</html>
