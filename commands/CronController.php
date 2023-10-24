<?php

namespace app\commands;

use app\models\Project;
use app\models\Tender;
use app\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Html;
use yii\mail\MailerInterface;

class CronController extends Controller
{
    public function actionIndex()
    {

        $currentDate = date('Y-m-d'); // Get the current date
            $reminderDate = date('Y-m-d', strtotime('+1 week')); // Calculate the reminder date (one week from today)
            
            // Tender with expiration date less than a week from the current date
            $project = Project::find()
                ->all();
        
            foreach ($project as $proj) {
                $projectmanager = User::findOne(['id' => $proj->user_id]);

                //tender
                $tender=Tender::findOne(['id'=>$proj->tender_id]);
        
                // Calculate the difference in days between the expiration date and the current date
                $expiredDays = floor(($proj->expired_at - strtotime($currentDate)) / (60 * 60 * 24));
                
                // Only send the email if the expiration date is less than 7 days away
                if ($expiredDays >= 0 && $expiredDays < 7 ) {
                    /** @var MailerInterface $mailer */
                    $mailer = Yii::$app->mailer;
                    $message = $mailer->compose()
                        ->setFrom('nicholaussomi5@gmail.com')
                        ->setTo($projectmanager->email)
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
                                    <p>Dear ' . Html::encode($projectmanager->username) . ',</p>
                                    <p>You have less than a week until the project deadline, As a Project Manager of this tender:</p>
                                    <ul>
                                        <li>Project Title: ' . Html::encode($tender->title) . '</li>

                                        <li>Submission Date: ' . Html::encode(date('Y-m-d', $proj->end_at)) . '</li>
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