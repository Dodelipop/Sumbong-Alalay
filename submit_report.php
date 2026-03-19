<?php
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

    $sql = "INSERT INTO reports (reporter_name, age, location, concern_type, status) 
            VALUES ('$name', $age, '$location', '$concern_text', 'Pending')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Sumbong sent! Keep safe.'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>