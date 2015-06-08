<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('List Groups'), array('action' => 'index')),
		$this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')),
		$this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')),
	));
?>
</div>
<div class="groups form">
<?php echo $this->Form->create('Group'); ?>
	<fieldset>
		<legend><?php echo __('Add Group'); ?></legend>
	<?php
		echo $this->Form->input('name', array());
		echo $this->Form->input('description', array());
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
