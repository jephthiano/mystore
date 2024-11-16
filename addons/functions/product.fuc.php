<?php
//PRODUCT FUNCTION STARTS
//function show product starts
function show_product($id,$type='default',$user='user',$order_id=''){
  // creating connection
  require_once(file_location('inc_path','connection.inc.php'));
  @$conn = dbconnect('admin','PDO');
  $sql = "SELECT p_id,p_name,p_brand,p_category,p_max_order,p_original_price,p_discounted_price,p_color,p_content,p_details,p_status,p_weight
  FROM product_table WHERE p_id = :id ORDER BY p_id DESC LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->bindColumn('p_id',$id);
  $stmt->bindColumn('p_name',$name);
  $stmt->bindColumn('p_brand',$brand);
  $stmt->bindColumn('p_category',$category);
  $stmt->bindColumn('p_max_order',$max_order);
  $stmt->bindColumn('p_original_price',$original_price);
  $stmt->bindColumn('p_discounted_price',$discounted_price);
  $stmt->bindColumn('p_color',$color);
  $stmt->bindColumn('p_content',$content);
  $stmt->bindColumn('p_details',$details);
  $stmt->bindColumn('p_status',$status);
  $stmt->bindColumn('p_weight',$weight);
  $stmt->execute();
  $numRow = $stmt->rowCount();
  if($numRow > 0){		// if a record is found
   while($stmt->fetch()){
    if($type === 'default'){
     $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
     if(is_avail($id)){
      ?>
      <div class='j-col s6 m4 xl2 j-padding-small'>
       <div class='j-color4'>
        <a href="<?=file_location('home_url','product/'.addnum($id))?>">
        <div style='width:100%;height:200px;'class='j-display-container'>
         <img src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:200px;'>
         <?=get_discount($original_price,$discounted_price)?>
        </div>
        <div class='j-color4'style='padding-left:5px;padding-right:5px;'>
         <div style='height:25px;overflow:hidden;'>
          <span class='j-small'style='font-size:16px;padding-bottom:4px;padding-top:4px;'><?=ucfirst(decode_data($name))?></span>
         </div>
         <div style='height:50px;'>
          <span class='j-text-color1 j-large'style='margin-right:9px;'><b><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price)?></b></span><br>
          <span class='j-text-color3 j-small j-strike'style='margin-right:9px;'><b><?=get_json_data('currency_symbol','about_us').' '.money($original_price)?></b></span>
         </div>
         <div style='height:20px;'class='j-small'>
          <span class='j-text-color7'style='margin-right:15px;'><b><?=get_numrow('order_table','or_status','cart','',''," AND p_id = {$id}",'not')?></b> Orders</span>
          <span class='j-text-color7'style=''><i class='<?=icon('star')?>'></i> <b><?=avg_rating($id)?></b></span>
         </div>
        </div>
        </a>
       </div>
      </div>
      <?php
     }
    }elseif($type === 'viewed' || $type === 'recommended'){
     $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
     if(is_avail($id)){
      ?>
      <div class='j-col <?=$type==='viewed'?'s6 m4 l3 xl3':'s6 m4 l3 xl2'?> j-padding-small'>
       <div class='j-color6'>
        <a href="<?=file_location('home_url','product/'.addnum($id))?>">
        <div style='width:100%;height:150px;'class='j-display-container'>
         <img src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:150px;'>
         <?=get_discount($original_price,$discounted_price)?>
        </div>
        <div class='j-color6 j-padding-small'>
         <div style='height:25px;overflow:hidden;'>
          <span class='j-small'style='font-size:16px;padding-bottom:4px;padding-top:4px;'><?=ucfirst(decode_data($name))?></span>
         </div>
         <div>
          <span class='j-text-color3'><b><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price)?></b></span>
         </div>
        </a>
        </div>
       </div>
      </div>
    <?php
     }
    }elseif($type === 'home' || $type === 'home_no_price'){
      $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
     if(is_avail($id)){
      ?>
      <div class='j-col s4 m3 l2 j-padding-small j-color6'style='margin-bottom:5px;margin-top: 5px;'>
       <div class=''>
        <a href="<?=file_location('home_url','product/'.addnum($id))?>">
        <div style='width:100%;height:140px;'class='j-display-container'>
         <img src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:140px;'>
         <?php if($type === 'home'){get_discount($original_price,$discounted_price);}?>
        </div>
        <div class='j-color4 j-padding-small'>
         <div style='height:25px;overflow:hidden;'>
          <span class='j-text-color3 j-small'style='font-size:16px;padding-bottom:4px;padding-top:4px;'><?=ucfirst(decode_data($name))?></span>
         </div>
         <div>
          <?php
          if($type === 'home'){
            ?><span class='j-text-color3'><b><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price)?></b></span><?php
          }
          ?>
         </div>
        </div>
        </a>
       </div>
      </div>
      <?php
      }
    }elseif($type === 'horizontal'){
     $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
     if(is_avail($id)){
      ?>
      <div class='j-padding-small'style='display:inline-block;'>
       <div class='j-color6 j-display-container'style='width:140px;'>
        <a href="<?=file_location('home_url','product/'.addnum($id))?>">
        <div style='width:100%;height:140px;'class=''>
         <img src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:inherit;height:inherit;'class='j-round-top'>
         <?=get_discount($original_price,$discounted_price)?>
        </div>
        <div class='j-color4 j-padding-small'>
         <div style='height:25px;overflow:hidden;'>
          <span class='j-text-color3 j-small'style='font-size:16px;padding-bottom:4px;padding-top:4px;'><?=ucfirst(decode_data($name))?></span>
         </div>
         <div>
          <span class='j-large j-text-color3'><b><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price)?></b></span>
         </div>
        </div>
        </a>
       </div>
      </div>
    <?php
     }
    }elseif($type === 'checkout_side' || $type === 'checkout_main'){
      $order_id = $user;
      $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
     ?>
     <div class='j-row j-round j-text-color7'style='margin-bottom:15px;'>
      <div class='j-col <?=$type==='checkout_side'?'s2 l3':'s2 l1'?>'>
       <img class='j-round-large'src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;<?=$type==='checkout_main'?'height:70px;':'height:70px;'?>'/>
      </div>
      <div class='j-col <?=$type==='checkout_side'?'s10 l9':'s10 l11'?>'style='padding-left:9px;'>
       <div style='height:25px;overflow:hidden;'>
         <span class='j-medium j-text-color3'><?=ucfirst(decode_data($name))?></span>
       </div>
        <div>
         <span style='margin-right:20px'><span>Quantity: </span> <span class='j-bolder'><?=content_data('order_table','or_quantity',$order_id,'or_id','','null')?>x</span></span>
         <span style='margin-right:20px'><span>Color: </span> <span class='j-bolder'><?=content_data('order_table','or_color',$order_id,'or_id','','null')?></span></span>
         <span >Price: </span><span class='j-bolder'><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price)?></span>
        </div>
        <div class='j-text-color1'>
        <span>Subtotal: </span><span class='j-bolder'><?=get_json_data('currency_symbol','about_us').' '.money(content_data('order_table','or_amount',$order_id,'or_id'))?></span>
        </div>
      </div>
     </div>
     <?php
    }elseif($type === 'cart'){
      $or_id = $user;
      $or_color = content_data('order_table','or_color',$or_id,'or_id');
      $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
     ?>
     <?php //for large and xlarge?>
     <div class='j-color4 j-row j-hide-small j-hide-medium'style='margin:8px 0px;'>
      <div class='j-col l4 j-padding'style='border-right:solid 5px #f2f2f2;'>
       <div class='j-row'>
        <a <?=is_avail($id)?"href='".file_location('home_url','product/'.addnum($id))."'":"";?>>
        <div class='j-col l4 j-padding-small'>
         <div class='j-display-container <?=is_avail($id)?'':'j-opacity';?>'>
          <img src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:50px;'/>
          <?=out_of_stock($id);?>
         </div>
        </div>
        </a>
        <div class='j-col l8 j-padding-small j-wrap'>
         <a <?=is_avail($id)?"href='".file_location('home_url','product/'.addnum($id))."'":"class='j-text-color5'";?>>
         <div style='height:25px;overflow:hidden;'>
          <span class='j-small'style='font-size:16px;padding-bottom:4px;padding-top:4px;'><?=ucfirst(decode_data($name))?></span>
         </div>
         <span class='j-small j-text-color7 j-bolder'>(<?=$or_color?>)</span>
         </a>
         <div class=''>
          <span class='j-right j-large j-text-color1 j-clickable j-round j-bolder'onclick="$('#remove_item<?=$or_id?>').fadeIn('slow');">
          <i class="<?=icon('trash')?>"style='margin-right:5px;'></i>
          </span>
          <span class='clearfix'></span>
         </div>
        </div>
       </div>
      </div>
      <div class='j-col l2 j-padding j-xlarge j-center'style='border-right:solid 5px #f2f2f2;'>
       <span style='position:relative;top:15px;'>
        <?php
        if(is_avail($id)){
          ?><span class=''style='width:100%;'id='crt_btn<?=$or_color.$id?>'><?php add_to_cart_btn($id,$type,$or_color);?></span><?php
        }else{
          ?><div class='j-large j-padding j-round j-center j-color5'style='width:100%;''>Out Of Stock</div><?php
        }
        ?>
        </span>
      </div>
      <div class='j-col l3 j-padding j-large <?=is_avail($id)?'j-text-color3':'j-text-color5 j-hide';?> j-center'style='border-right:solid 5px #f2f2f2;'>
       <span style='position:relative;top:15px;'>
       <b><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price)?></b>
       </span>
      </div>
      <div class='j-col l3 j-padding j-large <?=is_avail($id)?'j-text-color3':'j-text-color5 j-hide';?> j-center'style='border-right:solid 5px #f2f2f2;'>
       <span style='position:relative;top:15px;'>
       <b><?=get_json_data('currency_symbol','about_us').' '.money(content_data('order_table','or_amount',$or_id,'or_id'))?></b>
       </span>
      </div>
     </div>
     <?php //for small and medium?>
     <div class='j-color4 j-row j-hide-large j-hide-xlarge'style='margin:8px 8px;'>
        <a href="<?=file_location('home_url','product/'.addnum($id))?>">
        <div class='j-col s4 j-padding-small'>
         <a <?=is_avail($id)?"href='".file_location('home_url','product/'.addnum($id))."'":"";?>>
         <div class='j-display-container <?=is_avail($id)?'':'j-opacity';?>'>
         <img src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:80px;'/>
         <?=out_of_stock($id);?>
         </div>
         </a>
        </div>
        </a>
        <div class='j-col s8 j-padding-small j-wrap'>
         <div style='height:80px;'>
          <a <?=is_avail($id)?"href='".file_location('home_url','product/'.addnum($id))."'":"class='j-text-color5'";?>style='margin-bottom: 9px;'>
          <div class='j-small'><?=text_length(ucwords(decode_data($name)),50,'dots')?></div>
          <span class='j-small j-text-color7 j-bolder'>(<?=$or_color?>)</span>
          </a>
          <div class='<?=is_avail($id)?'':'j-hide';?>'>
           <span class='j-large j-text-color1 j-bolder'style='border-right:solid 5px #f2f2f2;'><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price)?></span>
           <span class='j-large j-text-color3'style='border-right:solid 5px #f2f2f2;'><?=get_json_data('currency_symbol','about_us').' '.money(content_data('order_table','or_amount',$or_id,'or_id'))?></span>
          </div>
         </div>
        </div>
        <div class='j-row'>
        <div class='j-col s6 m8 j-padding'>
          <span class='j-text-color4 j-color1 j-clickable j-round j-btn'onclick="$('#remove_item<?=$or_id?>').fadeIn('slow');">Remove</span>
         </div>
        <div class='j-col s6 m4 j-right j-padding'>
         <?php
         if(is_avail($id)){
          ?><span style='width:50%;'id='crt_btn<?=$or_color.$id?>'><?php add_to_cart_btn($id,$type,$or_color);?></span><?php
          }else{
           ?><div class='j-large j-padding j-center j-color5 j-round'style='width:100%;''>Out Of Stock</div><?php
          }
        ?>
        </div>
        </div>
     </div>
     <?php user_modal('remove_item',$or_id);?>
     <?php
    }elseif($type === 'order'){
     $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
     $or_status = content_data('order_table','or_status',$order_id,'or_id');
     $placed_time = content_data('order_table','or_regdatetime',$order_id,'or_id');
     if($user === 'admin'){
      $url = file_location('admin_url','order/preview_orders/');
     }else{
      $url = file_location('home_url','order/order_details/');
     }
     ?>
    <div class=''style='margin:15px 0px;'>
     <div class='j-border j-border-gray j-round'>
      <a href="<?=$url.content_data('order_table','or_token',$order_id,'or_id')?>">
       <div class='j-row'>
        <div class='j-col s4 m2 j-padding'>
         <img class='j-round'src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:80px;'>
        </div>
        <div class='j-col s8 m10 j-padding'style='line-height:27px;'>
         <div class=''style='font-size:16px;padding-bottom:4px;padding-top:4px;'><?=ucfirst(decode_data($name))?></div>
         <div class=''><span class='j-text-color5'>Order Id:</span> <?=content_data('order_table','or_order_id',$order_id,'or_id')?></div>
         <div class=''>
          <span>
            <span style='margin-right: 20px;'><span class='j-text-color5'>Quantity:</span> <?=content_data('order_table','or_quantity',$order_id,'or_id')?></span>
            <span'><span class='j-text-color5'>Color:</span> <?=content_data('order_table','or_color',$order_id,'or_id')?></span>
          </span>
         </div>
         <div class='<?php if($or_status === 'order placed' || $or_status === 'confirmed' || $or_status === 'packaging' || $or_status === 'in-transit'|| $or_status === 'delivered'){echo 'j-color2';}else{echo 'j-color1';}?> j-padding-small j-btn j-round'><?=ucfirst($or_status)?></div>
         <div class='j-text-color7 '>On <?=showdate($placed_time,'short').'  '.show_time($placed_time)?></div>
        </div>
       </div>
      </a>
     </div>
    </div>
    <?php
    }elseif($type === 'wishlist'){
     $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
     ?>
    <div class=''style='margin:15px 0px;'>
     <div class='j-border j-border-gray j-round'>
      <div class='j-row'>
       <div class='j-col s4 m2 j-padding-small'>
        <a <?=is_avail($id)?"href='".file_location('home_url','product/'.addnum($id))."'":"";?>>
        <div class='j-display-container'>
         <img class='j-round'src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:80px;'>
         <?=out_of_stock($id);?>
        </div>
        </a>
       </div>
       <div class='j-col s8 m8 j-padding-small j-large'>
        <a <?=is_avail($id)?"href='".file_location('home_url','product/'.addnum($id))."'":"";?>>
        <div style='height:25px;overflow:hidden;'>
          <span class=''style='font-size:16px;padding-bottom:4px;padding-top:4px;'><?=ucfirst(decode_data($name))?></span>
        </div>
        </a>
        <div class='j-bolder '><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price,'new')?></div>
        <span class='j-strike'><?=get_json_data('currency_symbol','about_us').' '.money($original_price,'new')?></span>
        <span><?=get_discount($original_price,$discounted_price,'no')?></span>
       </div>
       <div class='j-col m2 j-padding j-hide-small'style='position:relative;'>
        <?php
        if(is_avail($id)){
         ?><a href='<?=file_location('home_url','product/'.addnum($id).'/')?>'class='j-color1 j-padding j-small j-round j-clickable j-bolder j-btn'onclick=""style='position:absolute;right:8px;'>Buy Now</a><?php
        }
        ?>
        <div class='j-btn j-bolder j-small j-color1 j-round'style='position:absolute;top:55px;right:8px;'>
          <span onclick="arw(<?=$id?>,'wishlist');"><i class="<?=icon('trash')?>"style='margin-right:5px;'></i>Remove</span>
        </div>
       </div>
      </div>
      <div class='j-padding j-hide-medium j-hide-large j-hide-xlarge''>
       <hr>
       <?php
       if(is_avail($id)){
        ?><a href='<?=file_location('home_url','product/'.addnum($id).'/')?>'class='j-color1 j-padding j-round j-clickable j-left j-bolder j-small j-btn'onclick="">Buy Now</a><?php
       }
       ?>
       <div class='j-btn j-bolder j-color1 j-round j-right j-small '><span onclick="arw(<?=$id?>,'wishlist');"><i class="<?=icon('trash')?>"style='margin-right:5px;'></i>Remove</span></div>
       <br class='j-clearfix'>
      </div>
     </div>
    </div>
    <?php
    }elseif($type === 'inbox'){
      global $u_id;
      $order_id = $user;
      $pm_id = content_data('product_media_table','pm_id',$id,'p_id');
      $n_id = content_data('notification_table','n_id',$order_id,'or_id','ORDER BY n_id DESC');
      ?>
     <a href='<?=file_location('home_url','inbox/message/'.addnum($order_id))?>'>
     <div class='j-padding'>
      <div class='j-row j-border-color7'style='border-bottom:solid 1px;'>
       <div class='j-col s3 j-padding'>
        <img class='j-round'src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:80px;'>
       </div>
       <div class='j-col s9 j-padding'>
        <div>
         <span class='j-bolder'><?=ucwords(content_data('notification_table','n_title',$n_id,'n_id','','null'))?></span>
         <span class='j-bolder j-right j-text-color5'><?=show_date(content_data('notification_table','n_regdatetime',$n_id,'n_id'))?></span>
        </div>
        <div>
         <span><?=text_length(ucfirst(content_data('notification_table','n_message',$n_id,'n_id','','null')),70,'dots')?></span>
         <?php
         $unread = get_numrow('notification_table','u_id',$u_id,"return",'round',"AND or_id = {$order_id} AND n_status != 'read'");
         if($unread > 0){?><span class='j-circle j-color1 j-right' style='padding:6px 12px;'><?=$unread?></span><?php }
         ?>
        </div>
       </div>
      </div>
     </div>
     </a>
     <?php
    }elseif($type === 'pending review'){
      $order_id = $user;
      $pm_id = content_data('product_media_table','pm_id',$id,'p_id');
      $placed_time = content_data('order_table','or_regdatetime',$order_id,'or_order_id');
      ?>
     <div class='j-border j-border-color5 j-round j-margin'style='padding: 8px 8px'>
      <div class='j-row'>
       <div class='j-col m9'>
        <div class='j-row'>
         <a <?=is_avail($id)?"href='".file_location('home_url','product/'.addnum($id))."'":"";?>>
         <div class='j-col s4 m2 j-display-container j-clickable'>
          <img class='j-round'src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:80px;'>
          <?=out_of_stock($id);?>
         </div>
         </a>
         <div class='j-col s8 m10'style='line-height:27px;padding-left:16px;'>
          <a <?=is_avail($id)?"href='".file_location('home_url','product/'.addnum($id))."'":"";?>>
          <div class='j-bolder j-clickable'style='font-size:16px;padding-bottom:4px;'><?=ucfirst(decode_data($name))?></div>
          </a>
          <div class=''><span class='j-text-color5 j-bold'>Order Id:</span> <?=$order_id?></div>
          <div class='j-text-color2 j-bold'>Delivered on <?=showdate($placed_time,'short').'  '.show_time($placed_time)?></div>
         </div>
        </div>
       </div>
       <div class='j-col m3'>
        <hr class='j-hide-xlarge j-hide-large j-hide-medium'>
        <a href='<?=file_location('home_url','review/add_review/'.addnum(content_data('order_table','or_id',$order_id,'or_order_id')))?>'>
        <div class='j-text-color1 j-center j-padding j-bolder j-clickable'>LEAVE FEEDBACK</div>
        </a>
       </div>
      </div>
     </div>
    <?php
    }elseif($type === 'order_details'){
      $pm_id = content_data('product_media_table','pm_id',$id,'p_id','','null');
      $or_status = content_data('order_table','or_status',$order_id,'or_id');
      $placed_time = content_data('order_table','or_regdatetime',$order_id,'or_id');
     if($user === 'admin'){$url = file_location('admin_url','product/preview_product/'.addnum($id));}else{$url = file_location('home_url','product/'.addnum($id));}
     ?>
     <div class='j-border-2 j-border-color5 j-round j-margin'style='padding: 16px 16px'>
      <div class='j-row'>
       <div class='j-col m9'>
        <div class='<?php if($or_status === 'order placed' || $or_status === 'confirmed' || $or_status === 'packaging' || $or_status === 'in-transit'|| $or_status === 'ready-for-pickup' || $or_status === 'delivered'){echo 'j-color2';}else{echo 'j-color1';}?> j-text-color4 j-btn j-round j-small'>
         <?=strtoupper($or_status)?>
        </div>
        <div style='margin:5px 0px'>
         <?php if($user === 'user'){ ?>
          <div class='j-text-color7 j-bolder'>On <?=showdate($placed_time,'short').'  '.show_time($placed_time)?></div>
          <?php } ?>
         <div class=''><span class='j-text-color5'>Order Id:</span> <?=content_data('order_table','or_order_id',$order_id,'or_id')?></div>
        </div>
        <a <?=is_avail($id)?"href='".$url."'":"";?>>
         <div class='j-row'>
          <div class='j-col s4 m2 j-display-container'>
           <img class='j-round'src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:80px;'>
           <?=out_of_stock($id);?>
          </div>
          <div class='j-col s8 m10'style='padding:0px 9px;'>
           <div class='j-large'style='font-size:16px;'><?=ucwords(decode_data($name))?></div>
           <div class=''>
            <span>
              <span style='margin-right: 20px;'><span class='j-text-color5'>Quantity:</span> <?=content_data('order_table','or_quantity',$order_id,'or_id')?></span>
              <span><span class='j-text-color5'>Color:</span> <?=content_data('order_table','or_color',$order_id,'or_id')?></span>
            </span>
           </div>
            <?php if($user === 'user'){?>
             <div class='j-bolder'>
              <span style='margin-right:8px;'><?=get_json_data('currency_symbol','about_us').' '.(content_data('order_table','or_amount',$order_id,'or_id')/content_data('order_table','or_quantity',$order_id,'or_id'))?> </span>
              <span class='j-strike j-text-color5'><?=get_json_data('currency_symbol','about_us').' '.$original_price?></span>
             </div>
             <?php } ?>
          </div>
         </div>
         <div style='margin-bottom:9px;margin-top:5px'>
          <div class='j-bolder'>
            <?php
            $amount = content_data('order_table','or_amount',$order_id,'or_id','','null');
            $delivery_fee = content_data('order_table','or_delivery_fee',$order_id,'or_id','','null');
            ?>
            <span style='margin-right:8px;'>Item Total Fee: </span>
            <span class='j-text-color5'><?=get_json_data('currency_symbol','about_us').' '.$amount?></span>
           </div>
           <div class='j-bolder'>
            <span style='margin-right:8px;'><?=ucwords(content_data('order_table','or_delivery_method',$order_id,'or_id'))?> Fee: </span>
            <span class='j-text-color5'><?=get_json_data('currency_symbol','about_us').' '.$delivery_fee?></span>
           </div>
           <div class='j-bolder'>
            <span style='margin-right:8px;'>Total Fee: </span>
            <span class='j-text-color5'><?=get_json_data('currency_symbol','about_us').' '.add_total($amount,$delivery_fee)?></span>
           </div>
         </div>
        </a>
       </div>
       <div class='j-col m3'>
        <?php
        if($user === 'admin'){
         ?>
         <a href="<?=file_location('admin_url','order/preview_order/'.content_data('order_table','or_order_id',$order_id,'or_id'))?>"style='margin-bottom:5px;'>
           <div class='j-color1 j-padding j-center j-round j-small j-bolder'>SEE ORDER DETAILS</div>
          </a>
         <?php
         }else{
         if($or_status === 'order placed' || $or_status === 'confirmed' || $or_status === 'packaging' || $or_status === 'in-transit' || $or_status === 'ready-for-pickup' ){
          if($or_status === 'confirmed'){
           ?><div class='j-color1 j-padding j-center j-round j-small j-clickable'onclick="$('#cancel_order<?=$order_id?>').fadeIn('slow');"style='margin-bottom:5px;'>CANCEL ITEM</div><?php
           user_modal('cancel_order',$order_id);
          }
          ?>
          <a href="<?=file_location('home_url','order/track/'.content_data('order_table','or_order_id',$order_id,'or_id'))?>"style='margin-bottom:5px;'>
           <div class='j-color1 j-padding j-center j-round j-small'>TRACK ITEM</div>
          </a>
          <?php
         }else{
          if(is_avail($id)){
          ?><a href='<?=file_location('home_url','product/'.addnum($id).'/')?>'onclick=""><div style='margin-bottom:12px;'class='j-color1 j-padding j-center j-round j-clickable j-small'>BUY NOW</div></a><?php
          }
          ?>
          <a href="<?=file_location('home_url','order/track/'.content_data('order_table','or_order_id',$order_id,'or_id'))?>">
           <div class='j-color4 j-text-color1 j-card-2 j-padding j-center j-round j-small'style='margin-bottom:12px;'>SEE ITEM ORDER HISTORY</div>
          </a>
          <?php
          if($or_status === 'delivered' || $or_status === 'returned'){ 
            if(content_data('review_table','r_id',$order_id,'or_id') === false){// if product id delivered and no feedback
              ?>
              <a href="<?=file_location('home_url','review/add_review/'.addnum($order_id))?>">
              <div class='j-color1 j-padding j-center j-round j-small' style='margin-bottom:12px;'>LEAVE FEEDBACK</div>
              </a>
              <?php
            }
            if(content_data('return_table','rh_id',$order_id,'or_id') === false){// if product id delivered and no request for return has been applied
              // if days diff is not up to 7 days
              $delivered_day = content_data('order_history_table','oh_regdatetime',$order_id,'or_id',"AND oh_status = 'delivered'");
              $days = get_json_data('return_days','about_us');
              $no_days = (60*60*24*$days);
              //if($no_days > strtotime(date("Y-m-d"))){
              if(time_validity($no_days,$delivered_day) === false){
                ?>
                <a href="<?=file_location('home_url','return/'.addnum($order_id).'/')?>">
                <div class='j-color1 j-padding j-center j-round j-small'>REQUEST FOR RETURN</div>
                </a>
                <?php
              }
            }else{
              ?>
              <a href="<?=file_location('home_url','return/track/'.content_data('order_table','or_order_id',$order_id,'or_id').'/')?>">
              <div class='j-color1 j-padding j-center j-round j-small'>SEE RETURN STATUS</div>
              </a>
              <?php
            }
            
          }
         }
        }
        ?>
       </div>
      </div>
     </div>
     <?php
    }elseif($type === 'product_details'){
     ?>
     <div class='j-color4 j-padding-small'>
      <div class='j-row'>
       <div class='j-col l5 j-padding-small'>
        <?php $product_image = 'customer_preview'; require_once(file_location('inc_path','product_image.inc.php')); // product image?>
       </div>
       <div class='j-col l7 j-padding-small'style='line-height:40px;'>
        <div style='line-height:28px;'>
         <span class='j-large j-hide-medium j-hide-large j-hide-xlarge'><?=ucwords(decode_data($name))?></span>
         <span class='j-xlarge j-hide-small'><?=ucwords(decode_data($name))?></span>
         <?php
         if(is_avail($id)){ //if product is available show wishlist
          ?>
          <span class='j-right j-text-color1 j-xlarge j-clickable'id='whl<?=$id?>'onclick="arw(<?=$id?>,'product_details');">
           <?=check_wishlist_content($id,'icon')?>
          </span>
          <span class='j-clearfix'></span>
          <?php
         }
         ?>
        </div>
        <?php
        $total_review = get_numrow('review_table','p_id',$id,"return");
        $total_order = get_numrow('order_table','p_id',$id,"return",'round',"AND or_status != 'cart'");
        if($total_review > 0 || $total_order > 0){
         ?>
         <div>
          <?php
          if($total_review > 0){?><a href='<?=file_location('home_url','review/product_review/'.addnum($id).'/all/')?>'><?php get_rating($id,'product')?></a><?php }
          if($total_order > 0){?><span style='margin-left:5px;'> Order<?=$total_order>0?'s':''?> <b>(<?=$total_order?>)</b></span><?php }
          ?>
         </div><hr>
         <?php
        }
        ?>
        <?php
        $first_color = get_color_first_key($id);
         if(is_avail($id)){ //if product is available show price and others
          ?>
          <div>
           <div>
            <span style='margin-right: 20px;'><b><?=$max_order?></b> max order</span>
            <span><b><span id="p_avail"><?=get_color_value($id,$first_color)?></span></b> available</span>
           </div>
           <span class='j-xlarge j-text-color1'style='margin-right: 20px;'><b><?=get_json_data('currency_symbol','about_us').' '.money($discounted_price)?></b></span>
           <span>
            <b class='j-text-color3 j-large j-strike'style='margin-right:9px;'><?=get_json_data('currency_symbol','about_us').' '.money($original_price)?></b>
            <?=get_discount($original_price,$discounted_price,'no angle')?>
           </span>
           <?php //call to order and add to shopping cart ?>
           <div class='j-row'>
            <a href='tel:<?=get_json_data('phonenumber','about_us')?>'>
            <div class='j-col s6'>
             <div class='j-color1 j-round'style='width:96%;'>
             <span class=' j-padding j-round j-clickable'style='width:100%;'>
              <i class='<?=icon('phone')?> fa-flip-horizontal'></i> <b>Call To Order</b>
             </span>
             </div>
            </div>
            </a>
            <div class='j-col s6'>
             <div class='j-text-color1'style='width:96%;'id='crt_btn<?=$id?>'>
             <?php add_to_cart_btn($id,$type,$first_color);?>
             </div>
            </div>
           </div>
          </div>
          <?php// color?>
          <div>
            <div>
              <span class='j-text-color5'style='padding-right: 5px;'>Color: </span>
              <span class='j-bolder j-text-color7'id='colorName<?=$id?>'><?=strtoupper($first_color)?></span>
            </div>
            <div id='colDiv<?=$id?>'>
              <?php get_color($id,$type);?>
            </div>
          </div>
          <?php
         }else{
          ?>
          <br>
          <div class='j-border-2 j-border-color1 j-padding j-text-color1 j-large'>
           <span style='margin-right:12px;'><i class="j-text-color1 j-large <?=icon('exclamation-triangle')?>"></i></span><span>This item is not available</span>
          </div>
          <?php
         }
         ?>
       </div>
      </div>
     </div>
     <div class='j-color4 j-padding'style='margin-top:5px;'>
      <div style='margin-bottom:15px;'>
        <div class='j-large j-text-color7' style='line-height:28px;'><b>Brand</b></div>
        <span class='j-justify'><?=strtoupper((decode_data($brand)))?></span> |
        <a href="<?=file_location('home_url','brand/'.$brand.'/')?>" class='j-justify j-text-color1 j-clickable'style='line-height:28px;'>See other products from <?=strtoupper((decode_data($brand)))?></a>
      </div>
      <div style='margin-bottom:15px;'>
        <div class='j-large j-text-color7'><b>Product Details</b></div>
        <div class='j-justify'style='line-height:28px;'><?=convert_2_br((decode_data($details)))?></div>
      </div>
      <div style='margin-bottom:15px;'>
        <div class='j-large j-text-color7'><b>Weight</b></div>
        <div class='j-justify'style='line-height:28px;'><?=((decode_data(g_2_kg($weight))))?>Kg</div>
      </div>
      <div style='margin-bottom:15px;'>
        <div class='j-large j-text-color7'><b>Colors</b></div>
        <div class='j-justify'style='line-height:28px;'><?=remove_json_syntax(get_color_keys($id))?></div>
      </div>
      <div style='margin-bottom:15px;'>
        <div class='j-large j-text-color7'><b>What's in the Package</b></div>
        <div class='j-justify'style='line-height:28px;'><?=convert_2_br((decode_data($content)))?></div>
      </div>
     </div>
     <?php
    }
   }// end of while
	}
}
//show product ends

