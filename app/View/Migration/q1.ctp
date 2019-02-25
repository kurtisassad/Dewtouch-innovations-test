<div class="row-fluid">

	<p>Sample file to migrate <?php echo $this->Html->link('<i class="icon-share
"></i> xlsx file', '/files/migration_sample_1.xlsx', array('escape' => false)); ?>.</p>
	<hr />

	<div class="alert">
		<h3>Import Form</h3>
	</div>
  <?php
  echo $this->Form->create('FileUpload', array('type' => 'file'));
  echo $this->Form->input('file', array('label' => 'File Upload', 'type' => 'file'));
  echo $this->Form->submit('Upload', array('class' => 'btn btn-primary'));
  echo $this->Form->end();
  ?>

	<hr />

	<div class="alert alert-success">
		<h3>Data Imported</h3>
	</div>
</div>
