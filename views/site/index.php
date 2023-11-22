<?php

use app\models\Tattachmentss;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TattachmentssSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->context->layout = 'main';
?>
<style>
p{
  color: black;
}
  .mail-icon {
  position: fixed;
  bottom: 40px;
  right: 20px;
  z-index: 9999;
  width: 50px;
  height: 50px;
  background-color:aliceblue;
  color: #fff;
  border-radius: 50%;
  text-align: center;
  line-height: 50px;
  cursor: pointer;
}

.mail-icon:hover {
  background-color:#fff;
}
.mail-form {
  display: none;
  position: absolute;
  top: -200px;
  right: 0;
  left: 5;
  bottom:50px;
  margin: auto;
  background-color: #fff;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  z-index: 9999;
  width: 200px;
}

.mail-form h3 {
  margin-top: 0;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  font-weight: bold;
}

.form-control {
  width: 100%;
  padding: 8px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 4px;
  outline: none;
  transition: border-color 0.2s ease-in-out;
}

.form-control:focus {
  border-color: #66afe9;
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 8px 12px;
  font-size: 14px;
  cursor: pointer;
}

.btn-primary:hover {
  background-color: #0056b3;
}

</style>
 
    <div class="templateux-cover" style="background-image: url(images/hod.jpeg);">
      <div class="container">
        <div class="row align-items-lg-center">

          <div class="col-lg-6 order-lg-1">
            <h1 class="heading mb-3 text-white" data-aos="fade-up">Bussiness Process Management <strong></strong></h1>
            <p class="lead mb-5 text-white" data-aos="fade-up"  data-aos-delay="100">A “team” is not just people who work at the same time in the same place. A real team is a group of very different individuals who enjoy working together.</p>
            <p data-aos="fade-up" data-aos-delay="200"> <a href="#" class="text-white"></a></p>
          </div>
          
        </div>
      </div>
    </div> <!-- .templateux-cover -->

    <div class="templateux-section pt-0 pb-0">
      <div class="container">
        <div class="row">
          <div class="col-md-12 templateux-overlap">
            <div class="row">
              <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                <div class="media block-icon-1 d-block text-left">
                  <div class="icon mb-3">
                    <img src="/images/flaticon/svg/001-consultation.svg" alt="Image" class="img-fluid">
                  </div>
                  <div class="media-body">
                    <h3 class="h5 mb-4">Tender</h3>
                    <p>The system automate the tender Process ,in a symplified way to engeneers who deal with tenders. </p>
                    <p><a href="#">Learn More</a></p>
                  </div>
                </div> <!-- .block-icon-1 -->
              </div>
              <div class="col-md-4" data-aos="fade-up" data-aos-delay="700">
                <div class="media block-icon-1 d-block text-left">
                  <div class="icon mb-3">
                    <img src="images/flaticon/svg/002-discussion.svg" alt="Image" class="img-fluid">
                  </div>
                  <div class="media-body">
                    <h3 class="h5 mb-4">Project</h3>
                    <p>The system automate the project process, in a symplified way to endgeneers who deal with projects.</p>
                    <p><a href="#">Learn More</a></p>
                  </div>
                </div> <!-- .block-icon-1 -->
              </div>
              <div class="col-md-4" data-aos="fade-up" data-aos-delay="800">
                <div class="media block-icon-1 d-block text-left">
                  <div class="icon mb-3">
                    <img src="images/flaticon/svg/003-turnover.svg" alt="Image" class="img-fluid">
                  </div>
                  <div class="media-body">
                    <h3 class="h5 mb-4">Operation</h3>
                    <p>The system automate the operation process includes Human Resorce ,inventory and Fleet Management </p>
                    <p><a href="#">Learn More</a></p>
                  </div>
                </div> <!-- .block-icon-1 -->
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div> <!-- .templateux-section -->

  </div> <!-- .templateux-section -->

  
  <div class="templateux-section bg-light">
    <div class="container">
      <div class="row mb-5">
        <div class="col-12 text-center mb-5">
          <h2>BPM Coverage</h2>
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up">
          <div class="media block-icon-1 d-block text-center">
            <div class="icon mb-3">
              <img src="images/flaticon/svg/004-gear.svg" alt="Image" class="img-fluid">
            </div>
            <div class="media-body">
              <h3 class="h5 mb-4">Project Management</h3>
              <p>Coverage BOQ and Analysis management, Request management, Work Plann management ,compliance management, Report.</p>
            </div>
          </div> <!-- .block-icon-1 -->
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
          <div class="media block-icon-1 d-block text-center">
            <div class="icon mb-3">
              <img src="images/flaticon/svg/005-conflict.svg" alt="Image" class="img-fluid">
            </div>
            <div class="media-body">
              <h3 class="h5 mb-4">Tender Management</h3>
              <p>Coverage tender registering, tender attachments ,temder activities ,tender status ,tender reminders.</p>
            </div>
          </div> <!-- .block-icon-1 -->
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
          <div class="media block-icon-1 d-block text-center">
            <div class="icon mb-3">
              <img src="images/flaticon/svg/006-meeting.svg" alt="Image" class="img-fluid">
            </div>
            <div class="media-body">
              <h3 class="h5 mb-4">Operation Management</h3>
              <p>Coverage human resource management, inventory management, other operational actiivities.</p>
            </div>
          </div> <!-- .block-icon-1 -->
        </div>

        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
          <div class="media block-icon-1 d-block text-center">
            <div class="icon mb-3">
              <img src="images/flaticon/svg/007-brainstorming.svg" alt="Image" class="img-fluid">
            </div>
            <div class="media-body">
              <h3 class="h5 mb-4">Inventory Management</h3>
              <p>Coverage buying ,sales, purchases of the company products.</p>
            </div>
          </div> <!-- .block-icon-1 -->
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
          <div class="media block-icon-1 d-block text-center">
            <div class="icon mb-3">
              <img src="images/flaticon/svg/001-consultation.svg" alt="Image" class="img-fluid">
            </div>
            <div class="media-body">
              <h3 class="h5 mb-4">Help</h3>
              <p>System assistance for any miss-understandings for the system.</p>
            </div>
          </div> <!-- .block-icon-1 -->
        </div>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="500">
          <div class="media block-icon-1 d-block text-center">
            <div class="icon mb-3">
              <img src="images/flaticon/svg/009-brainstorming-2.svg" alt="Image" class="img-fluid">
            </div>
            <div class="media-body">
              <h3 class="h5 mb-4">Maintanance</h3>
              <p>active system maintanance for any technical issue happen in the system.</p>
            </div>
          </div> <!-- .block-icon-1 -->
        </div>

      </div>
    
    </div>
  </div> <!-- .templateux-section -->

</div> <!-- .templateux-section -->
<!--
<div class="mail-icon">
  <a href="#" class="fa fa-envelope">
    <img src="https://img.icons8.com/?size=80&id=xLIkjgcmFOsC&format=png" style="width:35px;">
  </a>
  <div class="mail-form">
    <h6>Contact Us</h6>
    <form>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
-->
<script>

  // Get the mail icon button and the mail form
const mailIcon = document.querySelector('.mail-icon');
const mailForm = document.querySelector('.mail-form');

// Toggle the visibility of the mail form when the mail icon button is clicked
mailIcon.addEventListener('click', function(event) {
  event.preventDefault();
  mailForm.style.display = mailForm.style.display === 'block' ? 'none' : 'block';
});
</script>