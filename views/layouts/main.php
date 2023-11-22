<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Setting;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\web\View;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$setting=Setting::findOne(1);
$fileName = $setting->logo;
$filePath = Yii::getAlias('@webroot/upload/' . $fileName);
$downloadPath = Yii::getAlias('@web/upload/' . $fileName);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias($downloadPath)]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  
    <link rel="stylesheet" href="css/style2.css">

</head>
<body>
<?php $this->beginBody() ?>
<div class="js-animsition animsition" id="site-wrap" data-animsition-in-class="fade-in" data-animsition-out-class="fade-out">


<header class="templateux-navbar" role="banner">

  <div class="container"  data-aos="fade-down">
    <div class="row">

      <div class="col-3 templateux-logo">
        <a href="/" class="animsition-link">BPM-Tera</a>
      </div>
      <nav class="col-9 site-nav">
        <button class="d-block d-md-none hamburger hamburger--spin templateux-toggle templateux-toggle-light ml-auto templateux-toggle-menu" data-toggle="collapse" data-target="#mobile-menu" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button> <!-- .templateux-toggle -->

        <ul class="sf-menu templateux-menu d-none d-md-block">
          <li class="active">
            <a href="/" class="animsition-link">Home</a>
          </li>
    <li><a class="animsition-link" href="/site/login"> Sign in</a></li>
          
          <li>
            <a href="" class="animsition-link">Services</a>
            <ul>
              <li><a href="#">HR Consulting</a></li>
              <li><a href="#">Leadership Training</a></li>
              <li>
                <a href="#">HR Management</a>
                <ul>
                  <li><a href="#">Operational Management</a></li>
                  <li><a href="#">Corporate Program</a></li>
                  <li>
                    <a href="#">Service 3</a>
                    <ul>
                      <li><a href="#">Service 1</a></li>
                      <li><a href="#">Service 2</a></li>
                      <li><a href="#">Service 3</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href="" class="animsition-link">Blog</a></li>
          <li><a href="" class="animsition-link">Contact</a></li>
        </ul> <!-- .templateux-menu -->

      </nav> <!-- .site-nav -->
      

    </div> <!-- .row -->
  </div> <!-- .container -->
</header> <!-- .templateux-navba -->

        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
  

        <footer class="footer">
  	 <div class="container">
  	 	<div class="row">
  	 		<div class="footer-col">
  	 			<h4>company</h4>
  	 			<ul>
  	 				<li><a href="#">about us</a></li>
  	 				<li><a href="#">our services</a></li>
  	 				<li><a href="#">privacy policy</a></li>
  	 				<li><a href="#">affiliate program</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>get help</h4>
  	 			<ul>
  	 				<li><a href="#">FAQ</a></li>
  	 				<li><a href="#">HRM</a></li>
  	 				<li><a href="#">returns</a></li>
  	 				<li><a href="#">order status</a></li>
  	 				
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>process</h4>
  	 			<ul>
  	 				<li><a href="#">employement</a></li>
  	 				<li><a href="#">budgeting</a></li>
  	 				<li><a href="#">profits</a></li>
  	 				<li><a href="#">management</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>follow us</h4>
  	 			<div class="social-links">
  	 				<a href="#"><i class="fab fa-facebook-f"></i></a>
  	 				<a href="#"><i class="fab fa-twitter"></i></a>
  	 				<a href="#"><i class="fab fa-instagram"></i></a>
  	 				<a href="#"><i class="fab fa-linkedin-in"></i></a>
  	 			</div>
  	 		</div>
  	 	</div>
  	 </div>
  </footer>

</div> <!-- .js-animsition -->


<script src="/js/scripts-all.js"></script>
<script src="/js/main.js"></script>

</body>
</html>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>