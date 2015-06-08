<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EncryptedRecord.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('EncryptedRecord.id'))),
		$this->Html->link(__('List Encrypted Records'), array('action' => 'index')),
	));
?>
</div>
<div class="encryptedRecords form">
<?php echo $this->Form->create('EncryptedRecord'); ?>
	<fieldset>
		<legend><?php echo __('Edit Encrypted Record'); ?></legend>
	<?php
		echo $this->Form->input('id', array());
		echo $this->Form->input('encryption_key_id', array('class'=>'chosen-select',));
		echo $this->Form->input('user_id', array('class'=>'chosen-select',));
		echo $this->Form->input('secure1', array());
		echo $this->Form->input('decrypted1', array());
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
