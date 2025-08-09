<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Construct the email
    $to = "sumeetxxx@gmail.com";
    $email_subject = "Contact Form: " . $subject;
    $email_body = "You have received a new message from your website contact form.\n\n".
                  "Name: $name\n".
                  "Email: $email\n\n".
                  "Message:\n$message\n";

    $headers = "From: no-reply@writteninthestars.com\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    mail($to, $email_subject, $email_body, $headers);

    // Redirect to prevent form resubmission
    header("Location: contact.php?sent=1");
    exit;
}

$pageTitle = "Contact Us | Written in the Stars";
$metaDescription = "We'd love to hear from you. Reach out for questions, support, or soulful synchronicities.";
$currentPage = 'contact';
include 'header.php';
?>

<section class="contact-section" style="background-color: #fefafc; color: #2c2c2c; padding: 10px 20px; font-family: 'Georgia', serif;">
  <div class="contact-container" style="background: #ffffff; padding: 10px 40px; border-radius: 20px; max-width: 850px; margin: 0 auto; box-shadow: 0 0 30px rgba(0,0,0,0.05);">

    <h1 style="font-size: 2.6rem; color: #cc0077; margin-bottom: 30px; text-align: center;">
      Reach Out to the Cosmos
    </h1>

    <?php if (isset($_GET['sent']) && $_GET['sent'] == '1'): ?>
      <p style="font-size: 1.2rem; color: #2c2c2c; text-align: center; margin-top: 50px;">
        🌟 Thank you for contacting us! We’ll be in touch soon — the stars have heard you. 🌌
        <br><br><br><br><br><br><br>
      </p>
    <?php else: ?>

      <p style="font-size: 1.1rem; margin-bottom: 30px; text-align: center;">
        Whether you have questions, feedback, or just want to say hello — we’re listening.  
        Every connection matters. Every message is sacred.
      </p>

      <form action="contact.php" method="post" style="margin-top: 40px;">
        <label for="name" style="display:block; margin-bottom: 10px; font-weight: bold;">Your Name</label>
        <input type="text" id="name" name="name" required style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; margin-bottom: 20px;">

        <label for="email" style="display:block; margin-bottom: 10px; font-weight: bold;">Your Email</label>
        <input type="email" id="email" name="email" required style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; margin-bottom: 20px;">

        <label for="subject" style="display:block; margin-bottom: 10px; font-weight: bold;">Subject</label>
        <input type="text" id="subject" name="subject" required style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; margin-bottom: 20px;">

        <label for="message" style="display:block; margin-bottom: 10px; font-weight: bold;">Your Message</label>
        <textarea id="message" name="message" rows="6" required style="width:100%; padding:12px; border-radius:8px; border:1px solid #ccc; margin-bottom: 30px;"></textarea>

        <button type="submit" class="btn-lg" style="background-color: #f472b6; border: none; cursor: pointer;">
          Send My Message
        </button>
      </form>

      <p style="margin-top: 40px; font-size: 1rem; color: #666; text-align: center;">
        We usually respond within 24 hours — sooner if Mercury isn’t retrograde 😉
      </p>

      <p style="font-size: 0.95rem; margin-top: 30px; color: #999; text-align: center;">
        Or email us directly at: <a href="mailto:support@writteninthestars.site" style="color: #cc0077;">support@writteninthestars.site</a>
      </p>

      <hr style="margin: 40px auto; width: 60%; border-top: 1px solid #eee;">

      <div style="font-size: 0.95rem; color: #666; text-align: center; margin-top: 20px;">
        <strong>Legal Entity:</strong> Sumeet Srivastava<br>
        <strong>Location:</strong> Bangalore, Karnataka, India<br>

      </div>

    <?php endif; ?>

  </div>
</section>

<?php include 'footer.php'; ?>
