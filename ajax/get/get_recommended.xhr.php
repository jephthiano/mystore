<?php
if(isset($_GET['i']) && isset($_GET['p'])){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
	
    // validating and sanitizing val
	$va = test_input(($_GET['i']));
    
	// validating and sanitizing type
	$ty = ($_GET['p']);
	if(empty($ty)){$error[] = "type";}else{$type = test_input($ty);}
    
    if(empty($error)){
        $total = get_numrow('product_table','p_status','available',"return",'no round');
        if($type === 'products'){
            $val = $va;
            $or = multiple_content_data('product_table','p_id','available','p_status',"AND p_category != '{$val}' ORDER BY RAND() LIMIT 0,12");
        }elseif($type === 'others'){
            $or = multiple_content_data('product_table','p_id','available','p_status',"ORDER BY RAND() LIMIT 0,12");
        }elseif($type === 'product_details'){
            $id = $va;
            $product_name = content_data('product_table','p_name',$id,'p_id');
            $product_category = content_data('product_table','p_category',$id,'p_id');
            $or = multiple_content_data('product_table','p_id','available','p_status',"AND p_name != '{$product_name}' AND p_category = '{$product_category}' ORDER BY RAND() LIMIT 0,12");
            if($or !== false){$total = count($or);}else{$total = 0;}
        }
        if($or !== false){
            if($total > 12){?><a href="<?=file_location('home_url','category/product/all/')?>"class='j-right j-text-color1 j-padding'><span class=''><b>SEE MORE &#10095</b></span></a><span class='j-clearfix'></span><?php }
            ?>
            <div class='j-vertical-scroll'>
                <?php
                foreach($or AS $id){show_product($id,'horizontal');}
                if($type === 'product_details' && $total < 12){
                    $rem = (12-$total);
                    $or = multiple_content_data('product_table','p_id','available','p_status',"AND p_category != '{$product_category}' ORDER BY RAND() LIMIT 0,{$rem}");
                    foreach($or AS $id){show_product($id,'horizontal');}
                }
                ?>
            </div>
            <?php
        }else{
            ?><center><br><div class='j-text-color7'>No recommendation at the moment</div><br></center><?php
        }
    }
}
?>