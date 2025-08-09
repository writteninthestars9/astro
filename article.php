<?php
require_once 'db.php';

$selectorType = $_GET['selectorType'] ?? null;
$planet = $_GET['planet'] ?? null;
$planet1 = $_GET['planet1'] ?? null;
$planet2 = $_GET['planet2'] ?? null;
$aspect = $_GET['aspect'] ?? null;
$house = $_GET['house'] ?? null;
$node = $_GET['node'] ?? null;
$transitPlanet = $_GET['transitPlanet'] ?? null;

// ✅ Determine if this is a fresh page or one that needs redirect
$urlPath = $_SERVER['REQUEST_URI'];
$currentSlug = basename(parse_url($urlPath, PHP_URL_PATH));

// Strip ".php" if present (depends on how slugs are formed)
$currentSlug = str_replace('.php', '', $currentSlug);

// Only attempt redirect if selectorType is set and we're not on the correct slug
if ($selectorType && !headers_sent()) {
    $sql = '';
    $params = [];
    $category_id = (int)$selectorType;
    $houseNum = preg_replace('/[^0-9]/', '', $house);
    $houseOrdinal = $houseNum ? ordinal((int)$houseNum) : '';

    switch ($category_id) {
        case 2:
            if ($planet && $houseOrdinal) {
                $sql = "SELECT slug FROM pages WHERE category_id = 2 AND title LIKE ?";
                $params[] = "%$planet in partner's $houseOrdinal%";
            }
            break;

        case 3:
            if ($planet && $houseOrdinal) {
                $sql = "SELECT slug FROM pages WHERE category_id = 3 AND title LIKE ?";
                $params[] = "%$planet in $houseOrdinal House of composite chart%";
            }
            break;

        case 4:
            if ($planet1 && $aspect && $planet2) {
                $sql = "SELECT slug FROM pages WHERE category_id = 4 AND title LIKE ?";
                $params[] = "%$planet1 $aspect% $planet2%";
            }
            break;

        case 5:
            if ($planet && $houseOrdinal) {
                $sql = "SELECT slug FROM pages WHERE category_id = 5 AND title LIKE ?";
                $params[] = "$planet transit% $houseOrdinal";
            }
            break;

        case 6:
            if ($node && $planet) {
                $sql = "SELECT slug FROM pages WHERE category_id = 6 AND title LIKE ?";
                $params[] = "%$node% conjunct $planet%";
            }
            break;

        case 7:
            if ($transitPlanet && $aspect && $planet) {
                $sql = "SELECT slug FROM pages WHERE category_id = 7 AND title LIKE ?";
                $params[] = "%Transit $transitPlanet $aspect Natal $planet%";
            }
            break;
    }

    if ($sql) {
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $targetSlug = $row['slug'];

                // ✅ Only redirect if currentSlug ≠ targetSlug
                if ($targetSlug && $currentSlug !== $targetSlug) {
                    $queryParams = $_GET;
                    unset($queryParams['slug']); // ensure old slug doesn't persist
                    $queryString = http_build_query($queryParams);
                    $redirectUrl = "/article/" . $targetSlug . ($queryString ? "?$queryString" : "");
                    header("Location: $redirectUrl", true, 301);
                    exit;
                }
            } else {
                echo "<div style='padding:20px; color:#b30000; background:#ffe6e6; font-family: Georgia, serif;'>
                    <strong>We couldn’t find a match</strong> — please check your selection or try again later.
                </div>";
                exit;
            }
        }
    }
}

//-------------------

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (!$slug) {
    echo "<h2>Article not found.</h2>";
    exit;
}

// Fetch article by slug
$stmt = $conn->prepare("SELECT * FROM pages WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();

if (!$article) {
    echo "<h2>Article not found.</h2>";
    exit;
}

// Extract <h1> from content if present and not empty
$matches = [];
if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $article['content'], $matches) && trim(strip_tags($matches[1])) !== '') {
    $article['title'] = trim($matches[1]); // Use extracted title
    $article['content'] = preg_replace('/<h1[^>]*>.*?<\/h1>/is', '', $article['content'], 1); // Remove it from content
}

// --- Fetch subsub, subcat, category, related articles, similar articles, categories ---

// Fetch subsubcategory
$subsub = null;
if ($article['subsubcategory_id'] != 0) {
    $stmt = $conn->prepare("SELECT * FROM subsubcategories WHERE id = ?");
    $stmt->bind_param("i", $article['subsubcategory_id']);
    $stmt->execute();
    $subsub = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Fetch subcategory
$subcat_id = $subsub ? $subsub['subcategory_id'] : $article['subcategory_id'];
$stmt = $conn->prepare("SELECT * FROM subcategories WHERE id = ?");
$stmt->bind_param("i", $subcat_id);
$stmt->execute();
$sub = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch category
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $sub['category_id']);
$stmt->execute();
$cat = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Related articles
$relatedArticles = [];
$stmt = $conn->prepare("SELECT p.* FROM related_pages r JOIN pages p ON p.id = r.related_page_id WHERE p.display = 1 AND r.page_id = ?");
$stmt->bind_param("i", $article['id']);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $relatedArticles[] = $row;
$stmt->close();

// Similar articles
$similarArticles = [];
$stmt = $conn->prepare("SELECT p.* FROM similar_pages sp JOIN pages p ON p.id = sp.similar_page_id WHERE p.display = 1 AND sp.page_id = ?");
$stmt->bind_param("i", $article['id']);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $similarArticles[] = $row;
$stmt->close();

