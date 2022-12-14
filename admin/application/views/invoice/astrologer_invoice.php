<!DOCTYPE html>
<html>
   <head>
   </head>
   <body>
      <table style="width: 100%" align="center">
         <tr align="center">
            <td><img src="http://139.59.25.187/admin/uploads/common/logo.png" width="90"></td>
         </tr>
      </table>
      <table style="width: 100%; background-color: #ff9445;" align="center">
         <tr align="center">
            <td style="color: #fff"> Invoice</td>
         </tr>
      </table>


      <table style="width: 100%; vertical-align: top;">
         <tr>
            <td style="width: 30%; vertical-align: top;">
                <span style="font-size: 10px; color: #828282;">Customer Address:</span><br>
               <span style="font-size: 10px;">Name: <?=$name?></span><br><br>
               <span style="font-size: 10px;">City: <?=$city?></span><br>
            <!--    <span style="font-size: 10px;">Pincode/Zip:<?=$zip?>,</span><br> -->
               <span style="font-size: 10px;">State: <?=$state?>,</span><br>
               <span style="font-size: 10px;">Country: <?=$country?></span><br>
               <!-- <p style="color: #828282; font-size: 10px;">Sold By:</p>
               <p style="font-size: 10px; color:#000;">Shaktipeeth Digital Pvt. Ltd.</p>
               <span style="font-size: 10px;">Godrej Waterside, Unit No: 1206,</span>
               <span style="font-size: 10px;">Tower 2, 12th Floor, Block - Dp,</span>
               <span style="font-size: 10px;">Sector-v, Salt Lake City,</span>
               <span style="font-size: 10px;">Kolkata 700091, West Bengal, India</span><br><br>
               <span style="font-size: 10px;"><span style="color: #828282;">PAN:</span>ABCCS8779E</span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">GST Registration No:</span> 19ABCCS8779E1ZR</span> -->
            </td>
            <td align="right" style="width: 70%;">
             
               <span style="font-size: 10px; color: #828282;">Billing Address:</span><br><br>
               <span style="font-size: 10px;">Name: <?=$name?></span><br>
               <span style="font-size: 10px;">City: <?=$city?></span><br>
             <!--   <span style="font-size: 10px;">Pincode/Zip:<?=$b_zip?>,</span><br> -->
               <span style="font-size: 10px;">State: <?=$state?>,</span><br>
               <span style="font-size: 10px;">Country: <?=$country?></span><br>
            </td>
         </tr>
      </table>
      <table style="width: 100%; background-color: #f6f6f6;" cellpadding="5">
         <tr>
            <td style="width: 49%;">
               <span style="font-size: 10px;"><span style="color: #828282;">Order Number:</span> KOL<?=$booking_id?></span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">Order Date:</span> <?=$order_date?></span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">Start Time:</span> <?=$start_time11?></span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">End Time:</span> <?=$end_time11?></span><br>
             <!--   <span style="font-size: 10px;"><?=$schedule_time?></span> -->
            </td>
            <td align="right" style="width: 49%;">
               <span style="font-size: 10px;"><span style="color: #828282;">Booking type:</span> <?php 
            if ($type == 1) 
            {
              echo "Video";
            }
            elseif ($type == 2) {
               echo "Audio";
            }
            elseif ($type == 3) {
               echo "Chat";
            }
            ?></span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">Invoice Number:</span> <?=$booking_id?></span><br>
               <span style="font-size: 10px;"><span style="color: #828282;">Invoice Date:</span> <?=date('d/m/Y')?></span><br>
               <span style="font-size: 10px;"><?=date("h:i:s")?></span>
            </td>
         </tr>
      </table>
      <table style="width: 100%;">
         <tr>
            <td height="5"></td>
         </tr>
      </table>

<table style="width:100%; border-collapse: collapse; border: 1px solid #000;" border="1" cellpadding="5">
         <tr align="left">
            <th width="60" style="background-color: #ff9445; color: #fff; font-size: 10px; text-align: center;">SI.</th>
            <th width="220" style="background-color: #ff9445; color: #fff; font-size: 10px; text-align: center;">Astrologer Name</th>
            <th width="80" style="background-color: #ff9445; color: #fff; font-size: 10px; text-align: center;">GST</th>
            <th width="80" style="background-color: #ff9445; color: #fff; font-size: 10px; text-align: center;">Sub Total</th>
            <th width="60" style="background-color: #ff9445; color: #fff; font-size: 10px; text-align: center;">Discount</th>
            <th width="120" style="background-color: #ff9445; color: #fff; font-size: 10px; text-align: center;">Payable Amount</th>
        
         </tr>

         

         <tr>
            <td>
               <strong style="text-align: center; font-size: 10px;"><?php echo 1 ;?></strong>
            </td>
          
            <td style="text-align: center; font-size: 10px;"><?= $astrologers_name; ?></td>
            <td style="text-align: center; font-size: 10px;"><?= $gst; ?></td>
            <td style="text-align: center; font-size: 10px;">₹ <?= $subtotal; ?></td>
            <td style="text-align: center; font-size: 10px;">₹ <?= $discount; ?></td>
            <td style="text-align: center; font-size: 10px;">₹ <?php
                if ($is_premium == 1) {
                  echo $amt;
                }
                elseif($type == 4){
                 echo $amt;
                }else{
                 echo  $price_per_mint * $total_minutes;
                }
              ?></td>
         
         </tr>
          

         <tr>
            <td colspan="5">
               <strong>Total</strong>
            </td>
            <td style="text-align: center; font-size: 12px;"><strong>₹ <?php
                if ($is_premium == 1) {
                  echo $amt;
                }
                elseif($type == 4){
                 echo $amt;
                }else{
                 echo  $price_per_mint * $total_minutes;
                }
              ?></strong></td>
         </tr>
      </table>

<table style="width: 100%;">
         <tr>
            <td>
               <span style="font-size: 10px;">
               <span style="color: #828282;">Amount in words:</span> 


                  <?php
                   if ($is_premium == 1) {
                  $p_amount = $amt;
                }
                elseif($type == 4){
                $p_amount = $amt;
                }else{
                 $p_amount =  $price_per_mint * $total_minutes;
                }


                  echo $this->global_config->indian_rupees_in_words($p_amount);
                
                  ?>


               </span>
            </td>
         </tr>
      </table>
      <table style="width: 100%" align="right">
         <tr>
            <td>
               <!-- <img src="<?=base_url('uploads/invoice_images/')?>/footer.png" width="60"> -->
               <p style="font-size: 10px;">(This is a computer generated pro forma invoice, and doesn't require
signature)<br>
Order will be confirmed only after payment of this proforma invoice.<br>
This is only proforma invoice, invoice will be generated after<br>
completion of the services</p>
            </td>
         </tr>
      </table>
   </body>
</html>