<?php
include 'db.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';


// Fetch subcategory by slug
$stmt = $conn->prepare("SELECT * FROM subcategories WHERE slug = ? LIMIT 1");
$stmt->bind_param("s", $slug);
$stmt->execute();
$sub_result = $stmt->get_result();
$subcategory = $sub_result->fetch_assoc();
$stmt->close();

$content = '';

if ($subcategory) {
    $subcategory_name = htmlspecialchars($subcategory['subcategory']);
    $subcategory_slug = htmlspecialchars($subcategory['slug']);
    $subcategory_id = $subcategory['id'];
    $category_id = $subcategory['category_id'];

    // Fetch category
    $stmt = $conn->prepare("SELECT name, slug FROM categories WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $cat_result = $stmt->get_result();
    $category = $cat_result->fetch_assoc();
    $stmt->close();

    $category_name = $category ? htmlspecialchars($category['name']) : 'Category';
    $category_slug = $category ? htmlspecialchars($category['slug']) : '';

    // Image
    $image_url = "/images/" . $category_id . ".jpg";

    // Breadcrumb
    $breadcrumb = '<nav class="breadcrumb">';
    $breadcrumb .= '<a href="/">Home</a> <span class="breadcrumb-arrow">→</span> ';
    $breadcrumb .= '<a href="/articles">' . $category_name . '</a> <span class="breadcrumb-arrow">→</span> ';
    $breadcrumb .= '<span>' . $subcategory_name . '</span>';
    $breadcrumb .= '</nav>';

    $content .= $breadcrumb;
    $content .= '<div class="header-image"><img src="' . $image_url . '" alt="' . $category_name . '"></div>';
    $content .= '<p class="category-label">' . $category_name . '</p>';
    $content .= '<h1 class="subcategory-heading">' . $subcategory_name . '</h1>';

    // Fetch subsubcategories
    $stmt = $conn->prepare("SELECT * FROM subsubcategories WHERE subcategory_id = ?");
    $stmt->bind_param("i", $subcategory_id);
    $stmt->execute();
    $subsub_result = $stmt->get_result();

    if ($subsub_result->num_rows > 0) {
        $content .= '<div class="subsub-list">';
        while ($row = $subsub_result->fetch_assoc()) {
            $name = htmlspecialchars($row['subsubcategory']);
            $subsub_slug = htmlspecialchars($row['slug']);
            $content .= '<a class="subsub-link" href="/list/' . $subsub_slug . '">' . $name . '</a>';
        }
        $content .= '</div>';
    } else {
        // Fetch articles directly under this subcategory
        $stmt = $conn->prepare("SELECT title, slug FROM pages WHERE display=1 and subcategory_id = ?");
        $stmt->bind_param("i", $subcategory_id);
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
            $content .= '<p class="no-subsub">No sub-subcategories or articles available.</p>';
        }
        $stmt->close();
    }

} else {
    $content .= '<p class="not-found">Subcategory not found.</p>';
}
?>

<?php
$pageTitle = isset($category_name) ? "$category_name: $subcategory_name | Written in the Stars" : 'Subcategory Not Found';
$metaDescription = isset($category_name) ? "$category_name - $subcategory_name" : '';
$currentPage = 'articles';
include 'header.php';
?>

<section class="privacy-section" style="background-color: #fefafc; color: #2c2c2c; padding: 10px 20px; font-family: 'Georgia', serif;">
  <div class="privacy-container" style="max-width: 850px; margin: 0 auto; background: #ffffff; padding: 10px 40px; border-radius: 20px; box-shadow: 0 0 30px rgba(0,0,0,0.05);">
    <?= $content ?>
  </div>
</section>

<?php include 'footer.php'; ?>
