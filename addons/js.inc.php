<script>
<?php
$js = ['general','after_load','message','user','product','order','contact','review','return'];
foreach($js AS $section){
 require_once(file_location('inc_path',"js/$section.js.php"));
}
?>
</script>