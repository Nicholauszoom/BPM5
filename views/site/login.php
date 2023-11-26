<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\Setting;

$this->title = 'Login';
$this->context->layout = 'main2';
?>
<style>
   @keyframes zoom-in-out {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.2);
    }
    100% {
      transform: scale(1);
    }
  }
</style>

<section class="vh-100" style="background-color: white;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
      
          <div class="row g-0">
            <div class="col-md-6 col-lg-7 d-none d-md-block">
            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; z-index: 9999; position: absolute; color: #fff; margin-left:20px;">Sign In</h3>
            <img id="login-image" src="https://plus.unsplash.com/premium_photo-1675827055694-010aef2cf08f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8bmF0dXJlfGVufDB8fDB8fHww"
              alt="login form" alt="login form" class="img-fluid zoom-animation" style="border-radius: 1rem 0 0 1rem; height: 100%;" />
            </div>
            <div class="col-md-6 col-lg-5 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

              

                  <?php $form = ActiveForm::begin(['id' => 'login-form',
                'options'=>['class'=>'user']
            ]); ?>
                <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <?php
                          
                          $setting=Setting::findOne(1);
                          $fileName = $setting->logo;
                          $filePath = Yii::getAlias('@webroot/upload/' . $fileName);
                          $downloadPath = Yii::getAlias('@web/upload/' . $fileName);


                    ?>
                    <span class="h1 fw-bold mb-0 "><img src= <?=$downloadPath?> style="height: 60px;" />
</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>
                  <div class="form-outline mb-4">
<?= $form->field($model, 'email')->textInput(['autofocus' => true,    'template' => "<div class=\"form-control form-control-lg\">{input} {label}</div>\n<div class=\"form-label\">{error}</div>",
]) ?>
</div>
<div class="form-outline mb-4">
<?= $form->field($model, 'password')->passwordInput([    'template' => "<div class=\"form-control form-control-lg\">{input} {label}</div>\n<div class=\"form-label\">{error}</div>",
]) ?>
</div>
 <div class="form-outline mb-4">
<?= $form->field($model, 'rememberMe')->checkbox([
    'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"form-label\">{error}</div>",
]) ?>
</div>
              
                <div class="pt-1 mb-4">
            <?= Html::submitButton('Login', ['class' => 'btn btn-dark btn-lg btn-block', 'name' => 'login-button']) ?>
            </div>
           

            <?php ActiveForm::end() ?>

            <a class="small text-muted" href="<?php echo \yii\helpers\Url::to(['/site/forgot-password']) ?>">Forgot Password?</a>
        </br>
            <a class="small text-muted" href="<?php echo \yii\helpers\Url::to(['/']) ?>">back home</a>

        
                
               
          </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<script>
  // Array of image URLs
  var images = [

   'https://plus.unsplash.com/premium_photo-1675827055694-010aef2cf08f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8bmF0dXJlfGVufDB8fDB8fHww',
    
    'https://plus.unsplash.com/premium_photo-1661814934352-d1917abd591e?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTQ1fHxhbmltYWxzJTIwbmF0dXJlfGVufDB8fDB8fHww',

    'https://images.unsplash.com/photo-1531958532341-b88dc3d33abe?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NDZ8fGFuaW1hbHMlMjBuYXR1cmV8ZW58MHx8MHx8fDA%3D',

    'https://images.unsplash.com/photo-1527701963793-33e969bca5ee?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTg2fHxuYXR1cmV8ZW58MHx8MHx8fDA%3D',

    'https://plus.unsplash.com/premium_photo-1669725687152-498e152687ed?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjF8fGFuaW1hbHMlMjBuYXR1cmV8ZW58MHx8MHx8fDA%3D'
  
  ];

  // Index to keep track of the current image
  var currentIndex = 0;

  // Function to change the image source
  function changeImage() {
    var image = document.getElementById('login-image');
    image.src = images[currentIndex];

    // Increment the index or reset to 0 if at the end of the array
    currentIndex = (currentIndex + 1) % images.length;
  }

  // Set the interval to change the image every 5 days (in milliseconds)
  setInterval(changeImage, 5*24*60*60*1000);

   // Function to toggle the zoom animation class
   function toggleZoomAnimation() {
    var image = document.getElementById('login-image');
    image.classList.toggle('zoom-animation');
  }

  // Set the interval to toggle the zoom animation every 5 seconds (in milliseconds)
  setInterval(toggleZoomAnimation, 5000);
</script>