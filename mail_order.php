<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);

  if (is_array($data)) {
    $body = "New Soulmate Report Order:\n\n";
    foreach ($data as $key => $value) {
      $body .= ucfirst(str_replace('_', ' ', $key)) . ": $value\n";
    }

    // Set a proper From header
    $headers = "From: no-reply@writteninthestars.site/\r\n";  // Use a real sender domain or email you control

    // Now send mail
    if (mail("sumeetxxx@gmail.com", "New Soulmate Report Order", $body, $headers)) {
      http_response_code(200);
    } else {
      http_response_code(500);
    }
  } else {
    http_response_code(400);
  }
} else {
  http_response_code(405);
}
?>