//function is_avail starts
function is_avail($id){
  $status = content_data('product_table','p_status',$id,'p_id');
  if($status === 'available' && (get_total_available($id) > 0)){
    return true;
  }else{
    return false;
  }
}
// function is_avail ends

//function out of stock starts
function out_of_stock($id){
 if(is_avail($id) === false){
  ?><div class='j-color7 j-text-color4 j-bolder j-display-middle j-center'style='width:100%'>Out Of Stock</div><?php
 }
}
//function out of stock ends

//function get discount starts
function get_discount($original,$discount,$type='angle'){
 if($original > $discount && !is_null($original) && is_numeric($original) && is_numeric($discount)){
   $val = round(100-(($discount/$original)*100));
   if($val > 0){
    ?><span class='j-color1 j-padding-small <?=$type === 'angle'?'j-display-topright':''?>'>-<?=$val?>%</span><?php
   }
 }
}
//function get discount ends

//function add to cart button starts
function add_to_cart_btn($id,$type,$color=''){
 $add = " AND p_id = {$id} AND or_color = '$color' AND or_status = 'cart'";
 $token = get_order_token();
 $or_id = content_data('order_table','or_id',$token,'or_token',$add);
 $color_available = get_color_value($id,$color);
 if($color_available > 0){
  if($or_id !== false){
   $quantity = content_data('order_table','or_quantity',$token,'or_token',$add);
   $max_order = content_data('product_table','p_max_order',$id,'p_id');
     ?>
     <div class='j-center j-text-color1 j-color4 j-round'style='width:100%;'>
      <button class='j-left j-color1 j-round-large j-xlarge <?=$quantity < 2 && $type === 'cart'?'j-opacity':""?>'onclick="<?=$quantity < 2 && $type === 'cart'?'':"ac($id,'remove','$type','$color');"?>"style='border:none;padding:0px 15px;'> - </button>
      <span class='j-color4 j-padding-small j-xlarge'style='display:inline;'><?=$quantity?></span>
      <button class='j-right j-color1 j-round-large j-xlarge <?=$quantity >= $max_order || $quantity >= $color_available?'j-opacity':''?>'onclick="<?=$quantity >= $max_order || $quantity >= $color_available?'':"ac($id,'add','$type','$color');"?>"style='border:none;padding:0px 12px;'> + </button>
      <span class='j-clearfix'>
     </div>
    <?php
  }else{
    ?>
    <div class='j-text-color4 j-color1 j-card-4 j-round j-clickable'style='width:100%;padding:<?=$type==='product_details'?'0px':'8px'?> 16px;'onclick="ac(<?=$id?>,'normal','<?=$type?>');">
     <i class='<?=icon('shopping-cart')?>'style='padding-right:5px;'></i><b>Add to Cart</b>
    </div>
    <?php
  }
 }else{
  ?>
  <div class='j-text-color4 j-color1 j-card-4 j-round j-clickable j-opacity'style='width:100%;padding:<?=$type==='product_details'?'0px':'8px'?> 16px;'>
    <i class='<?=icon('shopping-cart')?>'style='padding-right:5px;'></i><b>Add to Cart</b>
  </div>
  <?php
 }
}
//function add to cart button starts

