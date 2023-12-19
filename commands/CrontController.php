<?php

namespace app\commands;

use app\models\Activity;
use app\models\Adetail;
use app\models\Setting;
use app\models\Tender;
use app\models\User;
use app\models\UserActivity;
use app\models\UserAssignment;
use Yii;
use yii\console\Controller;
use yii\helpers\Html;
use yii\mail\MailerInterface;

class CrontController extends Controller
{
    public function actionIndex()
        {
            $currentDate = date('Y-m-d'); // Get the current date
            $reminderDate = date('Y-m-d', strtotime('+1 week')); // Calculate the reminder date (one week from today)
            
            // Tender with expiration date less than a week from the current date
            $tenders = Tender::find()
                ->all();
        
            foreach ($tenders as $tender) {
                
        
                // Calculate the difference in days between the expiration date and the current date
                $expiredDays = floor(($tender->expired_at - strtotime($currentDate)) / (60 * 60 * 24));

                $adetail_tender=Adetail::findOne(['tender_id'=>$tender->id]);
               

                if ($adetail_tender !== null) {
                    $supervisor_ad = User::findOne(['id' => $adetail_tender->supervisor]);
                // Only send the email if the expiration date is less than 7 days away
                if ($expiredDays >= 0 && $expiredDays < 7 ) {
                    /** @var MailerInterface $mailer */
                    $mailer = Yii::$app->mailer;
                    $message = $mailer->compose()
                        ->setFrom('nicholaussomi5@gmail.com')
                        ->setTo($supervisor_ad->email)
                        ->setSubject('Reminder notification')
                        ->setHtmlBody('
                            <html>
                            <head>
                                <!-- CSS styles for the email body -->
                                <style>
                                /* CSS styles for the email body */
                                body {
                                    font-family: Arial, sans-serif;
                                    background-color: #f4f4f4;
                                }

                                .container {
                                    max-width: 600px;
                                    margin: 0 auto;
                                    padding: 20px;
                                    background-color: #ffffff;
                                    border: 1px solid #dddddd;
                                    border-radius: 4px;
                                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                                }

                                h1 {
                                    color: blue;
                                    text-align: center;
                                }

                                p {
                                    color: #666666;
                                }

                                .logo {
                                    text-align: center;
                                    margin-bottom: 20px;
                                }

                                .logo img {
                                    max-width: 200px;
                                }

                                .assigned-by {
                                    font-weight: bold;
                                }

                                .button {
                                    display: inline-block;
                                    padding: 10px 20px;
                                    background-color: #3366cc;
                                    color: white;
                                    text-decoration: none;
                                    border-radius: 4px;
                                    margin-top: 20px;
                                }

                                .button:hover {
                                    background-color: #235daa;
                                }
                            </style>
                            </head>
                            <body>
                                <div class="container">
                                    <div class="logo">
                                    <img src="https://ci6.googleusercontent.com/proxy/s2ioZxU1n6rXmuUxz4xYQ36Pfr2j1HnbSNgHwy2c6pjTWEvzsLe9VdZGhYp-7dE-n6oTkJ79jUw9pHPeXRePiOT7U4irwAl5esSZrsPPqvZr8N1o6g2Bhh7k7M5UGUk=s0-d-e1-ft#http://teratech.co.tz/local/images/uploads/logo/163277576061522e507c527.webp" alt="teralogo">
                                    </div>
                                    <h1>TERATECH ANNOUCEMENT</h1>
                                    <p>Dear ' . Html::encode($supervisor_ad->username) . ',</p>
                                    <p>You have less than a week until the tender submission, As a Supervisor of this tennder:</p>
                                    <ul>
                                        <li>Tender Title: ' . Html::encode($tender->title) . '</li>
                                        <li>Submission Date: ' . Html::encode(date('Y-m-d', $tender->expired_at)) . '</li>
                                    </ul>
                                    <p>.</p>
                                    <a href="https://example.com">Link Text</a>
                                </div>
                            </body>
                            </html>
                        ');
        
                    $mailer->send($message);


                //Send notification to all who assigned tender activities
            
                $assigned=UserActivity::find()
                ->where(['tender_id'=>$tender->id])
                ->all();
                if($assigned !== null){
                    foreach($assigned as $asign){

                        $assign_to=User::findOne(['id'=>$asign->user_id]);
                        $activity=UserActivity::find()
                        ->where(['tender_id'=>$tender->id])
                       ->all();

                       $activit=UserActivity::find()
                       ->where(['tender_id'=>$tender->id])
                      ->count();
                       
                       if($activity !== null){
                        
                        foreach ($activity as $acty) {
                        $tender_activity =Activity::findOne(['id'=>$acty->activity_id]);

                        $mailer = Yii::$app->mailer;
                        $message = $mailer->compose()
                            ->setFrom('nicholaussomi5@gmail.com')
                            ->setTo($assign_to->email)
                            ->setSubject('Reminder notification')
                            ->setHtmlBody('
                                <html>
                                <head>
                                    <!-- CSS styles for the email body -->
                                    <style>
                                    /* CSS styles for the email body */
                                    body {
                                        font-family: Arial, sans-serif;
                                        background-color: #f4f4f4;
                                    }
    
                                    .container {
                                        max-width: 600px;
                                        margin: 0 auto;
                                        padding: 20px;
                                        background-color: #ffffff;
                                        border: 1px solid #dddddd;
                                        border-radius: 4px;
                                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                                    }
    
                                    h1 {
                                        color: blue;
                                        text-align: center;
                                    }
    
                                    p {
                                        color: #666666;
                                    }
    
                                    .logo {
                                        text-align: center;
                                        margin-bottom: 20px;
                                    }
    
                                    .logo img {
                                        max-width: 200px;
                                    }
    
                                    .assigned-by {
                                        font-weight: bold;
                                    }
    
                                    .button {
                                        display: inline-block;
                                        padding: 10px 20px;
                                        background-color: #3366cc;
                                        color: white;
                                        text-decoration: none;
                                        border-radius: 4px;
                                        margin-top: 20px;
                                    }
    
                                    .button:hover {
                                        background-color: #235daa;
                                    }
                                </style>
                                </head>
                                <body>
                                    <div class="container">
                                        <div class="logo">
                                        <img src="https://ci6.googleusercontent.com/proxy/s2ioZxU1n6rXmuUxz4xYQ36Pfr2j1HnbSNgHwy2c6pjTWEvzsLe9VdZGhYp-7dE-n6oTkJ79jUw9pHPeXRePiOT7U4irwAl5esSZrsPPqvZr8N1o6g2Bhh7k7M5UGUk=s0-d-e1-ft#http://teratech.co.tz/local/images/uploads/logo/163277576061522e507c527.webp" alt="teralogo">
                                        </div>
                                        <h1>TERATECH ANNOUCEMENT</h1>
                                        <p>Dear ' . Html::encode($assign_to->username) . ',</p>
                                        <p>You have less than a week until the tender submission work harder to complete your part:</p>
                                        <ul>
                                            <li>Tender Title: ' . Html::encode($tender->title) . '</li>
                                            <li>Part Required: ' . Html::encode($tender_activity->name) . '</li>
                                            <li>Submission Date: ' . Html::encode(date('Y-m-d', $acty->submit_at)) . '</li>
                                        </ul>
                                        <p>.</p>
                                        <a href="https://example.com">Link Text</a>
                                    </div>
                                </body>
                                </html>
                            ');
            
                        $mailer->send($message);
    

                    }
                }

                }
            }
        }
                }
    
             
     }
    }
    
    public function actionStatus(){
        $currentDate = date('Y-m-d'); // Get the current date
        
        // Tender with expiration date less than a week from the current date
        $tenders = Tender::find()->where(['status'=>3])
            ->all();
    
        foreach ($tenders as $tender) {
            
    
            // Calculate the difference in days between the expiration date and the current date
            $expiredDays = floor((strtotime($currentDate) - $tender->expired_at) / (60 * 60 * 24));

            $adetail_tender=Adetail::findOne(['tender_id'=>$tender->id]);
           

            if ($adetail_tender !== null) {
                $supervisor_ad = User::findOne(['id' => $adetail_tender->supervisor]);
            // Only send the email if the expiration date is less than 7 days away
            if ($expiredDays >= 45 && $expiredDays < 120) {
                /** @var MailerInterface $mailer */
                $mailer = Yii::$app->mailer;
                $message = $mailer->compose()
                    ->setFrom('nicholaussomi5@gmail.com')
                    ->setTo($supervisor_ad->email)
                    ->setSubject('Reminded to Update tender status as soon results are published')
                    ->setHtmlBody('
                        <html>
                        <head>
                            <!-- CSS styles for the email body -->
                            <style>
                            /* CSS styles for the email body */
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f4f4f4;
                            }

                            .container {
                                max-width: 600px;
                                margin: 0 auto;
                                padding: 20px;
                                background-color: #ffffff;
                                border: 1px solid #dddddd;
                                border-radius: 4px;
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                            }

                            h1 {
                                color: blue;
                                text-align: center;
                            }

                            p {
                                color: #666666;
                            }

                            .logo {
                                text-align: center;
                                margin-bottom: 20px;
                            }

                            .logo img {
                                max-width: 200px;
                            }

                            .assigned-by {
                                font-weight: bold;
                            }

                            .button {
                                display: inline-block;
                                padding: 10px 20px;
                                background-color: #3366cc;
                                color: white;
                                text-decoration: none;
                                border-radius: 4px;
                                margin-top: 20px;
                            }

                            .button:hover {
                                background-color: #235daa;
                            }
                        </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="logo">
                                <img src="https://ci6.googleusercontent.com/proxy/s2ioZxU1n6rXmuUxz4xYQ36Pfr2j1HnbSNgHwy2c6pjTWEvzsLe9VdZGhYp-7dE-n6oTkJ79jUw9pHPeXRePiOT7U4irwAl5esSZrsPPqvZr8N1o6g2Bhh7k7M5UGUk=s0-d-e1-ft#http://teratech.co.tz/local/images/uploads/logo/163277576061522e507c527.webp" alt="teralogo">
                                </div>
                                <p>Dear ' . Html::encode($supervisor_ad->username) . ',</p>
                                <p>This tender is range between 45 to 120 days, So you reminded to update the status either AWARD OR NOT AWARD based on results:</p>
                                <ul>
                                    <li>Tender Title: ' . Html::encode($tender->title) . '</li>
                                    <li>Tender PE: ' . Html::encode($tender->PE) . '</li>
                                    <li>Expired days: ' . Html::encode($expiredDays) . '</li>
                                    <li>Submission Date: ' . Html::encode(date('Y-m-d', $tender->expired_at)) . '</li>
                                </ul>
                                <p>.</p>
                                <a href="https://example.com">Link Text</a>
                            </div>
                        </body>
                        </html>
                    ');
    
                $mailer->send($message);
    }
            }

         
 }
    }
  
   

    // public function actionStatus()
    // {
    //     $settings=Setting::findOne(1);
    //     $result_interval=$settings->result;
    //     $tenderDetails = Tender::find()->where(['status' => 5])->all();
    //     $currentDate = date('Y-m-d'); // Get the current date
    
    //     foreach ($tenderDetails as $tenderD) {
    //         $expiredDate = $tenderD->expired_at  + ($result_interval * 3600 * 24);
    
    //         if ($expiredDate <= $currentDate) {
    //             $tenderD->status = 4;
    //             $tenderD->save();
    //         }
    //     }
    // }



    public function actionNoasign(){
        // $noassign_tender = 
         // Find new tenders
         $new = Tender::find()
         ->Where(['session'=>0])
         ->all();

         $noassign_tender = [];
         foreach ($new as $new) {

            $user_activity = UserActivity::findOne(['tender_id'=>$new->id]);
            if($user_activity===null){
                $noassign_tender[]=Tender::findOne($new->id);
            }

           
         }
      foreach($noassign_tender as $noassign_tender) {
        $notassign_send_email=Tender::findOne($noassign_tender->id);
        $created_by=User::findOne($noassign_tender->created_by);

        $mailer = Yii::$app->mailer;
        $message = $mailer->compose()
            ->setFrom('nicholaussomi5@gmail.com')
            ->setTo($created_by->email)
            ->setSubject('Reminder notification')
            ->setHtmlBody('
                <html>
                <head>
                    <!-- CSS styles for the email body -->
                    <style>
                    /* CSS styles for the email body */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                    }

                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #ffffff;
                        border: 1px solid #dddddd;
                        border-radius: 4px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }

                    h1 {
                        color: blue;
                        text-align: center;
                    }

                    p {
                        color: #666666;
                    }

                    .logo {
                        text-align: center;
                        margin-bottom: 20px;
                    }

                    .logo img {
                        max-width: 200px;
                    }

                    .assigned-by {
                        font-weight: bold;
                    }

                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #3366cc;
                        color: white;
                        text-decoration: none;
                        border-radius: 4px;
                        margin-top: 20px;
                    }

                    .button:hover {
                        background-color: #235daa;
                    }
                </style>
                </head>
                <body>
                    <div class="container">
                        <div class="logo">
                        <img src="https://ci6.googleusercontent.com/proxy/s2ioZxU1n6rXmuUxz4xYQ36Pfr2j1HnbSNgHwy2c6pjTWEvzsLe9VdZGhYp-7dE-n6oTkJ79jUw9pHPeXRePiOT7U4irwAl5esSZrsPPqvZr8N1o6g2Bhh7k7M5UGUk=s0-d-e1-ft#http://teratech.co.tz/local/images/uploads/logo/163277576061522e507c527.webp" alt="teralogo">
                        </div>
                        <h1>TERATECH ANNOUCEMENT</h1>
                        <p>Dear ' . Html::encode($created_by->username) . ',</p>
                        <p>This tender looks like has not set compliance ,reminded to assign activities:</p>
                        <ul>
                            <li>Tender Title: ' . Html::encode($noassign_tender->title) . '</li>
                            <li>Submission Date: ' . Html::encode(date('Y-m-d', $noassign_tender->expired_at)) . '</li>
                        </ul>
                        <p>.</p>
                        <a href="https://example.com">Link Text</a>
                    </div>
                </body>
                </html>
            ');

        $mailer->send($message);
      }
        // $isEligibleTender = UserActivity::findOne(['tender_id'=>$model->id])===null ;



       
    }

}



 