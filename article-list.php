<?php
include 'db.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Fetch sub-subcategory by slug
$stmt = $conn->prepare("SELECT * FROM subsubcategories WHERE slug = ? LIMIT 1");
$stmt->bind_param("s", $slug);
$stmt->execute();
$subsub_result = $stmt->get_result();
$subsub = $subsub_result->fetch_assoc();
$stmt->close();

$content = '';

if ($subsub) {
    $subsub_name = htmlspecialchars($subsub['subsubcategory']);
    $subsub_slug = htmlspecialchars($subsub['slug']);
    $subcategory_id = $subsub['subcategory_id'];

    // Fetch subcategory
    $stmt = $conn->prepare("SELECT * FROM subcategories WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $subcategory_id);
    $stmt->execute();
    $sub_result = $stmt->get_result();
    $subcategory = $sub_result->fetch_assoc();
    $stmt->close();

    $subcategory_name = $subcategory ? htmlspecialchars($subcategory['subcategory']) : '';
    $subcategory_slug = $subcategory ? htmlspecialchars($subcategory['slug']) : '';
    $category_id = $subcategory ? $subcategory['category_id'] : 0;

    // Fetch category
    $stmt = $conn->prepare("SELECT name, slug FROM categories WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $cat_result = $stmt->get_result();
    $category = $cat_result->fetch_assoc();
    $stmt->close();

    $category_name = $category ? htmlspecialchars($category['name']) : 'Category';
    $category_slug = $category ? htmlspecialchars($category['slug']) : '';

    $image_url = "/images/" . $category_id . ".jpg";

    // Breadcrumb
    $breadcrumb = '<nav class="breadcrumb">';
    $breadcrumb .= '<a href="/">Home</a> <span class="breadcrumb-arrow">→</span> ';
    $breadcrumb .= '<a href="/category/' . $category_slug . '">' . $category_name . '</a> <span class="breadcrumb-arrow">→</span> ';
    $breadcrumb .= '<a href="/category/' . $subcategory_slug . '">' . $subcategory_name . '</a> <span class="breadcrumb-arrow">→</span> ';
    $breadcrumb .= '<span>' . $subsub_name . '</span>';
    $breadcrumb .= '</nav>';

    // Build page
    $content .= $breadcrumb;
    $content .= '<div class="header-image"><img src="' . $image_url . '" alt="' . $category_name . '"></div>';
    $content .= '<p class="category-label">' . $category_name . '</p>';
    $content .= '<h1 class="subcategory-heading">' . $subsub_name . '</h1>';

    // Fetch articles
    $stmt = $conn->prepare("SELECT title, slug FROM pages WHERE subsubcategory_id = ?");
    $stmt->bind_param("i", $subsub['id']);
    $stmt->execute();
    $article_result = $stmt->get_result();

    if ($article_result->num_rows > 0) {
        $content .= '<div class="article-list">';
        while ($row = $article_result->fetch_assoc()) {
            $title = htmlspecialchars($row['title']);
            $article_slug = htmlspecialchars($row['slug']);
            $content .= '<a class="article-link" href="/article/' . $article_slug . '">' . $title . '</a>';
        }
        $content .= '</div>';
    } else {
        $content .= '<p class="no-subsub">No articles found in this section.</p>';
    }

    $stmt->close();

} else {
    $content .= '<p class="not-found">Sub-subcategory not found.</p>';
}
?>

<?php
$pageTitle = "$subcategory_name: $subsub_name | Written in the Stars";
$metaDescription = "$subcategory_name - $subsub_name";
$currentPage = 'articles';
include 'header.php';
?>

<section class="privacy-section" style="background-color: #fefafc; color: #2c2c2c; padding: 10px 20px; font-family: 'Georgia', serif;">
  <div class="privacy-container" style="max-width: 850px; margin: 0 auto; background: #ffffff; padding: 10px 40px; border-radius: 20px; box-shadow: 0 0 30px rgba(0,0,0,0.05);">
    <?= $content ?>
  </div>
</section>

<?php include 'footer.php'; ?>
