<?php
session_start();

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teamData = $_POST;

    // Save form data to step2.txt
    $step2Filename = 'step2.txt';
    $step2Content = json_encode($teamData);

    $step2Result = file_put_contents($step2Filename, $step2Content);

    if ($step2Result === false) {
        error_log("Failed to write to file: $step2Filename");
    }

    $_SESSION['step2'] = $teamData;
    header('Location: step3.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Input</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-y: auto;
        }

        .container {
            width: 500px;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
             /* Added fixed height to the container */
            overflow-y: auto; /* Added overflow scrolling */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold; /* Add font-weight:bold; to make the labels bold */
        }

        input[type="text"],
        input[type="submit"] {
            padding: 10px;
            width: 60%;
            box-sizing: border-box;
        }
        
        .team-field {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .add-btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post" action="">
            <div id="team-fields"></div>

            <input type="submit" name="submit" value="Next" class="btn btn-primary">
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const teamFieldsContainer = document.getElementById('team-fields');
        const form = document.querySelector('form');
        let teamCount = 1;

        function createTeamField() {
            const teamField = document.createElement('div');
            teamField.classList.add('team-field');

            const label = document.createElement('label');
            label.classList.add('form-label');
            label.textContent = 'Team ' + teamCount + ':';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'team' + teamCount;
            input.placeholder = 'Please input team name';
            input.classList.add('form-control');
            input.required = true;

            const addBtn = document.createElement('button');
            addBtn.type = 'button';
            addBtn.classList.add('add-btn');
            addBtn.textContent = 'Add';

            teamField.appendChild(label);
            teamField.appendChild(input);
            teamField.appendChild(addBtn);
            teamFieldsContainer.appendChild(teamField);

            addBtn.addEventListener('click', function() {
                teamCount++;
                createTeamField();
            });

            if (teamCount > 1) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.classList.add('remove-btn');
                removeBtn.textContent = 'Remove';

                teamField.appendChild(removeBtn);

                removeBtn.addEventListener('click', function() {
                    teamField.remove();
                });
            }
        }

        createTeamField();
    });
    </script>
</body>
</html>
