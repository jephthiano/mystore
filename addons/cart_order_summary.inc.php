<?php
if($checkout === 'side'){
    ?><b><div class='j-text-color5'>YOUR ORDER</div></b><hr><?php
    if($or !== false){
        foreach($or AS $or_id){
            $id = content_data('order_table','p_id',$or_id,'or_id','','null');
            $or_color = content_data('order_table','or_color',$or_id,'or_id');
            if(get_color_value($id,$or_color) > 0){
                show_product($id,'checkout_side',$or_id);
            }
        }
    }
}elseif($checkout === 'main'){
    if($or !== false){
        foreach($or AS $or_id){
            $id = content_data('order_table','p_id',$or_id,'or_id','','null');
            $or_color = content_data('order_table','or_color',$or_id,'or_id');
            if(get_color_value($id,$or_color) > 0){
                show_product($id,'checkout_main',$or_id);
            }
        }
    }
    ?><hr><?php
}
?>
<div class='j-large tc' id=''></div>
<?php
if($checkout === 'side'){
?><a href="<?=file_location('home_url','cart/')?>"style='width:100%;'class='j-round j-small j-color4 j-text-color1 j-btn j-border j-border-color1'><b>MODIFY CART</b></a><?php
}
?>
