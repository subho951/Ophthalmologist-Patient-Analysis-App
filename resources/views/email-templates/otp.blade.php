<?php
use App\Models\GeneralSetting;
$generalSetting             = GeneralSetting::find('1');
?>
<!doctype html>
<html lang="en">
  <head>
    <title><?=$generalSetting->site_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
      .otp_text{
        margin: 0;
        margin-top: 60px;
        font-size: 40px;
        font-weight: 600;
        letter-spacing: 25px;
        color: #ba3d4f;
        text-align: center;
      }
      @media (max-width: 768px) {
        .otp_text{
          font-size: 30px;
          letter-spacing: 15px;
        }
      }
    </style>
  </head>
  <body style="padding: 0; margin: 0; box-sizing: border-box;">
    <section style="padding: 80px 0; height: 80vh; margin: 0 15px;">
        <div style="max-width: 600px; background: #ffffff; margin: 0 auto; border-radius: 15px; padding: 20px 15px; box-shadow: 0 0 30px -5px #ccc;">
          <div style="text-align: center;">
              <img src="<?=env('UPLOADS_URL').$generalSetting->site_logo?>" alt="" style=" width: 100%; max-width: 250px;">
          </div>
          <div>
            <h3 style="text-align: center; font-size: 25px; color: #5c5b5b; font-family: sans-serif;">Hi, Welcome to PCV Predictor App!</h3>
            <h4 style="text-align: center; font-family: sans-serif; color: #5c5b5b ;">Your OTP For Email Validation</h4>
            <p class="otp_text">
              <span><?=substr($otp, 0, 1)?></span>
              <span><?=substr($otp, 1, 1)?></span>
              <span><?=substr($otp, 2, 1)?></span>
              <span><?=substr($otp, 3, 1)?></span>
              <span><?=substr($otp, 4, 1)?></span>
            </p>
            <!-- <div style="width: 100%; margin: 0 auto; display: block; text-align: center;">
                <div style="padding: 12px; margin: 5px; border: 2px solid #f9233f;width: 17px; height: 17px; border-radius: 5px; display: block; text-align: center; font-size: 15px; float: left;
                font-family: sans-serif;"><?=substr($otp, 0, 1)?></div>
                <div style="padding: 12px; margin: 5px; border: 2px solid #f9233f;width: 17px; height: 17px; border-radius: 5px; display: flex; justify-content: center; align-items: center; font-size: 15px; float: left;
                font-family: sans-serif;"><?=substr($otp, 1, 1)?></div>
                <div style="padding: 12px; margin: 5px; border: 2px solid #f9233f;width: 17px; height: 17px; border-radius: 5px; display: flex; justify-content: center; align-items: center; font-size: 15px; float: left;
                font-family: sans-serif;"><?=substr($otp, 2, 1)?></div>
                <div style="padding: 12px; margin: 5px; border: 2px solid #f9233f;width: 17px; height: 17px; border-radius: 5px; display: flex; justify-content: center; align-items: center; font-size: 15px; float: left;
                font-family: sans-serif;"><?=substr($otp, 3, 1)?></div>
                <div style="padding: 12px; margin: 5px; border: 2px solid #f9233f;width: 17px; height: 17px; border-radius: 5px; display: flex; justify-content: center; align-items: center; font-size: 15px;
                font-family: sans-serif;"><?=substr($otp, 4, 1)?></div>
                <div style="padding: 12px; margin: 5px; border: 2px solid #f9233f;width: 17px; height: 17px; border-radius: 5px; display: flex; justify-content: center; align-items: center; font-size: 15px;
                font-family: sans-serif;"><?=substr($otp, 5, 1)?></div>
            </div>             -->
          </div>
        </div>
        <div style="border-top: 2px solid #ccc; margin-top: 50px; text-align: center; font-family: sans-serif;">
          <div style="text-align: center; margin: 15px 0 10px;">PCV Predictor App</div>
          <!-- <div style="text-align: center; margin: 15px 0 10px;">Phone: <?=$generalSetting->site_phone?></div> -->
          <div style="text-align: center; margin: 15px 0 10px;">Email: <?=$generalSetting->site_mail?></div>
        </div>      
    </section>
  </body>
</html>