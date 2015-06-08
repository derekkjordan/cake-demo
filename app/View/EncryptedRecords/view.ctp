<div class="actions">
<?php 
	echo $this->Html->nestedList(array(
		$this->Html->link(__('Edit Encrypted Record'), array('action' => 'edit', $encryptedRecord['EncryptedRecord']['id'])),
		$this->Form->postLink(__('Delete Encrypted Record'), array('action' => 'delete', $encryptedRecord['EncryptedRecord']['id']), null, __('Are you sure you want to delete # %s?', $encryptedRecord['EncryptedRecord']['id'])),
		$this->Html->link(__('List Encrypted Records'), array('action' => 'index')),
		$this->Html->link(__('New Encrypted Record'), array('action' => 'add')),
	));
?>
</div>
<div class="encryptedRecords view">
<h2><?php echo __('Encrypted Record'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($encryptedRecord['EncryptedRecord']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Encryption Key Id'); ?></dt>
		<dd>
			<?php echo h($encryptedRecord['EncryptedRecord']['encryption_key_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($encryptedRecord['EncryptedRecord']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Secure1'); ?></dt>
		<dd>
			<?php echo h($encryptedRecord['EncryptedRecord']['secure1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Decrypted1'); ?></dt>
		<dd>
			<?php echo h($encryptedRecord['EncryptedRecord']['decrypted1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($encryptedRecord['EncryptedRecord']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Html->prettyDateTime($encryptedRecord['EncryptedRecord']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
