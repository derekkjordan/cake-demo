<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('List Categories'), array('action' => 'index')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
	));
?>
</div>
<div class="categories form">
<?php echo $this->Form->create('Category'); ?>
	<fieldset>
		<legend><?php echo __('Add Category'); ?></legend>
	<?php
		echo $this->Form->input('name', array());
		echo $this->Form->input('slug', array());
		echo $this->Form->input('description', array());
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
