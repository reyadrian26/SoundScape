<?php
if (isset($_GET['id'])) {
    // Include necessary files or perform any required validations

    // Retrieve the music ID from the URL parameter
    $music_id = $_GET['id'];

    // Get the file path and title based on the music ID
    include 'db_connect.php'; // Include your database connection file
    $stmt = $conn->prepare("SELECT upath, title FROM uploads WHERE id = ?");
    $stmt->bind_param("i", $music_id);
    $stmt->execute();
    $stmt->bind_result($upath, $title);
    $stmt->fetch();
    $stmt->close();

    // Construct the file path
    $file_path = 'assets/uploads/' . $upath;

    // Check if the file exists
    if (file_exists($file_path)) {
        // Set appropriate headers for the file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $title . '.mp3"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        // Handle the case when the file doesn't exist
        echo 'File not found.';
    }
} else {
    // Handle the case when the music ID is not provided
    echo 'Invalid request.';
}
?>
