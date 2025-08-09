<script>
function toggleDropdown() {
  const dropdown = document.querySelector('.dropdown');
  dropdown.classList.toggle('open');
}

// Toggle hamburger menu
document.getElementById('hamburger').addEventListener('click', function (e) {
  const navLinks = document.getElementById('navLinks');
  navLinks.classList.toggle('active');
  e.stopPropagation(); // Prevent closing immediately
});

// Close dropdown and menu when clicking outside
document.addEventListener('click', function (e) {
  const dropdown = document.querySelector('.dropdown');
  const toggleButton = document.querySelector('.dropdown-toggle');
  const navLinks = document.getElementById('navLinks');
  const hamburger = document.getElementById('hamburger');

  if (!dropdown.contains(e.target) && e.target !== toggleButton) {
    dropdown.classList.remove('open');
  }

  if (!navLinks.contains(e.target) && e.target !== hamburger) {
    navLinks.classList.remove('active');
  }
});
</script>





<footer class="site-footer">
  <style>
    @media (max-width: 768px) {
      .footer-links {
        flex-direction: column;
        align-items: center;
      }
      .footer-links a {
        margin: 6px 0;
      }
    }
  </style>

  <div class="footer-content" style="max-width: 900px; margin: auto; text-align: center;">

    <p class="footer-logo" style="font-size: 1.2rem; font-weight: bold; margin-bottom: 15px;">
      ✨ Written In The Stars
    </p>

    <div class="footer-links" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; font-size: 14px;">
      <a href="/">Home</a>
      <a href="/about">About Us</a>
      <a href="/contact">Contact</a>
      <a href="/privacy">Privacy Policy</a>
      <a href="/terms">Terms & Conditions</a>
      <a href="/refund">Refund Policy</a>
      <a href="/shipping">Shipping Policy</a>
    </div>

    <p class="footer-copy" style="margin-top: 20px; font-size: 13px; color: #777;">
      &copy; 2025 Written In The Stars. All rights reserved.
    </p>

  </div>
</footer>

</body>
</html>


