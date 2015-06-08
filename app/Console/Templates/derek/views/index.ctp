<?php
/**
 *
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
	echo \$this->Html->nestedList(array(
		\$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add')),\n";

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
<div class="<?php echo $pluralVar; ?> index">
	<h2><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h2>
	<table cellpadding="0" cellspacing="0">
<?php
	echo "<?php
	echo \$this->Html->tableHeaders(array(\n";
	foreach ($fields as $field) 
	{
		echo "\t\t\$this->Paginator->sort('{$field}'),\n";
	}
	echo "\t\tarray(__('Actions')=>array('class'=>'actions'))
	));

	foreach (\${$pluralVar} as \${$singularVar}):
		echo \$this->Html->tableCells(array(\n";
		foreach ($fields as $field)
		{
			$isKey = false;
			if (!empty($associations['belongsTo']))
			{
				foreach ($associations['belongsTo'] as $alias => $details)
				{
					if ($field === $details['foreignKey'])
					{
						$isKey = true;
						echo "\t\t\t\$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])),\n";
						break;
					}
				}
			}
			if ($isKey !== true)
			{
				if ( in_array($field, array('created','modified')) )
				{
					echo "\t\t\t\$this->App->prettyDateTime(\${$singularVar}['{$modelClass}']['{$field}']).'&nbsp;',\n";
				}
				else
				{
					echo "\t\t\th(\${$singularVar}['{$modelClass}']['{$field}']).'&nbsp;',\n";
				}
			}
		}
		echo "\t\t\tarray(
				\$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])).
				\$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])).
				\$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])),
				array('class'=>'actions')
			)
		));
	endforeach;
?>\n";
?>
	</table>
	<?php echo "<?php echo \$this->element('paging'); ?>\n"; ?>
</div>
