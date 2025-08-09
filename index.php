<?php

require_once 'Mobile_Detect.php';

$pageTitle = "Soulmate Synastry Report | Written in the Stars";
$metaDescription = "Discover the truth behind your cosmic connection. Personalized soulmate reports crafted with astrology, poetry, and precision.";
$currentPage = 'home';
include 'header.php';
include 'db.php';

//-----------puplular articles------

$popularContent = '';
$popular = $conn->query("
  SELECT p.title, p.slug, COUNT(v.id) as views
  FROM pages p
  JOIN page_views v ON v.page_id = p.id
  WHERE v.viewed_at > NOW() - INTERVAL 30 DAY
and p.display = 1 
  GROUP BY p.id
  ORDER BY views DESC
  LIMIT 10
");

if ($popular->num_rows > 0) {
    $popularContent .= '<section class="popular-articles">';
    $popularContent .= '<h2>🌟 Popular Articles</h2>';
    $popularContent .= '<ul class="popular-list">';
    while ($row = $popular->fetch_assoc()) {
        $popularContent .= '<li><a href="/article/' . htmlspecialchars($row['slug']) . '">' . htmlspecialchars($row['title']) . '</a></li>';
    }
    $popularContent .= '</ul>';
    $popularContent .= '</section>';
}

?>

<script>
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
</script>

<?php if ($mobile=="yes") { ?>

<style>
  html {
    scroll-behavior: smooth;
  }

  .btn-floating {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #f472b6;
    color: white;
    padding: 14px 24px;
    border-radius: 50px;
    font-size: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    z-index: 1000;
    text-decoration: none;
  }

  .section {
    padding: 10px 20px;
    font-family: 'Georgia', serif;
  }

  .section h2 {
    font-size: 26px;
    color: #cc0077;
    margin-bottom: 15px;
  }

  .section p {
    font-size: 17px;
    color: #444;
    line-height: 1.7;
  }

  .highlight {
    background: #fff0f6;
    padding: 20px;
    border-radius: 10px;
    margin-top: 20px;
  }

  .testimonial {
    background-color: #ffffff;
    border-left: 4px solid #cc0077;
    padding: 15px 20px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }

  .testimonial p {
    font-size: 16px;
    font-style: italic;
    margin-bottom: 10px;
  }

  .testimonial .author {
    font-weight: bold;
    color: #7a1c4f;
  }
</style>

<!-- HERO -->
<section class="section" style="text-align: center; background-color: #fffafc;background-image: url('images/background.jpg'); background-size: cover; background-position: center;">
  <h1 style="font-size: 28px;color: #fff;">Is This Love Cosmic?</h1>
  <p style="font-size: 18px; font-style: italic;color: #fff;">Some connections don’t start. They remember.<br>
  It wasn’t chance. It wasn’t timing. It was destiny whispering through your soul.<br><br>
        <a href="order.php" class="btn-lg">Reveal My Connection</a><br>
✦ Soulmate Report — $<?php echo $price; ?> ✦<br>
⭐⭐⭐⭐⭐ “I cried reading mine. It explained everything I couldn't put into words.”<br>
— Jessica M.
</p>
</section>

<!-- WHAT YOU GET -->
<section class="section" style="background-color: #fef6fb;">
  <h2>What's Inside</h2>
  <p>This isn't just a reading. It's a soul decoding. A love letter from the cosmos, just for you.</p>
  <div class="highlight">
    <p><strong>✦ Soul Resonance:</strong> How aligned are your souls? Our 50+ point score reveals the frequency of your bond.</p>
    <p><strong>✦ Karmic Ties:</strong> Explore past life contracts and why this person won’t leave your heart.</p>
    <p><strong>✦ Emotional Chemistry:</strong> The magnetic, sacred, or obsessive energy between you two.</p>
  </div>
</section>

<!-- PERSONAL STORY -->
<section class="section" style="background-image: url('images/back.jpg');
  background-size: cover; background-position: center; color: white; text-align: center;">
  <h2 style="color: white;">This Was Born From My Story</h2>
  <p style="color: white;">I met someone who silenced time. My heart didn’t understand it, but the stars did.<br>
  I searched for meaning, and what I found became this report. For those who feel the ache of a connection they can't explain.
<br><br><a href="order.php" class="btn-lg">Get My Soulmate Reading</a><br>
✦ Soulmate Report — $<?php echo $price; ?> ✦
</p>
</section>

<!-- WHY THIS IS DIFFERENT -->
<section class="section" style="background-color: #f9ecf3;">
  <h2>Why This Isn’t Just Astrology</h2>
  <p>This is your emotional map. Your karmic mirror. Written with soul, precision, and poetry.</p>
  <div class="highlight">
    <p>Delivered in 24 hours • PDF Format • <strong>$<?php echo $price; ?></strong></p>
    <p style="font-style: italic;">Like a cosmic love letter from your higher self.</p>
<a href="order.php" class="btn-lg">Order Report</a>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section" style="background-color: #fffafc;">
  <h2>What Others Felt</h2>

  <div class="testimonial">
    <p>"I don’t usually believe in astrology reports, but this one felt like it was written <em>for my soul</em>. It made me cry."
    </p>
    <p class="author">— Maya R. (USA)</p>
  </div>

  <div class="testimonial">
    <p>"Helped me understand why I couldn’t let go of someone I barely knew. I found peace I didn’t expect."</p>
    <p class="author">— Anaïs D. (France)</p>
  </div>

  <div class="testimonial">
    <p>"I read it at midnight and felt like my soul was speaking back to me. It's not a report. It's a remembrance."
    </p>
    <p class="author">— Tejas M. (India)</p>
  </div>
<p style="text-align:center;"><a href="order.php" class="btn-lg">Get My Soulmate Reading</a><br>
✦ Soulmate Report — $<?php echo $price; ?> ✦

</section>

<?php } else { ?>


<!-- SECTION 1: HERO -->

<section id="hero" style="background-image: url('images/background.jpg'); background-size: cover; background-position: center; color: white; padding: 0px 0px 0px 0px;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-left">
        <h1 style="font-size: 60px;padding-top:0px;margin-top:0px;">Is Your Love Written in the Stars?</h1>
        
<section style="color: #fff; padding: 0px 2px; font-family: 'Georgia', serif;margin-top:0px;">
  <div style="max-width: 700px; margin: 0 auto; line-height: 1.0; font-size: 1.4rem;">
    <p>You didn’t just meet them.</p>
   
        <p>Your soul whispered, “It’s you.”</p>
    <p>
      But what is this connection — fate, karma, or divine timing?
    </p>
    <p><strong>Let the stars speak.</strong></p>
  </div>
</section>


        <a href="order.php" class="btn-lg">Reveal My Connection</a>✦Hand Crafted Soulmate Report — $<?php echo $price; ?>✦<br><br>
⭐⭐⭐⭐⭐ “I cried reading mine. It was like someone saw into my soul.”<br>
— Jessica M.
      </div>
      <div class="col-md-6 text-center">
        <img src="images/19901886.png"
             alt="Celestial couple" style="max-width: 100%;">
      </div>
    </div>
  </div>
</section>


<!-- SECTION 2: WHAT YOU'LL RECEIVE (VERBOSE VERSION) -->
<section id="features" style="background-color: #fff4f9; padding: 10px 0;">
  <div class="container text-center">
    <h2 style="font-size: 36px;">What You'll Receive</h2>
    <p style="max-width: 800px; margin: 0 auto 40px auto; font-size: 18px;">
      Each Soulmate Report is crafted like a sacred letter from the cosmos — a blend of heartfelt narrative, precise astrology, and intuitive interpretation. Here's everything that's included in your personalized journey:
    </p>
    <div class="row">
      <div class="col-md-4">
        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140047.png" alt="Soul Sync" style="height: 60px; margin-bottom: 20px;">
        <h4>Soul Resonance Score</h4>
        <p>We calculate a powerful compatibility score based on over 50 synastry markers including conjunctions, oppositions, trines, squares, and house overlays. It’s not about perfection — it’s about presence. How deeply are your souls tuned to each other? This score helps you understand the energetic rhythm of your bond.</p>
      </div>
      <div class="col-md-4">
        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140045.png" alt="Karmic Contracts" style="height: 60px; margin-bottom: 20px;">
        <h4>Karmic Contracts & Past Life Ties</h4>
        <p>Through detailed analysis of Saturn, South Node (Ketu), Pluto, and the 12th house overlays, we explore the unresolved karma between you. Who owes what to whom? Why are you drawn to this person even when it’s painful? These threads often reveal sacred agreements made long before this lifetime began.</p>
      </div>
      <div class="col-md-4">
        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140037.png" alt="Emotional Chemistry" style="height: 60px; margin-bottom: 20px;">
        <h4>Magnetic Chemistry & Sexual Energy</h4>
        <p>We look at Mars-Venus alignments, Moon-Pluto fusions, 8th house overlays and more to unpack the sensual, emotional, and spiritual layers of attraction. Is your desire sacred, obsessive, or healing? You’ll know where the fire lives and how to hold it wisely.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140028.png" alt="Emotional Triggers" style="height: 60px; margin-bottom: 20px;">
        <h4>What You Trigger in Each Other</h4>
        <p>Sometimes we meet people who awaken everything we've buried. Your charts together may reveal emotional pressure points: abandonment fears, unspoken desires, mirrored wounds. But what’s triggered can also be what’s transformed.</p>
      </div>
      <div class="col-md-4">
        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140027.png" alt="House Overlays" style="height: 60px; margin-bottom: 20px;">
        <h4>House Overlays & Archetypal Zones</h4>
        <p>Where do they fall in your chart? In your 5th house of romance? In your 12th house of illusions? We explore what psychological and spiritual territories they activate — including 1st, 7th, and 8th house overlays that define soulmate intensity.</p>
      </div>
      <div class="col-md-4">
        <img src="https://cdn-icons-png.flaticon.com/512/4140/4140030.png" alt="Twin Flame Potential" style="height: 60px; margin-bottom: 20px;">
        <h4>Twin Flame Indicators</h4>
        <p>Is this person your mirror? Twin flame connections often come with 12th house mysteries, Neptune fog, runner-chaser dynamics, and eerie dream synchronicities. This section explores signs of eternal soul partnerships vs karmic entanglements.</p>
      </div>
    </div>
  </div>
<p style="text-align:center;"><a href="order.php" class="btn-lg">Get My Soulmate Reading</a></p>
</section>

<section style="background-color: #5C6161; padding: 40px 20px;text-align:center;color:#fff;">
  <div style="max-width: 880px; margin: 0 auto; font-family: 'Inter', sans-serif;">
    
<h2 style="font-family: 'Playfair Display', serif; font-style: italic;color:#EFA3C8;">
This Began With My Own Soul Story
</h2>
<p style="font-size: 18px; line-height: 1.6; text-align: center;">
      Some stories don’t begin with words — they begin with a pause in time.<br><br>
      I met someone… and the world slowed down. My body stilled. My soul remembered.<br><br>
      There was no name for what I felt. Only a knowing. Only silence… and the ache that followed.<br>
      I searched for meaning — not in logic, but in the stars. And what I found became this offering.
    </p>
    
  </div>
</section>


<!-- SECTION 4: QUOTE BANNER -->
<section style="background-image: url('images/background1.jpg');
  background-size: cover; background-position: center; color: white; text-align: center;max-height:100px;">
  <h2 style="font-style: italic;">“Some stories begin before this lifetime. Some people are written into your stars.”</h2>
<br><br><p style="text-align:center;"><a href="order.php" class="btn-lg">Begin Your Soulmate Report</a></p>
</section>



<!-- SECTION: DEEP EMOTIONAL EXPLORATION -->
<section id="emotional" style="background-color: #fef6fb; padding: 10px 0;">
  <div class="container">
    <h2 style="font-family: 'Playfair Display', serif; font-size: 36px; text-align: center;">This Isn’t a Generic Love Reading</h2>
    <p style="font-size: 18px; max-width: 800px; margin: 20px auto; text-align: center;">
      It’s a mirror to your soul contract — a sacred decoding of the energies, patterns, and karmic dynamics between you and someone you cannot forget.
    </p>
    <div class="row" style="margin-top: 60px;">
      <div class="col-md-6">
        <h3>Soul Resonance Score</h3>
        <p>We analyze over 50 aspects — planetary, house overlays, and karmic links — to deliver a resonance score. This number isn’t about perfection, but purpose. A map of your energetic frequency with them.</p>

        <h3>Karmic Imprints & Past Life Echoes</h3>
        <p>Saturn. The Nodes. 12th house entanglements. When these activate, you aren’t meeting someone new — you’re continuing a sacred contract. We decode what is yours to complete.</p>

        <h3>Emotional Chemistry</h3>
        <p>Venus-Mars. Moon-Pluto. Sun-Chiron. Each aspect reveals not just attraction, but soul alchemy. Why are you drawn to someone even when it hurts? Why can’t you forget them?</p>
      </div>
      <div class="col-md-6">
        <h3>Triggers & Awakening</h3>
        <p>Your charts show the friction that initiates change. From abandonment wounds to passion surges, we explore what you trigger in each other — and how it can heal you both.</p>

        <h3>House Overlays & Soul Zones</h3>
        <p>Do they fall into your 7th house of partnership, or your 12th house of dreams and illusions? Each placement reveals a sacred zone they occupy in your psyche.</p>

        <h3>Are They Your Twin Flame?</h3>
        <p>This section combines obsession indicators, Neptune overlays, mirrored lunar cycles, and synastry with spiritual overlays to explore the truth of twin flame energy between you.</p>

     </div>
    </div>
  </div>
<p style="text-align:center;"><a href="order.php" class="btn-lg">Reveal Your Soul Contract Now</a></p>
</section>

<!-- SECTION: QUOTE CAROUSEL -->
<section style="background: #1e1e2f; color: #f5a3c7; text-align: center; padding: 60px 0;">
  <h2 style="font-family: 'Playfair Display', serif; font-style: italic;">“Some love doesn’t start. It remembers.”</h2>
  <p style="margin-top: 20px; font-size: 18px; color: #fff;">“You didn’t fall. You returned.”</p>
  <p style="font-size: 18px; color: #fff;">“I swear I knew their eyes before I knew their name.”</p>
</section>

<!-- SECTION: TESTIMONIALS -->
<section id="testimonials" style="background: linear-gradient(to bottom, #f5f3ff, #ffffff); padding: 20px 0;">


  <div class="container text-center">
    <h2 style="font-family: 'Playfair Display', serif; font-size: 36px; margin-bottom: 50px;">
      What Others Are Saying
    </h2>

    <div class="row" style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
      
      <div class="col-md-4" style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 0 20px rgba(0,0,0,0.05); max-width: 350px;">
        <p style="font-size: 16px; font-style: italic;">"I don’t usually believe in astrology reports, but this one felt like it was written *for my soul.* The Venus-Moon section made me cry. It explained things between me and Elijah that I never had words for."</p>
        <p style="font-weight: bold; margin-top: 20px;">— Maya R. (USA)</p>
      </div>

      <div class="col-md-4" style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 0 20px rgba(0,0,0,0.05); max-width: 350px;">
        <p style="font-size: 16px; font-style: italic;">"The report helped me understand why I couldn’t let go of someone I barely knew. Turns out we had Mars conjunct South Node and Saturn in the 7th. It gave me peace — and clarity I didn’t expect."</p>
        <p style="font-weight: bold; margin-top: 20px;">— Anaïs D. (France)</p>
      </div>

      <div class="col-md-4" style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 0 20px rgba(0,0,0,0.05); max-width: 350px;">
        <p style="font-size: 16px; font-style: italic;">"I ordered this out of curiosity and ended up journaling for hours afterward. The section on karmic contracts hit me the hardest. It helped me break a soul loop I was stuck in for years."</p>
        <p style="font-weight: bold; margin-top: 20px;">— Tejas M. (India)</p>

     </div>
    </div>
  </div>
<p style="text-align:center;"><a href="order.php" class="btn-lg">I Want My Personalized Report</a></p>
</section>


<!-- SECTION: WHY THIS ISN'T JUST ANOTHER READING -->
<section id="why-us" style="background-color: #fff0f6; padding: 10px 0;">
  <div class="container text-center" style="max-width: 900px;">
    <h2 style="font-family: 'Playfair Display', serif; font-size: 36px; margin-bottom: 30px;">
      Why This Isn’t Just Another Reading
    </h2>

    <p style="font-size: 18px; margin-bottom: 30px;">
      In a world overflowing with auto-generated readings and recycled words, we offer something radically different:
    </p>

    <p style="font-size: 18px; line-height: 1.8; font-style: italic;">
      A report that feels like a letter from your higher self.  
      A story that reads like you’ve heard it before — because you’ve lived it before.  
      A reflection so personal, it brings tears to your eyes and chills to your spine.
    </p>

    <p style="font-size: 18px; margin-top: 40px;">
      We don’t believe love is an algorithm. We believe love is sacred.  
      Each report is crafted using real synastry — comparing over 50 points, including house rulers, karmic indicators, soul contracts, and emotional blueprints.
    </p>

    <p style="font-size: 18px; margin-top: 20px;">
      It’s not a generic horoscope. It’s not a copy-paste PDF.  
      It’s your story, your connection, your energy — interpreted with soul, poetry, and precision.
    </p>

    <p style="font-size: 18px; margin-top: 40px; font-weight: 600;">
      We don’t just tell you who they are.  
      We tell you why they were sent. What they awaken.  
      What the Universe is trying to teach you — through them.
    </p>

   <div style="text-align: center; background: linear-gradient(to right, #2c003e, #0c0032); color: #fff; padding: 15px 25px; border-radius: 12px; font-size: 18px; font-weight: 500; margin-bottom: 30px;">
  ✦ Delivered in 24 Hours · PDF Format · <span style="color:#ff9ff3; font-weight:bold;">$<?php echo $price; ?> Only</span> ✦<br>
  <span style="font-style: italic; color: #f3e5f5;">Deep, private, beautifully written — like a cosmic love letter</span>
</div>

    <a href="order.php" class="btn-lg" style="margin-top: 30px; background-color: #f472b6; color: white; border-radius: 30px; padding: 15px 30px; font-size: 18px;">
      Order My Soulmate Report
    </a>
  </div>

</section>

<?php echo $popularContent; ?>

<?php }
include 'footer.php'; ?>


