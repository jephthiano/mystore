<?php
//ORDER FUNCTION STARTS
//function track item starts
function track_item($order_id,$type='user'){
  $or_id = content_data('order_table','or_id',$order_id,'or_order_id');
  $delivery_method = content_data('order_table','or_delivery_method',$or_id,'or_id');
  $or_status = content_data('order_table','or_status',$order_id,'or_order_id');
  if($or_status === 'failed'){
    ?>
    <div>
      <span class='j-circle j-color7'style='margin-right:12px;padding:5px 8px;'><i class='<?=icon('times')?>'></i></span>
      <span class='j-text-color4 j-color7 j-padding-small j-round j-btn j-small'>Order Failed</span>
      <div class='j-bolder j-text-color7'style='line-height:35px;margin-left:45px;'>
        <?=showdate(content_data('order_history_table','oh_regdatetime',$or_id,'or_id',"AND oh_status = '{$or_status}'"),'short')?>
        <?php tracking_message($or_status);?>
      </div>
    </div>
    <?php
  }else{
    $or = multiple_content_data('order_history_table','oh_id',$or_id,'or_id'); //get the history in array and foreach it
    if($or !== false){
      foreach($or AS $id){
        $status = content_data('order_history_table','oh_status',$id,'oh_id');
        ?>
        <div style=''>
          <?php
          //stages of each order hostory
          if($status === 'cancelled' || $status === 'failed delivery' || $status === 'returned'){
            ?>
            <span class=''style='margin-right:9px;position:relative;top:5px;'>
              <i class="j-xlarge j-text-color5 <?=icon('circle');?>"></i>
              <i class="j-small j-text-color4 <?=icon('circle');?>"style='position:absolute;right:10px;bottom:6px;'></i>
            </span>
            <span class='j-text-color4 j-color7 j-padding-small j-round j-btn j-small'><?=ucwords($status)?></span>
            <?php
          }elseif($status === 'delivered'){
            ?>
            <span class=''style='margin-right:9px;position:relative;top:5px;'>
              <i class="j-xlarge j-text-color5 <?=icon('circle');?>"></i>
              <i class="j-small j-text-color4 <?=icon('circle');?>"style='position:absolute;right:10px;bottom:6px;'></i>
            </span>
            <span class='j-text-color4 j-color2 j-padding-small j-round j-btn j-small'><?=ucwords($status)?></span>
            <?php
          }else{
            ?>
            <span class=''style='margin-right:9px;position:relative;top:5px;'><i class="j-xlarge <?=icon('check-circle');?>"style='color:teal;'></i></span>
            <span class='j-text-color4 j-padding-small j-round j-btn j-small'style='background-color:teal;'><?=ucwords($status)?></span>
            <?php
          }
          //for connecting line
          if($or_status === $status){
            if($status !== 'delivered' && $status !== 'failed delivery' && $status !== 'failed' && $status !== 'cancelled' && $status !== 'returned'){
              $settings = "margin:2px 9px;padding-left:25px;padding-bottom:20px;border-left:dotted 4px gray;";
            }else{
              $settings = "line-height:35px;margin-left:40px;";
            }
          }else{
            $settings = "margin:2px 9px 0px 9px;padding-left:25px;padding-bottom:20px;border-left:solid 4px teal;";
          }
          ?>
          <?php //for date?>
          <div style='<?=$settings?>'>
           <div class='j-bolder j-text-color7'><?=showdate(content_data('order_history_table','oh_regdatetime',$id,'oh_id',"AND oh_status = '{$status}'"),'short')?></div>
           <?php if($or_status === $status){tracking_message($status,$type);}?>
           <?php
           ?>
          </div>
        </div>
        <?php
      }//end of for each
    }
    //for next delivery
    if($or_status === 'order placed'){
      ?>
      <span class='j-circle j-color5 j-small'style='margin-right:12px;padding:5px 7px;'><i class='j-tiny <?=icon('circle')?>'></i></span>
      <span class='j-text-color4 j-color5 j-padding-small j-round j-btn j-small'>Confirmed</span>
      <?php
    }elseif($or_status === 'confirmed'){
      ?>
      <span class='j-circle j-color5 j-small'style='margin-right:12px;padding:5px 7px;'><i class='j-tiny <?=icon('circle')?>'></i></span>
      <span class='j-text-color4 j-color5 j-padding-small j-round j-btn j-small'>Packaging</span>
      <?php
    }elseif($or_status === 'packaging'){
     if($delivery_method === 'pickup'){
      ?>
      <span class='j-circle j-color5 j-small'style='margin-right:12px;padding:5px 7px;'><i class='j-tiny <?=icon('circle')?>'></i></span>
      <span class='j-text-color4 j-color5 j-padding-small j-round j-btn j-small'>Ready for pickup</span>
      <?php
     }else{
      ?>
      <span class='j-circle j-color5 j-small'style='margin-right:12px;padding:5px 7px;'><i class='j-tiny <?=icon('circle')?>'></i></span>
      <span class='j-text-color4 j-color5 j-padding-small j-round j-btn j-small'>In-transit</span>
      <?php
     }
    }elseif($or_status === 'in-transit'){
      ?>
      <span class='j-circle j-color5 j-small'style='margin-right:12px;padding:5px 7px;'><i class='j-tiny <?=icon('circle')?>'></i></span>
      <span class='j-text-color4 j-color5 j-padding-small j-round j-btn j-small'>Delivered</span>
      <?php
    }elseif($or_status === 'ready-for-pickup'){
      ?>
      <span class='j-circle j-color5 j-small'style='margin-right:12px;padding:5px 7px;'><i class='j-tiny <?=icon('circle')?>'></i></span>
      <span class='j-text-color4 j-color5 j-padding-small j-round j-btn j-small'>Delivered</span>
      <?php
    }
  }
}
//track item ends

