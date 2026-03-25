<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "sumbong_alalay");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = (int)$_POST['age'];
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $concern_id = $_POST['concern_id'];

    if ($concern_id === 'others') {
        $concern_text = mysqli_real_escape_string($conn, $_POST['custom_concern']);
    } else {
        $concerns = [
            '1' => 'Medical Emergency',
            '2' => 'Fire Incident',
            '3' => 'Noise Complaint',
            '4' => 'Dog Waste Complaint'
        ];
        $concern_text = $concerns[$concern_id] ?? 'Other';
    }


    $errors = [];
    if (empty(trim($name))) {
        $errors[] = "Name is required.";
    } elseif (strlen($name) > 255) {
        $errors[] = "Name must be less than 255 characters.";
    }
    if (!is_numeric($age) || $age < 1 || $age > 120) {
        $errors[] = "Age must be a number between 1 and 120.";
    }
    if (empty(trim($location))) {
        $errors[] = "Location is required.";
    } elseif (strlen($location) > 1000) {
        $errors[] = "Location must be less than 1000 characters.";
    }
    if (empty($concern_id)) {
        $errors[] = "Please select a concern.";
    } elseif ($concern_id === 'others' && empty(trim($_POST['custom_concern']))) {
        $errors[] = "Please specify your custom concern.";
    }

    if (!empty($errors)) {
        $error_message = implode("\\n", $errors);
        echo "<script>alert('$error_message'); window.history.back();</script>";
        exit();
    }

    // Duplicate detection: Check for identical location AND concern type within the last 24 hours
    // If duplicate found, flag it for admin review (but allow submission)
    $is_duplicate = 0;
    $duplicate_check_sql = "SELECT id FROM reports 
                            WHERE location = '$location' 
                            AND concern_type = '$concern_text' 
                            AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    $duplicate_result = mysqli_query($conn, $duplicate_check_sql);
    if (mysqli_num_rows($duplicate_result) > 0) {
        $is_duplicate = 1;  // Flag as duplicate for admin to review
    }
    // --- End of added validation rules and duplicate detection ---

    // Insert report with duplicate flag
    $sql = "INSERT INTO reports (reporter_name, age, location, concern_type, status, is_duplicate) 
            VALUES ('$name', $age, '$location', '$concern_text', 'Pending', $is_duplicate)";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Sumbong sent! Keep safe.'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>