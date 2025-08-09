<?php
include 'db.php'; 

// Generate a unique 14-digit numeric order ID
$order_id = mt_rand(10000000000000, 99999999999999);

// Collect and sanitize form input
$your_name         = $_POST['your_name'];
$your_gender       = $_POST['your_gender'];
$your_birth_day    = $_POST['your_birth_day'];
$your_birth_month  = $_POST['your_birth_month'];
$your_birth_year   = $_POST['your_birth_year'];
$your_hour         = $_POST['your_hour'];
$your_minute       = $_POST['your_minute'];
$your_ampm         = $_POST['your_ampm'];
$your_birthplace   = $_POST['your_birthplace'];
$your_email        = $_POST['your_email'];
$price             = $_POST['price'];

$partner_name         = $_POST['partner_name'];
$partner_gender       = $_POST['partner_gender'];
$partner_birth_day    = $_POST['partner_birth_day'];
$partner_birth_month  = $_POST['partner_birth_month'];
$partner_birth_year   = $_POST['partner_birth_year'];
$partner_hour         = $_POST['partner_hour'];
$partner_minute       = $_POST['partner_minute'];
$partner_ampm         = $_POST['partner_ampm'];
$partner_birthplace   = $_POST['partner_birthplace'];

// Insert into database
$stmt = $conn->prepare("
  INSERT INTO orders (
    order_id,
    your_name, your_gender, your_birth_day, your_birth_month, your_birth_year,
    your_hour, your_minute, your_ampm, your_birthplace, your_email,
    partner_name, partner_gender, partner_birth_day, partner_birth_month,
    partner_birth_year, partner_hour, partner_minute, partner_ampm, partner_birthplace, price,
    payment_completed
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'no')
");

$stmt->bind_param(
  "ssssssssssssssssssssd",
  $order_id,
  $your_name, $your_gender, $your_birth_day, $your_birth_month, $your_birth_year,
  $your_hour, $your_minute, $your_ampm, $your_birthplace, $your_email,
  $partner_name, $partner_gender, $partner_birth_day, $partner_birth_month,
  $partner_birth_year, $partner_hour, $partner_minute, $partner_ampm, $partner_birthplace, $price
);

$stmt->execute();
$stmt->close();

// PayPal redirection
$paypal_url   = "https://www.paypal.com/cgi-bin/webscr";
$return_url   = "https://writteninthestars.site/thankyou.php";
$cancel_url   = "https://writteninthestars.site/order.php";
$notify_url   = "https://writteninthestars.site/ipn.php";
$paypal_email = "sumeetxxx@gmail.com"; // change this

$paypal="
<form id=\"paypalForm\" action=\"$paypal_url\" method=\"post\">
  <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
  <input type=\"hidden\" name=\"upload\" value=\"1\">
  <input type=\"hidden\" name=\"business\" value=\"$paypal_email\">
  <input type=\"hidden\" name=\"item_name\" value=\"Soulmate Synastry Report\">
  <input type=\"hidden\" name=\"amount\" value=\"$price\">
  <input type=\"hidden\" name=\"currency_code\" value=\"USD\">
  <input type=\"hidden\" name=\"custom\" value=\"$order_id\">
  <input type=\"hidden\" name=\"notify_url\" value=\"$notify_url\">
  <input type=\"hidden\" name=\"return\" value=\"$return_url\">
  <input type=\"hidden\" name=\"cancel_return\" value=\"$cancel_url\">
</form>
";
?>

<!DOCTYPE html>
    <html>
    <head>
        <title>Redirecting to PayPal...</title>
    </head>
    <body>
        <p style="font-family: Georgia, serif; font-size: 20px; color: #6c1c4e;">Redirecting you to PayPal to complete your order...</p>

        <?php echo $paypal; ?>

        <script>
document.getElementById('paypalForm').submit();
        </script>
    </body>
    </html>