// More categories to explore
$moreCategories = [];
$stmt = $conn->prepare("SELECT s.* FROM related_categories rc JOIN subcategories s ON s.id = rc.subcategory_id WHERE rc.page_id = ?");
$stmt->bind_param("i", $article['id']);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) $moreCategories[] = $row;
$stmt->close();

// Count total insights
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM page_insights WHERE page_id = ?");
$stmt->bind_param("i", $article['id']);
$stmt->execute();
$countResult = $stmt->get_result();
$countRow = $countResult->fetch_assoc();
$totalInsights = (int)$countRow['total'];
$stmt->close();

$insight = '';
if ($totalInsights > 0) {
    // Stagger updates per article using article ID
    $daysSinceEpoch = floor((strtotime(date('Y-m-d')) - strtotime('2024-01-01')) / (60 * 60 * 24));
    $offset = ($daysSinceEpoch + $article['id']) % ($totalInsights * 10);  // rotate every 10 days per insight
    $currentInsightIndex = floor($offset / 10) % $totalInsights;

    $stmt = $conn->prepare("
        SELECT insight
        FROM page_insights
        WHERE page_id = ?
        ORDER BY id ASC
        LIMIT 1 OFFSET ?
    ");
    $stmt->bind_param("ii", $article['id'], $currentInsightIndex);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $insight = $row['insight'];
    }
    $stmt->close();
}

// CTA
$cta = '';
$stmt = $conn->prepare("SELECT cta FROM page_ctas WHERE page_id = ?");
$stmt->bind_param("i", $article['id']);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) $cta = $row['cta'];
$stmt->close();

//-------------update views-------------
function isBot($ua) {
    $bots = ['bot', 'crawl', 'spider', 'slurp', 'bingpreview', 'mediapartners-google'];
    $ua = strtolower($ua);
    foreach ($bots as $bot) {
        if (strpos($ua, $bot) !== false) return true;
    }
    return false;
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

if (!isBot($userAgent) && !empty($ip)) {
    $stmt = $conn->prepare("SELECT 1 FROM page_views WHERE page_id = ? AND ip_address = ? AND viewed_at > NOW() - INTERVAL 1 DAY");
    $stmt->bind_param("is", $article['id'], $ip);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO page_views (page_id, ip_address, user_agent) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $article['id'], $ip, $userAgent);
        $stmt->execute();
    } else {
        $stmt->close();
    }
}

//----------------cleanup--------------------
$lastCleanup = @file_get_contents('last_cleanup.txt');
if (!$lastCleanup || strtotime($lastCleanup) < strtotime('-1 day')) {
    $conn->query("DELETE FROM page_views WHERE viewed_at < NOW() - INTERVAL 30 DAY");
    file_put_contents('last_cleanup.txt', date('Y-m-d H:i:s'));
}


//-------------------------------------------
$pageTitle = $article['title'];
$metaDescription = $article['title'];
$currentPage = 'articles';
include 'header.php';
?>

<section class="privacy-section" style="background-color: #fefafc; color: #2c2c2c; padding: 10px 20px; font-family: 'Georgia', serif;">
  <div class="privacy-container" style="max-width: 90%; margin: 0 auto; background: #ffffff; padding: 10px 40px; border-radius: 20px; box-shadow: 0 0 30px rgba(0,0,0,0.05);">

    <div class="breadcrumb" data-aos="fade-in">
      <a href="/">Home</a> →
      <a href="/articles"><?= htmlspecialchars($cat['name']) ?></a> →
      <a href="/category/<?= htmlspecialchars($sub['slug']) ?>"><?= htmlspecialchars($sub['subcategory']) ?></a>
      <?php if ($subsub): ?> →
        <a href="/list/<?= htmlspecialchars($subsub['slug']) ?>"><?= htmlspecialchars($subsub['subsubcategory']) ?></a>
      <?php endif; ?>
    </div>

    <h1 class="article-title" data-aos="fade-up"><?= htmlspecialchars($article['title']) ?></h1>


    <?php if (!empty($insight)): ?>
      <div class="insight-box" style="background-image: url('/images/<?= $cat['id'] ?>.jpg');" data-aos="fade-up">
        <div class="insight-text"><div class="hero-box">“<?= htmlspecialchars($insight) ?>”</div></div>
      </div>
    <?php endif; ?>

    <div class="article-content" data-aos="fade-up">
      <?= $article['content']; ?>

      <?php if (!empty($cta)): ?>
        <div class="article-cta" data-aos="fade-up">
          <p class="cta-text"><?= htmlspecialchars($cta) ?></p>
          <a href="/order" class="cta-button">💫 Order Your Soulmate Report</a>
        </div>
      <?php endif; ?>

      <hr>
    </div>

    <div class="related-articles" style="margin-top: 20px; padding-top: 0px; border-top: 1px solid #eee;">
      <?php if (!empty($relatedArticles)): ?>
        <h2>✨ You May Also Be Drawn To...</h2>
        <ul>
          <?php foreach ($relatedArticles as $rel): ?>
            <li><a href="/article/<?= htmlspecialchars($rel['slug']) ?>"><?= htmlspecialchars($rel['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if (!empty($similarArticles)): ?>
        <h2>💫 Similar Themed Articles</h2>
        <ul>
          <?php foreach ($similarArticles as $sim): ?>
            <li><a href="/article/<?= htmlspecialchars($sim['slug']) ?>"><?= htmlspecialchars($sim['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if (!empty($moreCategories)): ?>
        <h2>🌙 More Categories to Explore</h2>
        <ul>
          <?php foreach ($moreCategories as $cat): ?>
            <li><a href="/category/<?= htmlspecialchars($cat['slug']) ?>"><?= htmlspecialchars($cat['subcategory']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

  </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>

<?php include 'footer.php'; ?>
