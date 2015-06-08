<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])),
		$this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])),
		$this->Html->link(__('List Users'), array('action' => 'index')),
		$this->Html->link(__('New User'), array('action' => 'add')),
		$this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')),
		$this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')),
		$this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')),
		$this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
	));
?>
</div>
<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($user['User']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($user['User']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($user['User']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($user['User']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($user['User']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip'); ?></dt>
		<dd>
			<?php echo h($user['User']['zip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Web'); ?></dt>
		<dd>
			<?php echo h($user['User']['web']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php echo __('Related Comments'); ?></h3>
	<?php if (!empty($user['Comment'])): ?>
	<table cellpadding = "0" cellspacing = "0">
<?php
	echo $this->Html->tableHeaders(array(
		__('Id'),
		__('Post Id'),
		__('Title'),
		__('User Id'),
		__('Comment'),
		__('Status'),
		__('Created'),
		__('Modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($user['Comment'] as $comment):
		echo $this->Html->tableCells(array(
			$comment['id'],
			$comment['post_id'],
			$comment['title'],
			$comment['user_id'],
			$comment['comment'],
			$comment['status'],
			$comment['created'],
			$comment['modified'],
			array(
				$this->Html->link(__('View'), array('controller' => 'comments', 'action' => 'view', $comment['id'])).
				$this->Html->link(__('Edit'), array('controller' => 'comments', 'action' => 'edit', $comment['id'])).
				$this->Form->postLink(__('Delete'), array('controller' => 'comments', 'action' => 'delete', $comment['id']), null, __('Are you sure you want to delete # %s?', $comment['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
<?php endif; ?>

	<div class="actions">
<?php
	echo $this->Html->nestedList(array(
		$this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add'))
	));
?>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Posts'); ?></h3>
	<?php if (!empty($user['Post'])): ?>
	<table cellpadding = "0" cellspacing = "0">
<?php
	echo $this->Html->tableHeaders(array(
		__('Id'),
		__('Category Id'),
		__('User Id'),
		__('Title'),
		__('Description'),
		__('Body'),
		__('Featured'),
		__('Published'),
		__('Created'),
		__('Modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($user['Post'] as $post):
		echo $this->Html->tableCells(array(
			$post['id'],
			$post['category_id'],
			$post['user_id'],
			$post['title'],
			$post['description'],
			$post['body'],
			$post['featured'],
			$post['published'],
			$post['created'],
			$post['modified'],
			array(
				$this->Html->link(__('View'), array('controller' => 'posts', 'action' => 'view', $post['id'])).
				$this->Html->link(__('Edit'), array('controller' => 'posts', 'action' => 'edit', $post['id'])).
				$this->Form->postLink(__('Delete'), array('controller' => 'posts', 'action' => 'delete', $post['id']), null, __('Are you sure you want to delete # %s?', $post['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
<?php endif; ?>

	<div class="actions">
<?php
	echo $this->Html->nestedList(array(
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add'))
	));
?>
	</div>
</div>
