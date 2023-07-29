<?php 

require "koneksidb.php";
  

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 	   <div class="input-group" style="width:20rem;">
 	   	   <div class="input-group-prepend">
               <span class="input-group-text" id="inputGroup-sizing-default">ID</span>
           </div>
 	   	  <input type="text" class="form-control text-center" name="idbaru" autocomplete="off" value= 
          <?=$pengaturan["idbaru"];?>>
 	   </div>
        
 
 </body>
 </html>