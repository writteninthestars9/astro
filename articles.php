<?php
include 'db.php';

// Fetch all categories (except id = 1)
$categories = mysqli_query($conn, "SELECT * FROM categories WHERE id > 1 order by order_by");

$content = '';
$content .= '<div class="grid-wrapper"><div class="grid-container">';

while ($cat = mysqli_fetch_assoc($categories)) {
    $cat_id = $cat['id'];
    $cat_name = htmlspecialchars($cat['name']);
    $cat_slug = htmlspecialchars($cat['slug']);

    // Fetch subcategories with slugs
    $subcat_stmt = $conn->prepare("SELECT id, subcategory, slug FROM subcategories WHERE category_id = ?");
    $subcat_stmt->bind_param("i", $cat_id);
    $subcat_stmt->execute();
    $subcats = $subcat_stmt->get_result();

    $content .= '<div class="category-box">';
    $content .= '<img src="/images/' . $cat_id . 's.jpg" class="category-img" alt="' . $cat_name . '">';
    $content .= '<div class="category-name">' . $cat_name . '</div>';
    $content .= '<ul class="subcategory-list">';

    while ($sub = $subcats->fetch_assoc()) {
        $sub_name = htmlspecialchars($sub['subcategory']);
        $sub_slug = htmlspecialchars($sub['slug']);
        $content .= '<li><a href="/category/' . $sub_slug . '">' . $sub_name . '</a></li>';
    }

    $content .= '</ul>';
    $content .= '</div>';

    $subcat_stmt->close();
}

$content .= '</div></div>';
?>

<?php
$pageTitle = "Articles | Written in the Stars";
$metaDescription = "Explore astrological insights on love, connection, and destiny. Discover our beautiful collection of articles on synastry, composite charts, house placements, and more.";
$currentPage = 'articles';
include 'header.php';
?>

<section style="background-color: #fefafc; color: #2c2c2c; padding: 30px 15px; font-family: 'Georgia', serif;">
  <div style="background: #ffffff; padding: 30px 20px; border-radius: 20px; max-width: 90%; margin: 0 auto; box-shadow: 0 0 40px rgba(0,0,0,0.06); text-align: center;">

    <h1 style="margin-top:0px;padding:0px;">Explore Soulful Astrology Articles</h1>
    <p class="intro">
      Discover a universe of insight through our soulful astrology library. From twin flame dynamics and soulmate connections to planetary aspects in synastry, transits through the houses, and karmic nodal influences.
    </p>

    <?= $content ?>

  </div>
</section>

<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var grid = document.querySelector('.grid-container');
    imagesLoaded(grid, function () {
      new Masonry(grid, {
        itemSelector: '.category-box',
        columnWidth: 360,
        gutter: 20,
        fitWidth: false
      });
    });
  });
</script>

<?php include 'footer.php'; ?>
