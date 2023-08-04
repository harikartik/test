<?php
// Replace with your actual MySQL database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exp1";

// Establish MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate reCAPTCHA response
$recaptcha_secret = "6LfUi2wnAAAAAOgnD-njfjbYYleLEpXOlWleat2j";
$recaptcha_response = $_POST['g-recaptcha-response'];

$verify_url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response
);

$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);

$context = stream_context_create($options);
$result = file_get_contents($verify_url, false, $context);
$response_data = json_decode($result, true);

if (!$response_data['success']) {
    die("reCAPTCHA verification failed.");
}

// Sanitize user inputs to prevent SQL injection
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Insert user data into the database
$sql = "INSERT INTO login (username, password) VALUES ('$username', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

