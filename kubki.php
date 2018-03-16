<?php require_once 'includes/init.php'; ?>
<?php
$categories = Category::findAll();
$products = Product::findAll();
?>
<?php require_once 'includes/header.php'; ?>

    <!--        Navbar dla stron dla niezalogowanych-->
<?php $session->isSignedIn() ? require_once 'includes/navbar_log.php' : require_once 'includes/navbar_nolog.php'; ?>
    </div>
    <div class="row">

    <div class="col-lg-2">
        <hr>
        <div class="row">


            <ul class="list-group categories-list pull-right" id="categoriesList">
                <?php foreach ($categories as $category) : ?>
                    <a href="kubki.php?category_id=<?php echo $category->id; ?>">
                        <li class="list-group-item">Kubki <?php echo $category->category; ?></li>
                    </a>
                <?php endforeach; ?>
            </ul>
            <hr>

        </div>
    </div>

    <div class="col-lg-8">

    <div class="container">
    <div class="row">
<?php if (isset($_GET['category_id'])) : ?>
    <?php foreach ($products as $product) : ?>
        <?php if($product->status == 'widoczny' && $product->type == 'shop') : ?>
        <?php if ($_GET['category_id'] == $product->category_id) : ?>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="project">
                    <div class="project-img">
                        <a href="przyklad.php?product_id=<?php echo $product->id; ?>" class="btn-ghost btn-hover">Kup
                            Teraz</a>
                        <p><img src="admin/<?php echo $product->picture_path(); ?>" alt="kubek" class="img-responsive">
                        </p>
                    </div>
                    <p class="text-center"><?php echo $product->name; ?></p>
                </div>
            </div>
        <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (!isset($_GET['category_id'])) : ?>
    <?php foreach ($products as $product) : ?>
        <?php if($product->status == 'widoczny' && $product->type == 'shop') : ?>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="project">
                    <div class="project-img">
                        <a href="przyklad.php?product_id=<?php echo $product->id; ?>" class="btn-ghost btn-hover">Kup
                            Teraz</a>
                        <p><img src="admin/<?php echo $product->picture_path(); ?>" alt="kubek" class="img-responsive">
                        </p>
                    </div>
                    <p class="text-center"><?php echo $product->name; ?></p>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

    </div>

    </div>
    </div>
    </div>
    <!--Footer-->
    <?php require_once 'includes/footer.php'; ?>