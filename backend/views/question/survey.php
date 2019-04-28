<?php
use yii\helpers\Html;

$this->title = '';


?>

<div class="container-fluid">
  <div class="content text-center">
  <?php 
	foreach($answers as $key=>$answer) {
		$order = $key + 1;
	?>
  <div class="row">
  	<div class="col-xs-12">
  	<?= $order.'、'.$answer['title']?>
  	</div>
  </div>
  <?php if($answer['type'] == 1) {?>
  <div class="row">
  	<div class="col-xs-12">
  		<?php 
  			$options = json_decode($answer['options'],true);
  			foreach( $options as $option) {
  		?>
		  <label>
    		<input type="radio" name="option_<?= $key+1?>" id="optionsRadios1" value="<?=$option['desc']?>">
    		<?=$option['desc']?>
  		</label>
  		<?php 
  			} 
  		?>
  	</div>
  </div>
  <?php }?>
	<?php 
		} 
	?>
	</div>
</div>