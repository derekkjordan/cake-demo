<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('Edit Post'), array('action' => 'edit', $post['Post']['id'])),
		$this->Form->postLink(__('Delete Post'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])),
		$this->Html->link(__('List Posts'), array('action' => 'index')),
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
<div class="posts view">
<h2><?php echo __('Post'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($post['Post']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['Category']['name'], array('controller' => 'categories', 'action' => 'view', $post['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['User']['id'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($post['Post']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($post['Post']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Body'); ?></dt>
		<dd>
			<?php echo h($post['Post']['body']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Featured'); ?></dt>
		<dd>
			<?php echo h($post['Post']['featured']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Published'); ?></dt>
		<dd>
			<?php echo h($post['Post']['published']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($post['Post']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($post['Post']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php echo __('Related Comments'); ?></h3>
	<?php if (!empty($post['Comment'])): ?>
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

	foreach ($post['Comment'] as $comment):
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
	<h3><?php echo __('Related Tags'); ?></h3>
	<?php if (!empty($post['Tag'])): ?>
	<table cellpadding = "0" cellspacing = "0">
<?php
	echo $this->Html->tableHeaders(array(
		__('Id'),
		__('Name'),
		__('Slug'),
		__('Weight'),
		__('Created'),
		__('Modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($post['Tag'] as $tag):
		echo $this->Html->tableCells(array(
			$tag['id'],
			$tag['name'],
			$tag['slug'],
			$tag['weight'],
			$tag['created'],
			$tag['modified'],
			array(
				$this->Html->link(__('View'), array('controller' => 'tags', 'action' => 'view', $tag['id'])).
				$this->Html->link(__('Edit'), array('controller' => 'tags', 'action' => 'edit', $tag['id'])).
				$this->Form->postLink(__('Delete'), array('controller' => 'tags', 'action' => 'delete', $tag['id']), null, __('Are you sure you want to delete # %s?', $tag['id'])),
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
		$this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add'))
	));
?>
	</div>
</div>
