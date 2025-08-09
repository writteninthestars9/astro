<?php


  $to = $row['email'];
  $subject = "Your Soulmate Report Order (Order ID: $order_id)";

$to="sumeetxxx@gmail.com";
$row['full_name']="ffff ddd";
  
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

      <p class="text-lg">Dear ' . htmlspecialchars($row['full_name']) . ',</p>

      <p class="text">
        Thank you for your order! We’ve received your payment of <strong>$19.95</strong> and your soulmate report is now being hand-crafted by our astrologers.
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


?>
xxxxxxxxxxxxx