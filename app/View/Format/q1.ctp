
<div id="message1">


<?php echo $this->Form->create('Type',array('id'=>'form_type','type'=>'file','class'=>'','method'=>'POST','autocomplete'=>'off','url'=>'save','inputDefaults'=>array(

				'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>

<?php echo __("Hi, please choose a type below:")?>
<br><br>

<?php $options_new = array(
 		'Type1' => __('<span data-html="true" data-toggle="tooltip" data-placement="right" data-id="dialog_1" style="color:blue">Type1</span>'),
		'Type2' => __('<span data-html="true" data-toggle="tooltip" data-placement="right" data-id="dialog_2" style="color:blue">Type2</span>')
		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>

<?php echo $this->Form->end('Save');?>

</div>

<style>
.showDialog:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}

.tooltip > .tooltip-inner {
	background-color: #FFF;
  color: #000;
  border: 1px solid black;
  padding: 3px;
}

</style>

<?php $this->start('script_own')?>
<script>

$(document).ready(function(){

	$("[data-id='dialog_1']").attr('title','<ul><li>Desc 1 .....</li><li>Desc 2...</li></ul>')
	$("[data-id='dialog_2']").attr('title','<ul><li>Description .......</li><li>Description 2</li>')

	$('[data-toggle="tooltip"]').tooltip();
})


</script>
<?php $this->end()?>