//track return starts
function track_return($order_id,$type='user'){
  $or_id = content_data('order_table','or_id',$order_id,'or_order_id');
  //$delivery_method = content_data('order_table','or_delivery_method',$or_id,'or_id');
  $rh_status = content_data('return_table','rh_status',$or_id,'or_id');
  $or = multiple_content_data('return_history_table','rhs_id',$or_id,'or_id'); //get the history in array and foreach it
    if($or !== false){
      foreach($or AS $id){
        $status = content_data('return_history_table','rhs_status',$id,'rhs_id');
        ?>
        <div style=''>
          <?php
          //stages of each order hostory
          if($status === 'return rejected' || $status === 'request rejected'){
            ?>
            <span class=''style='margin-right:9px;position:relative;top:5px;'>
              <i class="j-xlarge j-text-color5 <?=icon('circle');?>"></i>
              <i class="j-small j-text-color4 <?=icon('circle');?>"style='position:absolute;right:10px;bottom:6px;'></i>
            </span>
            <span class='j-text-color4 j-color7 j-padding-small j-round j-btn j-small'><?=ucwords($status)?></span>
            <?php
          }elseif($status === 'return approved'){
            ?>
            <span class=''style='margin-right:9px;position:relative;top:5px;'>
              <i class="j-xlarge j-text-color5 <?=icon('circle');?>"></i>
              <i class="j-small j-text-color4 <?=icon('circle');?>"style='position:absolute;right:10px;bottom:6px;'></i>
            </span>
            <span class='j-text-color4 j-color2 j-padding-small j-round j-btn j-small'><?=ucwords($status)?></span>
            <?php
          }else{
            ?>
            <span class=''style='margin-right:9px;position:relative;top:5px;'><i class="j-xlarge <?=icon('check-circle');?>"style='color:teal;'></i></span>
            <span class='j-text-color4 j-padding-small j-round j-btn j-small'style='background-color:teal;'><?=ucwords($status)?></span>
            <?php
          }
          //for connecting line
          if($rh_status === $status){
            if($status !== 'request rejected' && $status !== 'return approved' && $status !== 'return rejected'){
              $settings = "margin:2px 9px;padding-left:25px;padding-bottom:20px;border-left:dotted 4px gray;";
            }else{
              $settings = "line-height:35px;margin-left:40px;";
            }
          }else{
            $settings = "margin:2px 9px 0px 9px;padding-left:25px;padding-bottom:20px;border-left:solid 4px teal;";
          }
          ?>
          <?php //for date?>
          <div style='<?=$settings?>'>
           <div class='j-bolder j-text-color7'><?=showdate(content_data('return_history_table','rhs_regdatetime',$id,'rhs_id',"AND rhs_status = '{$status}'"),'short')?></div>
           <?php if($rh_status === $status){tracking_message($status,$type);}?>
           <?php
           ?>
          </div>
        </div>
        <?php
      }//end of for each
    }
    //for next delivery
    if($rh_status === 'request opened'){
      ?>
      <span class='j-circle j-color5 j-small'style='margin-right:12px;padding:5px 7px;'><i class='j-tiny <?=icon('circle')?>'></i></span>
      <span class='j-text-color4 j-color5 j-padding-small j-round j-btn j-small'>Request approved / rejected</span>
      <?php
    }elseif($rh_status === 'request approved'){
      ?>
      <span class='j-circle j-color5 j-small'style='margin-right:12px;padding:5px 7px;'><i class='j-tiny <?=icon('circle')?>'></i></span>
      <span class='j-text-color4 j-color5 j-padding-small j-round j-btn j-small'>Return approved / rejected</span>
      <?php
    }
}
//track return ends

