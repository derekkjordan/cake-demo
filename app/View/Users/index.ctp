<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
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
<div class="users index">
	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
<?php
	echo $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('group_id'),
		$this->Paginator->sort('active'),
		$this->Paginator->sort('first_name'),
		$this->Paginator->sort('last_name'),
		$this->Paginator->sort('email'),
		$this->Paginator->sort('password'),
		$this->Paginator->sort('phone'),
		$this->Paginator->sort('address'),
		$this->Paginator->sort('city'),
		$this->Paginator->sort('state'),
		$this->Paginator->sort('zip'),
		$this->Paginator->sort('web'),
		$this->Paginator->sort('created'),
		$this->Paginator->sort('modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($users as $user):
		echo $this->Html->tableCells(array(
			h($user['User']['id']).'&nbsp;',
			$this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])),
			h($user['User']['active']).'&nbsp;',
			h($user['User']['first_name']).'&nbsp;',
			h($user['User']['last_name']).'&nbsp;',
			h($user['User']['email']).'&nbsp;',
			h($user['User']['password']).'&nbsp;',
			h($user['User']['phone']).'&nbsp;',
			h($user['User']['address']).'&nbsp;',
			h($user['User']['city']).'&nbsp;',
			h($user['User']['state']).'&nbsp;',
			h($user['User']['zip']).'&nbsp;',
			h($user['User']['web']).'&nbsp;',
			$this->App->prettyDateTime($user['User']['created']).'&nbsp;',
			$this->App->prettyDateTime($user['User']['modified']).'&nbsp;',
			array(
				$this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])).
				$this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])).
				$this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>
