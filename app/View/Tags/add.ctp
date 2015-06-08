<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('List Tags'), array('action' => 'index')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
	));
?>
</div>
<div class="tags form">
<?php echo $this->Form->create('Tag'); ?>
	<fieldset>
		<legend><?php echo __('Add Tag'); ?></legend>
	<?php
		echo $this->Form->input('name', array());
		echo $this->Form->input('slug', array());
		echo $this->Form->input('weight', array());
		echo $this->Form->input('Post',array('class'=>'chosen-select'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
