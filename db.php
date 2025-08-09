<?php
$servername = "localhost:3306";
$username   = "writteni_user";
$password   = "Slayer1212#";  
$database   = "writteni_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");
// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (!function_exists('ordinal')) {
    function ordinal($num) {
        if (!is_numeric($num)) return $num;
        $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
        if ((($num % 100) >= 11) && (($num % 100) <= 13))
            return $num . 'th';
        else
            return $num . $ends[$num % 10];
    }
}

?>