//notification_subject starts
function notification_subject($type='order placed'){
 if($type === 'order placed'){
  return "Order placed";
 }elseif($type === 'cancelled'){
  return "Order cancelled";
 }elseif($type === 'failed'){
  return "Order failed";
 }elseif($type === 'confirmed'){
  return "Order confirmed";
 }elseif($type === 'packaging'){
  return "Order is being prepared";
 }elseif($type === 'in-transit'){
  return "Order in transit";
 }elseif($type === 'ready-for-pickup'){
  return "Order is ready for pickup";
 }elseif($type === 'delivered'){
  return "Order delivered";
 }elseif($type === 'failed delivery'){
  return "Delivery failed";
 }elseif($type === 'returned'){
  return "Order returned";
 }elseif($type === 'request opened'){
  return "Request opened";
 }elseif($type === 'request approved'){
  return "Request approved";
 }elseif($type === 'request rejected'){
  return "Request rejected";
 }elseif($type === 'return approved'){
  return "Return approved";
 }elseif($type === 'return rejected'){
  return "Return rejected";
 }
}
//notification_subject ends

//notification_message starts
function notification_message($type='order placed'){
 if($type === 'order placed'){
  return "Your order has been successfully placed";
 }elseif($type === 'cancelled'){
  return "Your order has been successfully cancelled";
 }elseif($type === 'failed'){
  return "Your order failed";
 }elseif($type === 'confirmed'){
  return "Your order has been confirmed";
 }elseif($type === 'packaging'){
  return "Your order is being prepared";
 }elseif($type === 'in-transit'){
  return "Your order is in transit and on it way to delivery";
 }elseif($type === 'ready-for-pickup'){
  return "Your order is ready for pickup, you can pick up your item our pickup station";
 }elseif($type === 'delivered'){
  return "Your order has been successfully delivered";
 }elseif($type === 'failed delivery'){
  return "Your order delivery failed";
 }elseif($type === 'returned'){
  return "Returned order has been received";
 }elseif($type === 'request opened'){
  return "Your request to return the item has been received";
 }elseif($type === 'request approved'){
  return "Your request to return the item has been approved";
 }elseif($type === 'request rejected'){
  return "Your request to return the item has been rejected";
 }elseif($type === 'return approved'){
  return "Return of the item has been approved";
 }elseif($type === 'return rejected'){
  return "Return of the item has been rejected";
 }
}
//notification_message ends

