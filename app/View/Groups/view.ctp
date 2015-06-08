<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('Edit Group'), array('action' => 'edit', $group['Group']['id'])),
		$this->Form->postLink(__('Delete Group'), array('action' => 'delete', $group['Group']['id']), null, __('Are you sure you want to delete # %s?', $group['Group']['id'])),
		$this->Html->link(__('List Groups'), array('action' => 'index')),
		$this->Html->link(__('New Group'), array('action' => 'add')),
		$this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')),
		$this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')),
	));
?>
</div>
<div class="groups view">
<h2><?php echo __('Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($group['Group']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($group['Group']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($group['Group']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($group['Group']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php echo __('Related Users'); ?></h3>
	<?php if (!empty($group['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
<?php
	echo $this->Html->tableHeaders(array(
		__('Id'),
		__('Group Id'),
		__('First Name'),
		__('Last Name'),
		__('Email'),
		__('Password'),
		__('Phone'),
		__('Address'),
		__('City'),
		__('State'),
		__('Zip'),
		__('Web'),
		__('Created'),
		__('Modified'),
		__('Active'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($group['User'] as $user):
		echo $this->Html->tableCells(array(
			$user['id'],
			$user['group_id'],
			$user['first_name'],
			$user['last_name'],
			$user['email'],
			$user['password'],
			$user['phone'],
			$user['address'],
			$user['city'],
			$user['state'],
			$user['zip'],
			$user['web'],
			$user['created'],
			$user['modified'],
			$user['active'],
			array(
				$this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])).
				$this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])).
				$this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id'])),
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
		$this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add'))
	));
?>
	</div>
</div>
