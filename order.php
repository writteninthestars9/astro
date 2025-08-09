<?php
$pageTitle = "Order Soulmate Report | Written in the Stars";
$metaDescription = "Begin your personalized soulmate astrology journey. Submit your birth details to receive a cosmic love letter from the stars.";
$currentPage = 'order';
include 'header.php';
?>

<section style="background-color: #fefafc; color: #2c2c2c; padding: 10px 15px; font-family: 'Georgia', serif;">
  <div style="background: #ffffff; padding: 10px 10px; border-radius: 20px; max-width: 800px; margin: 0 auto; box-shadow: 0 0 40px rgba(0,0,0,0.05);">
    <h1 style="font-size: 2.4rem; color: #cc0077; margin-bottom: 30px; text-align: center;">
      Order Your Soulmate Report
    </h1>

    <section style="background-color: #fff0f6; padding: 3px 3px; margin-bottom: 30px;">
      <div style="max-width: 800px; margin: 0 auto; font-family: 'Georgia', serif;">
        <p style="font-size: 18px; line-height: 1.6; font-style: italic; color: #8b1e5a; margin-bottom: 10px; text-align: center;">
          This report was born from my own journey — a soul-shaking connection that led me to astrology, dreams, and silence.
        </p>
        <p style="font-size: 18px; color: #6c1c4e; text-align: center; font-weight: bold; margin-top: -10px; margin-bottom: 30px;">
          ✦Soulmate Report - $<?php echo $price; ?>✦
        </p>
      </div>
    </section>

    <form action="process_order.php" method="POST">

      <h3 style="font-size: 1.3rem; color: #7e1455; margin-bottom: 20px;">Your Details</h3>

      <label for="your_name" class="form-label">Full Name *</label><br>
      <input type="text" name="your_name" id="your_name" required style="width: 80%; padding: 12px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 8px; background: #fffafc;"><br>

      <label for="your_gender" class="form-label">Gender *</label><br>
      <select name="your_gender" id="your_gender" required style="width: 30%; padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #ccc; background: #fffafc;">
        <option value="">Select</option>
        <option value="Female">Female</option>
        <option value="Male">Male</option>
      </select><br>

      <label class="form-label">Date of Birth *</label>
      <div style="display: flex; gap: 5px; margin-bottom: 20px;">
        <select name="your_birth_day" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="">Day</option>
          <?php for ($i = 1; $i <= 31; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
        <select name="your_birth_month" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="">Month</option>
          <?php
          $months = ["January", "February", "March", "April", "May", "June",
                     "July", "August", "September", "October", "November", "December"];
          foreach ($months as $index => $month) {
            echo "<option value='" . ($index + 1) . "'>$month</option>";
          }
          ?>
        </select>
        <select name="your_birth_year" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc; height: 42px;">
          <option value="">Year</option>
          <?php for ($i = 2025; $i >= 1920; $i--): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <label class="form-label">Time of Birth *</label>
      <div style="display: flex; gap: 5px; margin-bottom: 20px;">
        <select name="your_hour" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc; height: 42px;">
          <option value="">Hour</option>
          <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
        <select name="your_minute" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc; height: 42px;">
          <option value="">Minute</option>
          <?php for ($i = 0; $i < 60; $i++): ?>
            <option value="<?= sprintf('%02d', $i) ?>"><?= sprintf('%02d', $i) ?></option>
          <?php endfor; ?>
        </select>
        <select name="your_ampm" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc; height: 42px;">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>

      <label for="your_birthplace" class="form-label">Place of Birth *</label><br>
      <input type="text" name="your_birthplace" id="your_birthplace" required style="width: 80%; padding: 12px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 8px; background: #fffafc;"><br>

      <label for="your_email" class="form-label">Email Address *</label><br>
      <input type="email" name="your_email" id="your_email" required style="width: 80%; padding: 12px; margin-bottom: 30px; border: 1px solid #ccc; border-radius: 8px; background: #fffafc;">

      <!-- THEIR DETAILS -->
      <h3 style="font-size: 1.3rem; color: #7e1455; margin-bottom: 20px;">Partner Details</h3>

      <label for="partner_name" class="form-label">Full Name *</label><br>
      <input type="text" name="partner_name" id="partner_name" required style="width: 80%; padding: 12px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 8px; background: #fffafc;"><br>

      <label for="partner_gender" class="form-label">Gender *</label><br>
      <select name="partner_gender" id="partner_gender" required style="width: 30%; padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #ccc; background: #fffafc;">
        <option value="">Select</option>
        <option value="Female">Female</option>
        <option value="Male">Male</option>
      </select><br>

      <label class="form-label">Date of Birth *</label>
      <div style="display: flex; gap: 5px; margin-bottom: 20px;">
        <select name="partner_birth_day" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="">Day</option>
          <?php for ($i = 1; $i <= 31; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
        <select name="partner_birth_month" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="">Month</option>
          <?php foreach ($months as $index => $month) {
            echo "<option value='" . ($index + 1) . "'>$month</option>";
          } ?>
        </select>
        <select name="partner_birth_year" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="">Year</option>
          <?php for ($i = 2025; $i >= 1920; $i--): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <label class="form-label">Time of Birth *</label>
      <div style="display: flex; gap: 5px; margin-bottom: 20px;">
        <select name="partner_hour" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="">Hour</option>
          <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
        <select name="partner_minute" required style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="">Minute</option>
          <?php for ($i = 0; $i < 60; $i++): ?>
            <option value="<?= sprintf('%02d', $i) ?>"><?= sprintf('%02d', $i) ?></option>
          <?php endfor; ?>
        </select>
        <select name="partner_ampm" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
          <option value="AM">AM</option>
          <option value="PM">PM</option>
        </select>
      </div>

      <label for="partner_birthplace" class="form-label">Place of Birth *</label><br>
      <input type="text" name="partner_birthplace" id="partner_birthplace" required style="width: 80%; padding: 12px; margin-bottom: 30px; border: 1px solid #ccc; border-radius: 8px; background: #fffafc;">

      <p style="text-align: center; font-size: 16px; color: #6c1c4e; margin-top: 20px;">
        ✦ Your soulmate report will be delivered by email within 24 hours ✦<br>
        Please double-check your details for astrological accuracy.
      </p>

      <div style="text-align: center; margin-top: 30px;">
        <button type="submit" class="btn-lg" style="background-color: #f472b6; color: white; padding: 14px 36px; font-size: 18px; border-radius: 10px; border: none; cursor: pointer;">
          Order Now — $<?php echo $price; ?>
        </button>

<input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">

        <!-- PayPal branding -->
        <div style="margin-top: 15px;">
          <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="Pay with PayPal" style="max-width: 250px;">
        </div>
      </div>
    </form>
  </div>
</section>

<!-- Google Places Autocomplete -->
<script src="https://maps.googleapis.com/maps/api/js?key=xxx&libraries=places"></script>
<script>
  function initAutocomplete() {
    const options = { types: ['(cities)'] };
    new google.maps.places.Autocomplete(document.getElementById('your_birthplace'), options);
    new google.maps.places.Autocomplete(document.getElementById('partner_birthplace'), options);
  }
  google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>

<?php include 'footer.php'; ?>

