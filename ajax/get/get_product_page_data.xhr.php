<?php
if(isset($_GET['p'])){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    // validating and sanitizing type
	$ty = ($_GET['p']);
	if(empty($ty)){$error[] = "type";}else{$c_id = test_input($ty);}
    
    if(is_numeric($c_id)){
        $category = content_data('category_table','c_category',$c_id,'c_id');
    }else{
        $category = $c_id;
    }
    if(empty($error)){
        $or = multiple_content_data('product_table','p_id',$category,'p_category',"AND p_status = 'available' ORDER BY p_id DESC LIMIT 6");
        if($or !== false){
            ?>
            <div class='j-row'>
                <?php foreach($or AS $id){show_product($id,'default');} ?>
            </div>
            <?php
        }else{
            ?><center><br><div class='j-large j-text-color7'>No product available under this category at the moment</div><br></center><?php
        }
    }
}
?>