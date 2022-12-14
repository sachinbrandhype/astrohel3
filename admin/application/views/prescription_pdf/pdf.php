<style>
   th, td {
   padding: 15px;
   }
</style>
<div style="padding-bottom:20px; padding-top:20px; text-align:right;">
   <img src="<?=base_url('uploads/mail_template_')?>/logo.png"><br><u>anytimedoc.in</u>
</div>

<h3>Booking Details</h3>

<table border="1" style="border-collapse: collapse; width:100%; text-align:left;">
  <tr>
    <th style="padding: 15px;"><strong>Doctor Details</strong></th>
    <td style="padding: 15px;"><?=$doctor_firstname?></td>
  </tr>
  <tr>
    <th style="padding: 15px;"><strong>User Details</strong></th>
    <td style="padding: 15px;"><?=$name?></td>
  </tr>
  <tr>
    <th style="padding: 15px;"><strong>Booking for</strong></th>
    <td style="padding: 15px;"><?=$booking_for?></td>
  </tr>
  <tr>
    
    <td style="padding: 15px;"><strong>Booking Date </strong><?=$booking_date?></td>
   
    <td style="padding: 15px;"><strong>Booking Time </strong><?=$booking_time?></td>
  </tr>
</table>
<h3>Prescription Details</h3>

<table border="1" style="border-collapse: collapse; width:100%; text-align:left;">
  <tr>
    <th style="padding: 15px;"><strong>Patient Complaint</strong></th>
    <td style="padding: 15px; line-height: 2"><?=$Patient_Complaint?></td>
  </tr>
  <tr>
    <th style="padding: 15px;"><strong>Past History</strong></th>
    <td style="padding: 15px; line-height: 2"><?=$Past_History?></td>
  </tr>
  <tr>
    <th style="padding: 15px;"><strong>Vitals</strong></th>
    <td style="padding: 15px; line-height: 2"><?=$Vitual?></td>
  </tr>
  <tr>
    <th style="padding: 15px;"><strong>Treatment Advice</strong></th>
    <td style="padding: 15px; line-height: 2"><?=$Treatment?></td>
  </tr>
  <tr>
    <th style="padding: 15px;"><strong>Provisional/Final Diagnosis</strong></th>
    <td style="padding: 15px; line-height: 2"><?=$Provisions_Final_Diagnosis?></td>
  </tr>
  
</table>
<p style="font-size: 14px;">*This is system generated prescription not valid for any medico legal case.</p>

<div style="float:left; margin-top:20px;"><img src="<?=base_url('uploads/mail_template_')?>/logo.png"></div>
<div style="float:right;">
   <p>24 x 7 helpline - <?=$helpline_number?> | <?=$support_email?> | © <?=date('Y')?> Anytimedoc. All Rights Reserved.</p>
</div>