<?php

class EncryptedRecord extends AppModel
{
	public $actsAs = array(
		'Encryptable'	=>	array(
			'fields'	=>	array(
				'secure1',
			),
		),
		'Containable',
	);

	public $belongsTo = array(
		'User',
	);

	public $recursive = -1;
}
