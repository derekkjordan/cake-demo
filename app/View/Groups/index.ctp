<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('New Group'), array('action' => 'add')),
		$this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')),
		$this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')),
	));
?>
</div>
<div class="groups index">
	<h2><?php echo __('Groups'); ?></h2>
	<table cellpadding="0" cellspacing="0">
<?php
	echo $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('name'),
		$this->Paginator->sort('description'),
		$this->Paginator->sort('created'),
		$this->Paginator->sort('modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($groups as $group):
		echo $this->Html->tableCells(array(
			h($group['Group']['id']).'&nbsp;',
			h($group['Group']['name']).'&nbsp;',
			h($group['Group']['description']).'&nbsp;',
			$this->App->prettyDateTime($group['Group']['created']).'&nbsp;',
			$this->App->prettyDateTime($group['Group']['modified']).'&nbsp;',
			array(
				$this->Html->link(__('View'), array('action' => 'view', $group['Group']['id'])).
				$this->Html->link(__('Edit'), array('action' => 'edit', $group['Group']['id'])).
				$this->Form->postLink(__('Delete'), array('action' => 'delete', $group['Group']['id']), null, __('Are you sure you want to delete # %s?', $group['Group']['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>
