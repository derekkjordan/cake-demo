<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('New Post'), array('action' => 'add')),
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
<div class="posts index">
	<h2><?php echo __('Posts'); ?></h2>
	<table cellpadding="0" cellspacing="0">
<?php
	echo $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('category_id'),
		$this->Paginator->sort('user_id'),
		$this->Paginator->sort('title'),
		$this->Paginator->sort('description'),
		$this->Paginator->sort('body'),
		$this->Paginator->sort('featured'),
		$this->Paginator->sort('published'),
		$this->Paginator->sort('created'),
		$this->Paginator->sort('modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($posts as $post):
		echo $this->Html->tableCells(array(
			h($post['Post']['id']).'&nbsp;',
			$this->Html->link($post['Category']['name'], array('controller' => 'categories', 'action' => 'view', $post['Category']['id'])),
			$this->Html->link($post['User']['id'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])),
			h($post['Post']['title']).'&nbsp;',
			h($post['Post']['description']).'&nbsp;',
			h($post['Post']['body']).'&nbsp;',
			h($post['Post']['featured']).'&nbsp;',
			h($post['Post']['published']).'&nbsp;',
			$this->App->prettyDateTime($post['Post']['created']).'&nbsp;',
			$this->App->prettyDateTime($post['Post']['modified']).'&nbsp;',
			array(
				$this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])).
				$this->Html->link(__('Edit'), array('action' => 'edit', $post['Post']['id'])).
				$this->Form->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>
