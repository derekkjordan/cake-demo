<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('New Tag'), array('action' => 'add')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
	));
?>
</div>
<div class="tags index">
	<h2><?php echo __('Tags'); ?></h2>
	<table cellpadding="0" cellspacing="0">
<?php
	echo $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('name'),
		$this->Paginator->sort('slug'),
		$this->Paginator->sort('weight'),
		$this->Paginator->sort('created'),
		$this->Paginator->sort('modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($tags as $tag):
		echo $this->Html->tableCells(array(
			h($tag['Tag']['id']).'&nbsp;',
			h($tag['Tag']['name']).'&nbsp;',
			h($tag['Tag']['slug']).'&nbsp;',
			h($tag['Tag']['weight']).'&nbsp;',
			$this->App->prettyDateTime($tag['Tag']['created']).'&nbsp;',
			$this->App->prettyDateTime($tag['Tag']['modified']).'&nbsp;',
			array(
				$this->Html->link(__('View'), array('action' => 'view', $tag['Tag']['id'])).
				$this->Html->link(__('Edit'), array('action' => 'edit', $tag['Tag']['id'])).
				$this->Form->postLink(__('Delete'), array('action' => 'delete', $tag['Tag']['id']), null, __('Are you sure you want to delete # %s?', $tag['Tag']['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>
