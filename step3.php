<?php
session_start();

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamData = $_POST;

    // Save form data to step3.txt
    $step3Filename = 'step3.txt';
    $step3Content = json_encode($teamData);

    $step3Result = file_put_contents($step3Filename, $step3Content);

    if ($step3Result === false) {
        error_log("Failed to write to file: $step3Filename");
    }

    $_SESSION['step3'] = $teamData;
    header('Location: final_page.php');
    exit();
}

$teamNames = [];
$teamValues = [];
if (isset($_SESSION['step2'])) {
    // Access the form data
    $teamData = $_SESSION['step2'];

    // Extract team names and values
    foreach ($teamData as $key => $value) {
        if (strpos($key, 'team') === 0) {
            $teamNames[] = $key;
            $teamValues[] = $value;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Input</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }

        .container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        form {
            display: flex;
            flex-direction: column;
            overflow-y: scroll;
            height: 400px; /* Set the height to limit the form container */
        }

        label,
        input[type="text"] {
            margin-bottom: 10px;
        }

        .label-uppercase {
            text-transform: uppercase;
            font-weight: bold;
        }

        .team-field {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .add-field-btn {
            margin-top: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="" id="employee-form">
            <?php foreach ($teamNames as $index => $teamName): ?>
                <?php $teamValue = $teamValues[$index]; ?>
                <div class="team-field">
                    <label for="employee_name" class="label-uppercase"><?php echo $teamValue; ?>:</label>
                    <div class="employee-fields">
                        <input type="text" name="<?php echo $teamName; ?>[]" placeholder="Employee Name" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary add-field-btn" onclick="addEmployeeField(this)">Add Employee</button>
                </div>
            <?php endforeach; ?>

            <input type="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function addEmployeeField(button) {
            var employeeFields = button.previousElementSibling;
            var newEmployeeField = employeeFields.firstElementChild.cloneNode(true);
            newEmployeeField.value = '';

            employeeFields.appendChild(newEmployeeField);
        }
    </script>
</body>
</html>
