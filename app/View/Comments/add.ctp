<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('List Comments'), array('action' => 'index')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
		$this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')),
		$this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')),
	));
?>
</div>
<div class="comments form">
<?php echo $this->Form->create('Comment'); ?>
	<fieldset>
		<legend><?php echo __('Add Comment'); ?></legend>
	<?php
		echo $this->Form->input('post_id', array('class'=>'chosen-select',));
		echo $this->Form->input('title', array());
		echo $this->Form->input('user_id', array('class'=>'chosen-select',));
		echo $this->Form->input('comment', array());
		echo $this->Form->input('status', array());
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
