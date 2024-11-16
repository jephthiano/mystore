<?php
if(isset($_GET)){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    ?>
    <?//Top Deal?>
    <div class='j-home-padding'style='margin:15px 0px;'>
        <div class='j-color4'>
            <div class='j-text-color4'style='background-color:teal'><div class='j-padding j-large'><b>Top Brands</b></div></div>
            <div class='j-row'>
                <?php
                //GET THE BRAND
                // creating connection
                require_once(file_location('inc_path','connection.inc.php'));
                @$conn = dbconnect('admin','PDO');
                $sql = "SELECT p_id,COUNT(p_id) as total FROM order_table GROUP BY p_id ORDER BY total ASC LIMIT 12";
                $stmt = $conn->prepare($sql);
                $stmt->bindColumn('p_id',$id);
                $stmt->execute();
                $numRow = $stmt->rowCount();
                $data = [];
                if($numRow > 0){
                    while($stmt->fetch()){$data[] = content_data('product_table','p_brand',$id,'p_id');}
                    $data = array_unique($data);
                    $data = re_key_array($data);
                    $total = count($data);
                    //ECHO THE GOTTEN CATEGORY
                    $brand_data = '';
                    for($i = 0; $i < $total; $i++){
                        show_brand($data[$i],$type='default');
                        if($i == ($total-1)){$brand_data .= "'".$data[$i]."'";}else{$brand_data .= "'".$data[$i]."',";}// dont add , for the last one
                    }
                }else{
                    $total = 0;
                }
                //IF THE CATEGORY IS NOT UP TO 12
                if($total < 12){ // if top brand is not up to 12
                    $rem = (12 - $total);
                    if($total === 0){$brand_data = "'unknown'";}
                    $sql = "SELECT DISTINCT p_brand FROM product_table WHERE p_brand NOT IN ({$brand_data}) ORDER BY RAND() LIMIT 0,{$rem}";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindColumn('p_brand',$brand);
                    $stmt->execute();
                    $numRow = $stmt->rowCount();
                    if($numRow > 0){
                        while($stmt->fetch()){show_brand($brand,$type='default');}
                    }else{
                        if($total === 0){
                            ?><center><br><br><div class='j-text-color3'><b>No top brand available at the moment</b></div></center><br><br><?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>