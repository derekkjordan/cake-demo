<?php

class AclShell extends AppShell
{
	public $uses = [
		'User',
		'Permission',
	];

	private $__groupNames = [
		1	=>	'Admin',
		2	=>	'Manager',
	];

	public function startup()
	{
		$this->_commands['S'] = [
			'method'	=>	'set',
			'title'		=>	'Set',
		];

		parent::startup();

		$this->stdout->styles('aco', ['text' => 'blue', 'bold' => true]);
		$this->stdout->styles('aro', ['text' => 'magenta', 'bold' => true]);
		$this->stdout->styles('allowed', ['text' => 'green', 'bold' => true]);
		$this->stdout->styles('denied', ['text' => 'red', 'bold' => true]);
		$this->stdout->styles('model', ['text' => 'cyan', 'bold' => true]);
	}

	public function main()
	{
		parent::main();

		$this->_promptForCommand();
	}

	public function set()
	{
		$this->out(null, 2);
		$this->out(__('Running Shell: %s', $this->_style('AclExtras.AclExtras aco_sync', 'info')), 0);
		$this->hr(1);
		// add/remove actions in all controllers 
		// php app/Console/cake.php AclExtras.AclExtras aco_sync
		$this->dispatchShell('AclExtras.AclExtras aco_sync');

		// clear permissions not pertaining to admins
		$this->Permission->query('DELETE FROM aros_acos WHERE aro_id > 1');

		// Allow admins to everything
		$aro = [
			'model'			=>	'Group',
			'foreign_key'	=>	1
		];

		$this->__allow($aro, 'controllers');

		// allow managers to posts and widgets
		$aro['foreign_key']	= 2;

		$this->__deny($aro, 'controllers');
		$this->__allow($aro, 'controllers/Posts');
		$this->__allow($aro, 'controllers/users/logout');
	}

/**
 * Allow $aro to have access to action $actions in $aco
 *
 * @param mixed $aro ARO The requesting object identifier.
 * @param string $aco ACO The controlled object identifier.
 * @param string $actions Action (defaults to *) Invalid permissions will result in an exception
 * @param integer $value Value to indicate access type (1 to give access, -1 to deny, 0 to inherit)
 * @return boolean Success
 * @throws AclException on Invalid permission key.
 */
	private function __allow($aro, $aco, $actions = '*', $value = 1)
	{
		$this->Permission->allow($aro, $aco, $actions, $value);

		if ( is_array($aro) && !empty($aro['model']) && $aro['model'] === 'Group' )
		{
			$access = ( $value == 1 ? 'allowed' : 'denied' );

			$this->_vout(__(
				'%s %s is %s access to %s', 
				$this->_style($aro['model'], 'model'),
				$this->_style($this->__groupNames[$aro['foreign_key']], 'aro'),
				$this->_style($access, $access),
				$this->_style($aco, 'aco')
			));
		}
	}

/**
 * Deny access for $aro to action $action in $aco
 *
 * @param mixed $aro ARO The requesting object identifier.
 * @param string $aco ACO The controlled object identifier.
 * @param string $action Action (defaults to *)
 * @return boolean Success
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/access-control-lists.html#assigning-permissions
 */
	private function __deny($aro, $aco, $action = "*")
	{
		$this->__allow($aro, $aco, $action, -1);
	}
}
