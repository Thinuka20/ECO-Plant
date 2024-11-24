<?php

require "connection.php";
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_GET["u"])) {
    $username=$_GET["u"];
    $rs = Database::search("SELECT * FROM `users` WHERE `username`='".$username."'");
    $d = $rs->fetch_assoc();
    $email = $d["email"];
    $n = $rs -> num_rows;
    if ($n == 1) {
        $code = random_int(100000, 999999);
        Database::iud("UPDATE `users` SET `v_code`='".$code."' WHERE `email`='".$email."'");
            $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'mail.ecoplantlk.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@ecoplantlk.com';
        $mail->Password = 'i4kjpqtRw&u@';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('noreply@ecoplantlk.com', 'Ecoplant Reset Password');
        $mail->addReplyTo('noreply@ecoplantlk.com', 'Ecoplant Reset Password');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Eco Plant Forgot Password Verification Code';
            $bodyContent = '<!DOCTYPE html>
            <html>
            
            <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
            </head>
            
            <body style="margin: 0; padding: 0; background-color: #f7f7f7;">
              <table style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <tr>
                  <td style="padding: 40px 30px; background-color: #0d85fc; border-top-left-radius: 10px; border-top-right-radius: 10px; color: #ffffff;">
                    <h2 style="margin: 0; text-align: center;">Verification Code</h2>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 4px 30px;">
                    <h3 style="text-align: center;">'.$code.'</h3>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 30px; background-color: #f7f7f7; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; text-align: center; color: #666666;">
                    <p>&copy; 2023 Affinity. All rights reserved.</p>
                  </td>
                </tr>
              </table>
            </body>
            
            </html>';
            $mail->Body    = $bodyContent;
            if(!$mail->send()){
                echo ("Verification code sending failed");
            }else{
                echo ("Success");
            }
    } else {
        echo("Invalid Username");
    }
    
}else {
    echo("Please Enter your username");
}


?>