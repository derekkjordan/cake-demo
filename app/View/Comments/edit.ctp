<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Comment.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Comment.id'))),
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
		<legend><?php echo __('Edit Comment'); ?></legend>
	<?php
		echo $this->Form->input('id', array());
		echo $this->Form->input('post_id', array('class'=>'chosen-select',));
		echo $this->Form->input('title', array());
		echo $this->Form->input('user_id', array('class'=>'chosen-select',));
		echo $this->Form->input('comment', array());
		echo $this->Form->input('status', array());
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
