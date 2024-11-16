<?php
//PRODUCT FUNCTION STARTS
//function get category starts
function get_category($product_category='',$status='options'){
 // creating connection
  require_once(file_location('inc_path','connection.inc.php'));
  @$conn = dbconnect('admin','PDO');
  if($status === 'home_data'){
   $sql = "SELECT c_id,c_category,c_icon FROM category_table WHERE c_category = '{$product_category}' ORDER BY c_category";
  }else{
   $sql = "SELECT c_id,c_category,c_icon FROM category_table";
  }
		$stmt = $conn->prepare($sql);
		$stmt->bindColumn('c_id',$id);
		$stmt->bindColumn('c_category',$category);
  $stmt->bindColumn('c_icon',$icon);
		$stmt->execute();
		$numRow = $stmt->rowCount();
  if($numRow > 0){		// if a record is found
   while($stmt->fetch()){
    if($status === 'options'){
     ?>
     <option value='<?=strtolower($category)?>'<?php if(strtolower($product_category)===strtolower($category)){echo 'selected';}?>><?=ucwords($category)?></option>
     <?php
    }elseif($status === 'slideshow'){
     ?>
     <a href='<?=file_location('home_url','category/product/'.urlencode($category).'/')?>'>
     <div class='j-row'>
      <div class='j-col s2'><i class="<?=icon($icon)?>"style='padding-right:8px;'></i></div>
      <div class='j-col s10'><b><?=ucwords($category)?></b></div>
			</div>
     </a>
     <?php
    }elseif($status === 'category_page' || $status === 'home_data'){
      ?>
      <a href='<?=file_location('home_url','category/product/'.$category.'/')?>'>
       <div class='j-col <?=$status === 'home_data'?'s6 m4 l2':'s6 m4 l3'?> j-padding j-section j-display-container j-clickable j-round'>
        <div class='j-color4 j-card-4 j-display-container j-text-color4 j-round'style="height:150px;background-image:url('<?=file_location('media_url',get_media('category',$id))?>');background-size:cover;">
         <div class='j-display-bottommiddle j-round'style='width:100%;background-color:rgba(0,0,0,0.7);min-height:30px;'>
          <center><div class='j-medium'><b><?=ucwords($category)?></b></div></center>
         </div>
        </div>
       </div>
      </a>
      <?php
    }elseif($status === 'product_page'){
     $or = multiple_content_data('product_table','p_id',$category,'p_category',"AND p_status = 'available' ORDER BY p_id DESC LIMIT 12");
     if($or !== false){
      $c_id = content_data('category_table','c_id',$category,'c_category');
      ?>
      <br>
      <div class='j-home-padding'style='margin:0px;margin-bottom:9px;'>
       <div class='j-color6'>
        <div class='j-large j-color5 j-text-color4 j-padding'>
         <b style='font-size:21px;'><?=ucwords($category)?></b>
         <a href="<?=file_location('home_url',"category/product/{$category}/")?>"class='j-medium j-right j-text-color1 j-padding'><span class=''><b>SEE ALL &#10095</b></span></a><span class='j-clearfix'></span>
        </div>
        <div id='product_page_<?=$c_id?>'><center><br><br><span class='j-text-color1 j-spinner-border j-spinner-border j-large'></span> <br><br></center></div>
       </div>
      </div>
      <script>$(document).ready(function(){$.ajax({type:'GET',url:dar+'get/gppd/'+<?=$c_id?>+'/',cache:false}).done(function(s){$("#product_page_<?=$c_id?>").html(s);})})</script>
      <?php
     }
    }
   }
  }
}
//function get category ends
//PRODUCT FUNCTION ENDS
?>