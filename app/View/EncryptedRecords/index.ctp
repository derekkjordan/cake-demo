<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('New Encrypted Record'), array('action' => 'add')),
	));
?>
</div>
<div class="encryptedRecords index">
	<h2><?php echo __('Encrypted Records'); ?></h2>
	<table cellpadding="0" cellspacing="0">
<?php
	echo $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		$this->Paginator->sort('encryption_key_id'),
		$this->Paginator->sort('user_id'),
		$this->Paginator->sort('secure1'),
		$this->Paginator->sort('decrypted1'),
		$this->Paginator->sort('created'),
		$this->Paginator->sort('modified'),
		array(__('Actions')=>array('class'=>'actions'))
	));

	foreach ($encryptedRecords as $encryptedRecord):
		echo $this->Html->tableCells(array(
			h($encryptedRecord['EncryptedRecord']['id']).'&nbsp;',
			h($encryptedRecord['EncryptedRecord']['encryption_key_id']).'&nbsp;',
			h($encryptedRecord['EncryptedRecord']['user_id']).'&nbsp;',
			h($encryptedRecord['EncryptedRecord']['secure1']).'&nbsp;',
			h($encryptedRecord['EncryptedRecord']['decrypted1']).'&nbsp;',
			$this->App->prettyDateTime($encryptedRecord['EncryptedRecord']['created']).'&nbsp;',
			$this->App->prettyDateTime($encryptedRecord['EncryptedRecord']['modified']).'&nbsp;',
			array(
				$this->Html->link(__('View'), array('action' => 'view', $encryptedRecord['EncryptedRecord']['id'])).
				$this->Html->link(__('Edit'), array('action' => 'edit', $encryptedRecord['EncryptedRecord']['id'])).
				$this->Form->postLink(__('Delete'), array('action' => 'delete', $encryptedRecord['EncryptedRecord']['id']), null, __('Are you sure you want to delete # %s?', $encryptedRecord['EncryptedRecord']['id'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>
	</table>
	<?php echo $this->element('paging'); ?>
</div>