//tracking message starts
function tracking_message($status,$type){
 ?><div class='j-text-color3'style='line-height:20px;margin-top:6px;'><?php
  if($status === 'order placed'){
   ?>Order received, waiting for confirmation.<?php
  }elseif($status === 'cancelled'){
   if($type === 'admin'){
    ?>Order has been cancelled<?php
   }else{
    ?>Order has been cancelled. If your order was prepaid, we will process the refund immediately. It may takes few days depending on your bank. You can also contact our customer support.<?php
   }
  }elseif($status === 'failed'){
   if($type === 'admin'){
    ?>Order failed <?php
   }else{
    ?>Order failed. If your order was prepaid and money has been deducted, we will process the refund immediately. It may takes few days depending on your bank. You can also contact our customer support.<?php
   }
  }elseif($status === 'confirmed'){
   ?>Order has been confirmed.<?php
  }elseif($status === 'packaging'){
   ?>Item is being prepared, it will be soon be on it way for delivery.<?php
  }elseif($status === 'in-transit'){
   if($type === 'admin'){
    ?>Item in Transit<?php
   }else{
    ?>Your item is in transit, it is on it way for delivery.<?php
   }
  }elseif($status === 'ready-for-pickup'){
   if($type === 'admin'){
    ?>Item is ready for pickup<?php
   }else{
    ?>Your item is ready for pickup, you can come to our pickup station to collect your item.<?php
   }
  }elseif($status === 'delivered'){
   if($type === 'admin'){
    ?>Item delivered.<?php
   }else{
    ?>Your item has been delivered.<?php
   }
  }elseif($status === 'failed delivery'){
   if($type === 'admin'){
    ?>Failed Delivery<?php
   }else{
    ?>Despite several attempts, our delivery agent has not been able to deliver this item, the item has been cancelled. If your order was prepaid, we will process the refund immediately. It may takes few days depending on your bank. You can also contact our customer support.<?php
   }
  }elseif($status === 'returned'){
   if($type === 'admin'){
    ?>Item has been returned<?php
   }else{
    ?>We've received the item you returned, we will confirm it validity. If your order was prepaid, we will process the refund immediately. It may takes few days depending on your bank. You can also contact our customer support. <?php
   }
  }elseif($status === 'request opened'){
   if($type === 'admin'){
    ?>Return request has been opened<?php
   }else{
    ?>We've received your request to return the item, we will confirm it validity and notify you whether the request will be approved or rejected depending on the reason.<?php
   }
  }elseif($status === 'request approved'){
   if($type === 'admin'){
    ?>Return request has been approved<?php
   }else{
    ?>Your request to return the item has been approved. If the delivery method is door delivery, our delivery agent will contact you on how to receive the item
    within 1-2 business working days but if the delivery method is pickup, you can bring the item to our pick up station within 1-2 business working days.<?php
   }
  }elseif($status === 'request rejected'){
   if($type === 'admin'){
    ?>Return request has been rejected<?php
   }else{
    ?>Your request to return the item has been rejected, you have been sent an email containing the reason why the request has been rejected.<?php
   }
  }elseif($status === 'return approved'){
   if($type === 'admin'){
    ?>Return of the item has been approved<?php
   }else{
    ?>Return of the item has been approved and refund will be process immediately. You will be notified when refund is processed.<?php
   }
  }elseif($status === 'return rejected'){
   if($type === 'admin'){
    ?>Return of the item has been approved<?php
   }else{
    ?>Return of the item has been rejected, you have been sent an email containing the reason why the request has been rejected. If the delivery method is door
    delivery, our delivery agent will contact you on how to return the item within 1-2 business working days but if the delivery method is pickup, you can
    pick up the item to our pick up station within 1-2 business working days.<?php
   }
  }
 ?></div><?php
}
//tracking message ends
//ORDER FUNCTION ENDS
?>