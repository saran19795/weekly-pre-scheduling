<?php
session_start();

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weekName = $_POST['week_name'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Create DateTime objects for start and end dates
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);

    // Check if end date is greater than start date
    if ($endDateTime <= $startDateTime) {
        $errorMessage = "The end date must be greater than the start date.";
    } else {
        // Calculate the difference in days
        $difference = $startDateTime->diff($endDateTime);
        $differenceInDays = $difference->days;

        if ($differenceInDays !== 6) { // 6 days because the end date is inclusive
            $errorMessage = "The start date and end date must have a 7-day difference.";
        } else {
            // Store form data in session
            $_SESSION['step1'] = $_POST;

            // Append form data to a text file
            $filename = 'step1.txt';
            $fileContent = "Week Name: $weekName\n";
            $fileContent .= "Start Date: $startDate\n";
            $fileContent .= "End Date: $endDate\n\n";

            $result = file_put_contents($filename, $fileContent, FILE_APPEND);

            if ($result === false) {
                error_log("Failed to write to file: $filename");
            }

            // Redirect to step2.php
            header('Location: step2.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Week</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f1f1f1;
        }

        .container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            width: 500px; /* Set a fixed width for the container */
        }

        h1 {
            text-align: center;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

       
        input[type="submit"] {
            margin-top: 50px;
           
        }
        
        .error-message {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($errorMessage)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <h1 class="text-center">Week Details</h1>
        <form method="POST" action="" class="text-center">
            <div class="form-group text-center justify-content-center">
                <label for="week_name">Week Name:</label>
                <input type="text" class="form-control text-center" id="week_name" name="week_name" placeholder="Enter week name" required>
            </div>

            <div class="form-group text-center">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control text-center" id="start_date" name="start_date" required>
            </div>

            <div class="form-group text-center">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control text-center" id="end_date" name="end_date" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