//check wishlist data status starts
function check_wishlist_content($id,$type=''){
 if(isset($_SESSION['user_id'])){global $u_id;}
 // creating connection
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('admin','PDO');
 $sql = "SELECT * FROM wishlist_table WHERE u_id = :u_id AND p_id = :p_id LIMIT 15";
 $stmt = $conn->prepare($sql);
 $stmt->bindParam(':p_id',$id,PDO::PARAM_INT);
 $stmt->bindParam(':u_id',$u_id,PDO::PARAM_INT);
 $stmt->execute();
 $numRow = $stmt->rowCount();
 if($numRow > 0){
  if($type === 'icon'){?><i class='<?=icon('heart','fas')?>'></i><?php }else{return true;}
 }else{
  if($type === 'icon'){?><i class='<?=icon('heart','far')?>'></i><?php }else{return false;}
 }
 closeconnect("stmt",$stmt);
 closeconnect("db",$conn);
}
//check wishlist data status ends

// get cart starts
function get_cart(){
  $token = get_order_token();
  if(content_data('order_table','or_id',$token,'or_token',"AND or_status = 'cart'") !== false){
			?>
			<div class=''>
				<div class='j-row j-text-color3'style='margin:8px 0px;'>
					<div class='j-padding j-bolder j-large'>CART (<?=get_numrow('order_table','or_token',$token,"return",'no round',"AND or_status = 'cart'");?>)</div>
					<div class='j-hide-small j-hide-medium'>
						<div class='j-col s4 j-padding j-bolder j-large'>ITEM</div>
						<div class='j-col s2 j-padding j-bolder j-large j-center'>QUANTITY</div>
						<div class='j-col s3 j-padding j-bolder j-large j-center'>UNIT PRICE</div>
						<div class='j-col s3 j-padding j-bolder j-large j-center'>SUBTOTAL</div>
					</div>
				</div>
				<?php
				//available product
        $or = available_cart_data($token);
				if($or !== false){
					foreach($or AS $or_id){
						$id = content_data('order_table','p_id',$or_id,'or_id','','null');
						show_product($id,'cart',$or_id);
					}
				}
        //unavailable product
        $or = unavailable_cart_data($token);
        if($or !== false){
					foreach($or AS $or_id){
						$id = content_data('order_table','p_id',$or_id,'or_id','','null');
						show_product($id,'cart',$or_id);
					}
				}
				?>
				<div class='j-color6 j-right j-padding j-xlarge'>
					<span style='margin-right:50px;'>Total:</span><span id='ttl'class='j-bolder j-text-color1'>
						<?=get_json_data('currency_symbol','about_us').' '.money(item_sum($token))?>
					</span>
				</div>
				<span class='j-clearfix'></span>
				<div class='j-padding j-right'>Delivery fee not included</div>
				<span class='j-clearfix'></span>
				<div class='j-right j-white j-padding j-hide-small'>
					<b>
					<a href="<?=file_location('home_url','')?>"class='j-btn j-color4 j-text-color1 j-card-4 j-round'style='margin-right:9px;'>CONTINUE SHOPPING</a>
					<a href="<?=file_location('home_url','checkout/')?>"class='j-btn j-color1 j-text-color4 j-card-4 j-round'>PROCEED TO CHECKOUT</a>
					</b>
				</div>
				<span class='j-clearfix'></span><br>
				<div class='j-padding j-white j-hide-medium j-hide-large j-hide-xlarge'>
					<b>
					<a href="<?=file_location('home_url','checkout/')?>"class='j-btn j-color1 j-text-color4 j-round j-small'style='width:100%;margin-bottom:5px;'>PROCEED TO CHECKOUT</a>
					<a href="<?=file_location('home_url','')?>"class='j-btn j-color4 j-text-color1 j-border j-border-color1 j-round j-small'style='width:100%'>CONTINUE SHOPPING</a>
					</b>
				</div>
			</div>
			<?php
		}else{
			?>
			<div class='j-center j-xlarge j-padding j-text-color7'><br>No Product in Cart<br></div>
			<center><a href="<?=file_location('home_url','')?>"class='j-btn j-color1 j-text-color4 j-card-4 j-round-large j-bolder'>CONTINUE SHOPPING</a></center><br>
			<?php
		}
}
// get carts ends
//PRODUCT FUNCTION ENDS
?>