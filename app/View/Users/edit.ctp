<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))),
		$this->Html->link(__('List Users'), array('action' => 'index')),
		$this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')),
		$this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')),
		$this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')),
		$this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
	));
?>
</div>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id', array());
		echo $this->Form->input('group_id', array('class'=>'chosen-select',));
		echo $this->Form->input('active', array());
		echo $this->Form->input('first_name', array());
		echo $this->Form->input('last_name', array());
		echo $this->Form->input('email', array());
		echo $this->Form->input('password', array());
		echo $this->Form->input('phone', array());
		echo $this->Form->input('address', array());
		echo $this->Form->input('city', array());
		echo $this->Form->input('state', array());
		echo $this->Form->input('zip', array('class'=>'chosen-select',));
		echo $this->Form->input('web', array('class'=>'chosen-select',));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
