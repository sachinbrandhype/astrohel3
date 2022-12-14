<!DOCTYPE html>
<html>
   <head>
      <style>
         body{font-size: 14px;}
      </style>
   </head>
   <body>
      <table style="width: 100%" align="center">
         <tr align="center">
            <td>
               <h1>Astrologer Detail</h1>
            </td>
         </tr>

          <tr align="center">
            <td><img src="<?=base_url('uploads/astrologers')."/".$image?>" width="90"></td>
         </tr>

      </table>
     
    
      <table style="width: 100%; height: 50px;">
         <tr><td></td></tr>
      </table>
      <table style="width:100%; border-collapse: collapse; border: 1px solid #000;" border="1" cellpadding="5">
         <tr  align="left">
            <th><strong>Id</strong></th>
            <td><?=$id?></td>
         </tr>
         <tr  align="left">
            <th><strong>Name</strong></th>
            <td><?=$name?></td>
         </tr>
         <tr  align="left">
            <th><strong>Email</strong></th>
            <td><?=$email?></td>
         </tr>
         <tr  align="left">
            <th><strong>Experience</strong></th>
            <td><?=$experience?></td>
         </tr>
         <tr  align="left">
            <th><strong>Location</strong></th>
            <td><?=$location?></td>
         </tr>
         <tr align="left">
            <th><strong>Share Percentage</strong></th>
            <td><?=$share_percentage?></td>
         </tr>
         <tr align="left">
            <th><strong>Mobile</strong></th>
            <td><?=$mobile?></td>
         </tr>
         <tr align="left">
            <th><strong>Aadhar Number</strong></th>
            <td><?=$aadhar_number?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Pan Number</strong></th>
            <td><?=$pan_number?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Bank Account No</strong></th>
            <td><?=$bank_account_no?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Ifsc Code</strong></th>
            <td><?=$ifsc_code?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Languages</strong></th>
            <td><?=$languages?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Speciality</strong></th>
            <td><?=$speciality?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Service</strong></th>
            <td><?=$service?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Expertise</strong></th>
            <td><?=$expertise?></td>
         </tr>
         
         <tr align="left">
            <th><strong>In House Astrologers</strong></th>
            <td><?php 
               if ($in_house_astrologers == 1) 
               {
                 echo "Yes";
               }
               else{
                  echo "No";
               }
            ?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Is Premium</strong></th>
            <td><?php 
               if ($is_premium == 1) 
               {
                 echo "Yes";
               }
               else{
                  echo "No";
               }
            ?></td>
         </tr>
         <tr align="left">
            <th><strong>status</strong></th>
            <td><?php 
               if ($status == 1) 
               {
                 echo "Active";
               }
               else{
                  echo "Inactive";
               }
            ?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Price Per Mint Chat</strong></th>
            <td><?=$price_per_mint_chat?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Price Per Mint Video</strong></th>
            <td><?=$price_per_mint_video?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Price Per Mint Audio</strong></th>
            <td><?=$price_per_mint_audio?></td>
         </tr>
         
         <tr align="left">
            <th><strong>Added On</strong></th>
            <td><?=$added_on?></td>
         </tr>
         
      </table>
      <table style="width: 100%;">
         <tr align="center">
            <td>
               <p>
                  
               </p>
            </td>
         </tr>
      </table>
   </body>
</html>