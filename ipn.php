<?php
include 'db.php'; // database connection

// Read POST from PayPal
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode('=', $keyval);
  if (count($keyval) == 2)
    $myPost[$keyval[0]] = urldecode($keyval[1]);
}

// Validate IPN
$req = 'cmd=_notify-validate';
foreach ($myPost as $key => $value) {
  $value = urlencode($value);
  $req .= "&$key=$value";
}

// Post back to PayPal for verification
$paypal_url = "https://ipnpb.paypal.com/cgi-bin/webscr"; // Use live URL in production
$ch = curl_init($paypal_url);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
$res = curl_exec($ch);
curl_close($ch);

if (strcmp($res, "VERIFIED") == 0) {
  $order_id = $_POST['custom'];

  // Update payment status and price in database
$stmt = $conn->prepare("UPDATE orders SET payment_completed = 'yes' WHERE order_id = ?");
$stmt->bind_param("s", $order_id);
$stmt->execute();
$stmt->close();

  // Fetch order data
  $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
  $stmt->bind_param("s", $order_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stmt->close();

  $price = $row['price'];

  // ---------------------
  // ADMIN EMAIL
  // ---------------------
  $to_admin = "sumeetxxx@gmail.com";
  $subject_admin = "New Paid Soulmate Order (Order ID: $order_id)";
  $message_admin = "Order ID: $order_id\n\n";
  foreach ($row as $key => $value) {
    $message_admin .= ucfirst(str_replace("_", " ", $key)) . ": $value\n";
  }
  mail($to_admin, $subject_admin, $message_admin, "From: no-reply@writteninthestars.site");

  // ---------------------
  // USER THANK YOU EMAIL
  // ---------------------
  $to = $row['your_email'];
  $subject = "Your Soulmate Report Order (Order ID: $order_id)";
  
$message_user = '
<html>
<head>
  <meta charset="UTF-8">
  <title>Your Soulmate Report</title>
  <style>
    body {
      font-family: Georgia, serif;
      background-color: #f2f6ff;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 640px;
      margin: 40px auto;
      border: 1px solid #1d3a7c;
      border-radius: 16px;
      background-color: #eaf4ff;
      padding: 20px;
    }

    .header-title {
      font-size: 32px;
      color: white;
      margin: 0;
      font-weight: normal;
      letter-spacing: 1px;
    }

    .content-box {
      background-color: #ffeaf3;
      padding: 30px;
    }

    .text-lg {
      font-size: 18px;
      color: #333;
      margin-top: 0;
    }

    .text {
      font-size: 16px;
      line-height: 1.6;
      color: #444;
      margin: 12px 0;
    }

    @media only screen and (max-width: 600px) {
      .container {
        width: 90% !important;
        padding: 10px !important;
      }

      .header-title {
        font-size: 10px !important;
      }

      .text-lg {
        font-size: 9px !important;
      }

      .text {
        font-size: 10px !important;
        line-height: 1.5 !important;
      }
    }
  </style>
</head>
<body>

  <!-- Outer Container -->
  <div class="container">

    <!-- Header -->
    <div style="background-color: #000; height: 120px; text-align: center;">
      <table role="presentation" width="100%" height="120" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" valign="middle">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;">
              <tr>
                <td style="padding-right: 12px;">
                  <img src="https://writteninthestars.site/images/logo.png" alt="Logo" style="height: 80px;">
                </td>
                <td>
                  <h1 class="header-title">Written In The Stars</h1>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>

    <!-- Content Box -->
    <div class="content-box">

      <p class="text-lg">Dear ' . htmlspecialchars($row['your_name']) . ',</p>

      <p class="text">
        Thank you for your order! We’ve received your payment of <strong>$'.$price.'</strong> and your soulmate report is now being hand-crafted by our astrologers.
      </p>

      <p class="text">
        Your report will be delivered to this email within <strong>24 hours</strong>.
      </p>

      <p class="text">
        If you have any questions or wish to share additional insights, feel free to reply to this email.
      </p>

      <p class="text" style="margin-bottom: 0;">
        With love,<br>
        The <em>Written in the Stars</em> Team ✦
      </p>

    </div>
  </div>

</body>
</html>';

$headers = "From: Written In The Stars <support@writteninthestars.site>\r\n";
$headers .= "Reply-To: support@writteninthestars.site\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

mail($to, $subject, $message_user, $headers);

}
?>
