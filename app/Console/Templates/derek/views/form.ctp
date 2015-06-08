<?php
/**
 * Modified to put actions first and use HtmlHelper::nestedList()
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="actions">
<?php
	echo "<?php 
	echo \$this->Html->nestedList(array(\n";

	if (strpos($action, 'add') === false)
	{
		echo "\t\t\$this->Form->postLink(__('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), null, __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))),\n";
	}
	echo "\t\t\$this->Html->link(__('List " . $pluralHumanName . "'), array('action' => 'index')),\n";

	$done = array();
	foreach ($associations as $type => $data)
	{
		foreach ($data as $alias => $details)
		{
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done))
			{
				echo "\t\t\$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')),\n";
				echo "\t\t\$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')),\n";
				$done[] = $details['controller'];
			}
		}
	}
	echo "\t));\n?>\n";
?>
</div>
<div class="<?php echo $pluralVar; ?> form">
<?php echo "<?php echo \$this->Form->create('{$modelClass}'); ?>\n"; ?>
	<fieldset>
		<legend><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></legend>
<?php
		echo "\t<?php\n";
		foreach ($fields as $field)
		{
			if (strpos($action, 'add') !== false && $field === $primaryKey)
			{
				continue;
			}
			elseif (!in_array($field, array('created', 'modified', 'updated')))
			{
				$options = '';

				// use chosen selects for foreign key fields
				if ( strpos($field, '_id') == (strlen($field)-3) )
				{
					$options .= "'class'=>'chosen-select',";
				}
				if ( $field == 'filename' )
				{
					$options .= "'type'=>'file'";
				}
				echo "\t\techo \$this->Form->input('{$field}', array($options));\n";
			}
		}
		if (!empty($associations['hasAndBelongsToMany']))
		{
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData)
			{
				echo "\t\techo \$this->Form->input('{$assocName}',array('class'=>'chosen-select'));\n";
			}
		}
		echo "\t?>\n";
?>
	</fieldset>
<?php
	echo "<?php echo \$this->Form->end(__('Submit')); ?>\n";
?>
</div>
