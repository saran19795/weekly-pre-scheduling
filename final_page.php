<?php
session_start();

// Retrieve the form data from the previous page if available
if (isset($_SESSION['step1'])) {
    $week_name = $_SESSION['step1']['week_name'];
    $start_date = $_SESSION['step1']['start_date'];
    $end_date = $_SESSION['step1']['end_date'];
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
if (isset($_SESSION['step3'])) {
    // Access the employee names
    $employeeData = $_SESSION['step3'];

    // Loop through each team's employee names
    foreach ($employeeData as $teamName => $employeeNames) {
        // Skip other session data, if any
        if (strpos($teamName, 'team') === 0) {
            
            foreach ($employeeNames as $employeeName) {
                
            }
          
        }
    }
}

// Process the form data if the current page is submitted


    // Store the form data in the session
    $_SESSION['step1'] = array(
        'week_name' => $week_name,
        'start_date' => $start_date,
        'end_date' => $end_date
    );

    // Generate the table data for the date range
    $start = strtotime($start_date);
    $end = strtotime($end_date);

    $table_data = array();

    while ($start <= $end) {
        $date = date('Y-m-d', $start);
        $day = date('l', $start);

        $table_data[] = array('date' => $date, 'day' => $day);

        $start = strtotime('+1 day', $start);
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Table View</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            margin: 0 auto; /* Center the table horizontally */
            text-align: center;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        #calculate-btn , #saveButton {
            text-align: center;
            margin: 0 auto;
            display: none;
            margin-top: 10px;
            
        }
        #data-table {
            display: none;
            text-align: center;
            margin: 0 auto;
        }
        #table-container {
            text-align: center;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Weekly Pre Scheduling</h1>
    <div id="table-container">
        <label for="week-dropdown">Select Week:</label>
        <select id="week-dropdown">
            <option value="">Select Week</option>
            <option value="week-15"><?php echo $week_name ?> (<?php echo $start_date ?> – <?php echo $end_date ?>)</option>
            <!-- Add more options for other weeks if needed -->
        </select>
        <table id="data-table" class="table table-bordered">
            <thead>
        

        
            <tr>
                <th></th>
                <?php foreach ($table_data as $data): ?>
                <th><?php echo $data['day'];?><br><?php echo $data['date'];?></th>
                <?php endforeach; ?>
                <th>Total</th>
                
            </tr>
        </thead>
        <tbody>
        <?php
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

if (isset($_SESSION['step3'])) {
    // Access the employee names
    $employeeData = $_SESSION['step3'];

    // Loop through each team's employee names
    foreach ($employeeData as $teamName => $employeeNames) {
        // Skip other session data, if any
        if (in_array($teamName, $teamNames)) {
            $teamIndex = array_search($teamName, $teamNames);
            $teamValue = $teamValues[$teamIndex];
            
            echo '<tr>';
            echo '<td><strong>' . $teamValue . '</strong></td>';
            echo '<td contenteditable="true">00:00</td>';
            echo '<td contenteditable="true">00:00</td>';
            echo '<td contenteditable="true">00:00</td>';
            echo '<td contenteditable="true">00:00</td>';
            echo '<td contenteditable="true">00:00</td>';
            echo '<td contenteditable="true">00:00</td>';
            echo '<td contenteditable="true">00:00</td>';
            echo '<td></td>';
            echo '</tr>';

            foreach ($employeeNames as $employeeName) {
                echo '<tr>';
                echo '<td><strong>' . $employeeName . '</strong></td>';
                echo '<td contenteditable="true">00:00</td>';
                echo '<td contenteditable="true">00:00</td>';
                echo '<td contenteditable="true">00:00</td>';
                echo '<td contenteditable="true">00:00</td>';
                echo '<td contenteditable="true">00:00</td>';
                echo '<td contenteditable="true">00:00</td>';
                echo '<td contenteditable="true">00:00</td>';
                echo '<td></td>';
                echo '</tr>';
            }
        }
    }
}
?>


           
            <tr>
                <td>Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    </div>
    <button id="calculate-btn" class="btn btn-primary text-center">Calculate Table</button>
    <button id="saveButton" class="btn btn-success text-center">Save</button>
    <script>




         const dropdown = document.getElementById('week-dropdown');
        const table = document.getElementById('data-table');
        var calculateBtn = document.getElementById("calculate-btn");
        var saveButton = document.getElementById("saveButton");
        

        // Add event listener to the dropdown
        dropdown.addEventListener('change', function() {
            // Check if a week is selected
            if (dropdown.value !== '') {
                table.style.display = 'table'; // Show the table
                calculateBtn.style.display = "block";
                saveButton.style.display = "block";
            } else {
                table.style.display = 'none'; // Hide the table
                calculateBtn.style.display = "none";
                saveButton.style.display = "none";
            }
        });


        const calculateButton = document.getElementById('calculate-btn');
        calculateButton.addEventListener('click', calculateTable);

      function calculateTable() {
    const table = document.getElementById('data-table');
    const rows = table.getElementsByTagName('tr');
    const cols = rows[0].getElementsByTagName('th');
    const totalRow = rows[rows.length - 1];
    const totalCols = totalRow.getElementsByTagName('td');

    // Calculate row totals
    for (let i = 1; i < rows.length - 1; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let rowTotal = 0;

        for (let j = 1; j < cells.length - 1; j++) {
            const cell = cells[j];
            const value = cell.innerText.trim();
            const time = value.split(':');
            const hours = parseInt(time[0]);
            const minutes = parseInt(time[1]);
            const totalMinutes = hours * 60 + minutes;
            rowTotal += totalMinutes;
        }

        cells[cells.length - 1].innerText = formatTime(rowTotal);
    }

    // Calculate column totals
    for (let j = 1; j < cols.length - 1; j++) {
        let colTotal = 0;

        for (let i = 1; i < rows.length - 1; i++) {
            const row = rows[i];
            const cell = row.getElementsByTagName('td')[j];
            const value = cell.innerText.trim();
            const time = value.split(':');
            const hours = parseInt(time[0]);
            const minutes = parseInt(time[1]);
            const totalMinutes = hours * 60 + minutes;
            
            // Exclude rows for Techno Team, Support Team, and Marketing Team
            const teamName = row.getElementsByTagName('td')[0].innerText;
            
            if (teamName !== "<?php if (isset($_SESSION['step3'])) {
    // Access the employee names
    $employeeData = $_SESSION['step3'];

    // Loop through each team's employee names
    foreach ($employeeData as $teamName => $employeeNames) {
        // Skip other session data, if any
        if (strpos($teamName, 'team') === 0) {
            echo  $teamName ;
            
            
        }
    }
}
?>" ) {
                colTotal += totalMinutes;
            }
        }

        totalCols[j].innerText = formatTime(colTotal);
    }
}


        function formatTime(totalMinutes) {
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
        }

        $(document).ready(function() {
    // Save button click event
    $('#saveButton').click(function() {
        var htmlTable = $('#data-table').html(); // Get the HTML content of the table

        // Send an AJAX request to save the table content
        $.ajax({
            type: 'POST',
            url: 'save_table.php',
            data: { tableContent: htmlTable },
            success: function(response) {
                if (response === 'success') {
                    alert('Table saved successfully!');
                } else {
                    alert('Failed to save the table.');
                }
            }
        });
    });
});
    </script>
</body>
</html>

