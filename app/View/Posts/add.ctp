<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('List Posts'), array('action' => 'index')),
		$this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')),
		$this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')),
		$this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')),
		$this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')),
		$this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')),
		$this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')),
		$this->Html->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')),
		$this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')),
	));
?>
</div>
<div class="posts form">
<?php echo $this->Form->create('Post'); ?>
	<fieldset>
		<legend><?php echo __('Add Post'); ?></legend>
	<?php
		echo $this->Form->input('category_id', array('class'=>'chosen-select',));
		echo $this->Form->input('user_id', array('class'=>'chosen-select',));
		echo $this->Form->input('title', array());
		echo $this->Form->input('description', array());
		echo $this->Form->input('body', array());
		echo $this->Form->input('featured', array());
		echo $this->Form->input('published', array());
		echo $this->Form->input('Tag',array('class'=>'chosen-select'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
