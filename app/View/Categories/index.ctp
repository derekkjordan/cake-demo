<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('New Category'), array('action' => 'add')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
	));
?>
</div>
<div class="categories index">
	<h2><?php echo __('Categories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
<?php
	echo $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('name'),
		$this->Paginator->sort('slug'),
		$this->Paginator->sort('description'),
		$this->Paginator->sort('created'),
		$this->Paginator->sort('modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($categories as $category):
		echo $this->Html->tableCells(array(
			h($category['Category']['id']).'&nbsp;',
			h($category['Category']['name']).'&nbsp;',
			h($category['Category']['slug']).'&nbsp;',
			h($category['Category']['description']).'&nbsp;',
			$this->App->prettyDateTime($category['Category']['created']).'&nbsp;',
			$this->App->prettyDateTime($category['Category']['modified']).'&nbsp;',
			array(
				$this->Html->link(__('View'), array('action' => 'view', $category['Category']['id'])).
				$this->Html->link(__('Edit'), array('action' => 'edit', $category['Category']['id'])).
				$this->Form->postLink(__('Delete'), array('action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>
