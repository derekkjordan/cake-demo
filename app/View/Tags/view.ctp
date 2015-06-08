<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('Edit Tag'), array('action' => 'edit', $tag['Tag']['id'])),
		$this->Form->postLink(__('Delete Tag'), array('action' => 'delete', $tag['Tag']['id']), null, __('Are you sure you want to delete # %s?', $tag['Tag']['id'])),
		$this->Html->link(__('List Tags'), array('action' => 'index')),
		$this->Html->link(__('New Tag'), array('action' => 'add')),
		$this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')),
		$this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')),
	));
?>
</div>
<div class="tags view">
<h2><?php echo __('Tag'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Slug'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Weight'); ?></dt>
		<dd>
			<?php echo h($tag['Tag']['weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($tag['Tag']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($tag['Tag']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php echo __('Related Posts'); ?></h3>
	<?php if (!empty($tag['Post'])): ?>
	<table cellpadding = "0" cellspacing = "0">
<?php
	echo $this->Html->tableHeaders(array(
		__('Id'),
		__('Category Id'),
		__('Title'),
		__('Description'),
		__('Body'),
		__('Featured'),
		__('Published'),
		__('Created'),
		__('Modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($tag['Post'] as $post):
		echo $this->Html->tableCells(array(
			$post['id'],
			$post['category_id'],
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
