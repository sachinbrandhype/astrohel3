<!DOCTYPE html>
<html>
   <head>
      <style>
         body{font-size: 10px;}
         div{font-weight: bold; padding-bottom: 5px;}

      </style>
   </head>
   <body>
      <table style="width: 100%" align="center">
         <tr align="center">
            <td><img src="<?=base_url('uploads/invoice_images/logo.png')?>" width="150"></td>
         </tr>
      </table>
      <table style="width: 100%; background-color: #ff9445;" align="center">
         <tr align="center">
            <td style="color: #fff">Invoice</td>
         </tr>
      </table>
      <table style="width: 100%">
         <tr>
            <td style="width: 30%; vertical-align: top;">
               <p style="color: #828282; font-size: 12px">Sold By:</p>
               <p><strong>Shaktipeeth Digital Pvt. Ltd.</strong></p>
               <p>Godrej Waterside, Tower1,</p>
               <p>Unit No: 504, 5th Floor, DP-5,</p>
               <P>Sector-v, Salt Lake City,</P>
               <p>Kolkata 700091, West Bengal, India</p>
               <p style="line-height: 2;"><span style="color: #828282; font-size: 14px;">PAN:</span>ABCCS8779E</p>
               <p><span style="color: #828282; font-size: 14px;">GST Registration No:</span> 19ABCCS8779E1ZR</p>
            </td>
            <td align="right" style="width: 70%;">
               <p style="font-size: 12px; color: #828282;">Customer Address:</p>
               <p>Name: <?=$name?></p>
               <p>City: <?=$city?></p>
               <p>Pincode/Zip:,</p>
               <p>State: <?=$state?>,</p>
               <p>Country: <?=$country?></p>
               <p style="font-size: 12px; color: #828282;">Billing Address:</p>
               <p>Name: <?=$name?></p>
               <p>City: <?=$city?></p>
               <p>Pincode/Zip:,</p>
               <p>State: <?=$state?>,</p>
               <p>Country: <?=$country?></p>
            </td>
         </tr>
      </table>
      <br><br>
      <table style="width: 100%; background-color: #f6f6f6; margin-top: -10px;">
         <tr>
            <td style="width: 49%;">
               <p><span style="color: #828282;">Order Number:</span> <?=$order_number?></p>
               <p><span style="color: #828282;">Order Date:</span> <?=$time?></p>
               <p>16:10:18</p>
            </td>
            <td align="right" style="width: 49%; vertical-align: top;">
               <p><span style="color: #828282;">Invoice Number:</span> <?=$order_number?></p>
               <p><span style="color: #828282;">Invoice Date:</span> <?=$invoice_time?></p>
               <p>15:58:34</p>
            </td>
         </tr>
      </table>
      <br>
      <br>


      <table style="width:100%;" border="1">
         <tr align="left">
            <th>SI.</th>
            <th>Description</th>
            <th>Unit Price</th>
            <th>Qty</th>
            <th>Net Amt</th>
            <th>Tax Rate</th>
            <th>Tax Type</th>
            <th>Tax Amt</th>
            <th>Total Amt</th>
         </tr>
         <tr>
            <td>
               <strong>1</strong>
            </td>
            <td><?=$puja_name?><br><span style="font-size: 12px;"><?=$booking_date?></span> <br> 
               <span style="font-size: 12px;"><?=$booking_time?><?php if ($end_time): ?>
                  -<?=$end_time ?>
               <?php endif ?> <?=$location_name?><?php if ($venue_details): ?>
                  / <?=$venue_details?>
               <?php endif ?></span>
            </td>
            <td>Rs. <?=$unit_Price?></td>
            <td>1</td>
            <td>Rs. <?=$unit_Price?></td>
            <td>18.00 %</td>
            <td>IGST</td>
            <td>Rs. <?=$tax_amount?></td>
            <td>Rs. <?=$total_amount?></td>
         </tr>
         <tr>
            <td colspan="8">
               <strong>Total</strong>
            </td>
            <td style="text-align: center;"><strong>Rs. <?=$total_amount?></strong></td>
         </tr>
      </table>
      <table style="width: 100%;">
         <tr>
            <td>
               <p>
                  <span>Amount in words:  <?=ucfirst($word_rs)?></span>
               </p>
            </td>
         </tr>
      </table>
    
      <table style="width: 100%" align="right">
         <tr align="right">
            <td>
               <img src="<?=base_url('uploads/invoice_images/')?>/footer.png" width="80">
               <p>This is a computer generated invoice, and doesn't require signature</p>
            </td>
         </tr>
      </table>
   </body>
</html>