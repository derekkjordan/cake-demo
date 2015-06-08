<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('New Comment'), array('action' => 'add')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
		$this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')),
		$this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')),
	));
?>
</div>
<div class="comments index">
	<h2><?php echo __('Comments'); ?></h2>
	<table cellpadding="0" cellspacing="0">
<?php
	echo $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('post_id'),
		$this->Paginator->sort('title'),
		$this->Paginator->sort('user_id'),
		$this->Paginator->sort('comment'),
		$this->Paginator->sort('status'),
		$this->Paginator->sort('created'),
		$this->Paginator->sort('modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($comments as $comment):
		echo $this->Html->tableCells(array(
			h($comment['Comment']['id']).'&nbsp;',
			$this->Html->link($comment['Post']['title'], array('controller' => 'posts', 'action' => 'view', $comment['Post']['id'])),
			h($comment['Comment']['title']).'&nbsp;',
			$this->Html->link($comment['User']['id'], array('controller' => 'users', 'action' => 'view', $comment['User']['id'])),
			h($comment['Comment']['comment']).'&nbsp;',
			h($comment['Comment']['status']).'&nbsp;',
			$this->App->prettyDateTime($comment['Comment']['created']).'&nbsp;',
			$this->App->prettyDateTime($comment['Comment']['modified']).'&nbsp;',
			array(
				$this->Html->link(__('View'), array('action' => 'view', $comment['Comment']['id'])).
				$this->Html->link(__('Edit'), array('action' => 'edit', $comment['Comment']['id'])).
				$this->Form->postLink(__('Delete'), array('action' => 'delete', $comment['Comment']['id']), null, __('Are you sure you want to delete # %s?', $comment['Comment']['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>
