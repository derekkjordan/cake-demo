<?php

App::uses('ModelBehavior', 'Model');

class EncryptableBehavior extends ModelBehavior
{
	/**
	 * @var	array		$__encryptedFields			The names of the table's encrypted columns
	 */
	private $__encryptedFields			= [];

	/**
	 * @var	string		$__encryptionKeyIdField		Column name storing encryption key ID
	 */
	private $__encryptionKeyIdField		= 'encryption_key_id';

	/**
	 * @var	string		$__algorithm				PHP constant representing the algorithm used to encrypt records in the table
	 */
	private $__algorithm				= null;

	/**
	 * @var	resource	$__module					The loaded encryption module used for encrypting and decrypting
	 * 												Can be manipulated by changing value of algorithm
	 */
	private $__module					= null;

	/**
	 * @var	string		$__iv						The initialization vector for the encryption module loaded in __module
	 *												Only set when __module is loaded
	 */
	private $__iv						= null;

	/**
	 * @var	string		$__key						The key for encrypting and decrypting
	 * 												Must be specified by ID in Configure (see app/Config/encryption)
	 * 												Can be manipulated with setKey method
	 */
	private $__key						= null;

	/**
	 * @var	int			$__activeEncryptionKeyId	Active encryption_key_id stored to avoid needlessly reinitializing encryption
	 */
	private $__activeEncryptionKeyId	= null;

	/**
	 * @var	array		$__encryptedFieldsSearched	When performing find operations, store original search value for
	 *												encrypted fields here so we can discard results which don't match
	 */
	private $__encryptedFieldsSearched	= [];


//		                                   
//		SSSSS  EEEEE  TTTTT  U   U  PPPPP  
//		S      E        T    U   U  P   P  
//		SSSSS  EEE      T    U   U  PPPPP  
//		    S  E        T    U   U  P      
//		SSSSS  EEEEE    T    UUUUU  P      
//
/**
 * Initiate behavior for the model using specified settings.
 * 
 * Settings:
 * 
 * - algorithm: PHP constant representing the algorithm used to encrypt records in the table 
 * - keyIdField: Column name storing encryption key ID
 * - fields: The names of the table's encrypted columns
 * 
 * @param	Model	$Model	Model using the behavior
 * @param array $settings Settings to override for model.
 * @return void
 */
	public function setup(Model $Model, $settings = [])
	{
		// Create default settings
		if ( !isset($this->settings[$Model->alias]) )
		{
			$this->settings[$Model->alias] = [
				'algorithm' => Configure::read('encryption.algorithm'),
				'fields' => [],
				'keyIdField' => 'encryption_key_id',
			];
		}

		// Merge settings set in Model
		$this->settings[$Model->alias] = am($this->settings[$Model->alias], $settings);

		$this->__algorithm				= $this->settings[$Model->alias]['algorithm'];
		$this->__encryptedFields		= $this->settings[$Model->alias]['fields'];
		$this->__encryptionKeyIdField	= $this->settings[$Model->alias]['keyIdField'];

		$this->__startTime = microtime(true);

		// Initialize encryption module
		$this->__module = mcrypt_module_open($this->__algorithm, '', 'ecb', '');
		$this->__iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->__module), MCRYPT_DEV_URANDOM);
	}

//		                                                                           
//		CCCCC  H   H   AAA   N   N  GGGGG  EEEEE       K   K  EEEEE  Y   Y  SSSSS  
//		C      H   H  A   A  NN  N  G      E           K  K   E       Y Y   S      
//		C      HHHHH  AAAAA  N N N  G  GG  EEE         KKK    EEE      Y    SSSSS  
//		C      H   H  A   A  N  NN  G   G  E           K  K   E        Y        S  
//		CCCCC  H   H  A   A  N   N  GGGGG  EEEEE       K   K  EEEEE    Y    SSSSS  
//
/**
 * Reencrypt records encrypted with $current_key_id using $new_key_id
 * 
 * @param	$Model				Model using the behavior
 * @param	$current_key_id		The ID of the encryption key to be updated
 * @param	$new_key_id			The ID of the encryption key to change to
 * @param	$limit				The maximum number of records to process at once
 * @return	bool	operation successful
 */
	public function changeKeys(Model $Model, $current_key_id = null, $new_key_id = null, $limit = 100000)
	{
		if ( is_null($current_key_id) || is_null($new_key_id) )
		{
			return false;
		}

		if (
			!$this->setKey($Model, $new_key_id) // check new key first
			||
			!$this->setKey($Model, $current_key_id) // leaves current key loaded in memory after successfully checking it
		)
		{
			return false;
		}

		// find records encrypted with $current_key_id
		$records = $Model->find('all', [
			'conditions'	=>	[
				$Model->alias.'.'.$this->__encryptionKeyIdField	=>	$current_key_id,
			],
			'order'			=>	[
				$Model->alias.'.'.$this->__encryptionKeyIdField	=>	'ASC',
				$Model->alias.'.'.$Model->primaryKey			=>	'ASC',
			],
			'limit'			=>	$limit,
		]);

		if ( empty($records) )
		{
			return false;
		}

		$ds = $Model->getDataSource();

		$ds->begin();
		try
		{
			foreach ($records as &$record)
			{
				// set the new key
				$record[$Model->alias][$this->__encryptionKeyIdField] = $new_key_id;

				$id = $record[$Model->alias][$Model->primaryKey];

				// update record
				$Model->clear();
				$Model->id = $id;
				if ( !$Model->save($record) )
				{
					throw new Exception(__('Could not update record #%s. Terminating process.', $id));
				}
			}
		}
		catch ( Exception $e )
		{
			$ds->rollback();
			return false;
		}

		$ds->commit();
		return true;

	}

//		                                                                                                                                  
//		GGGGG  EEEEE  TTTTT       PPPPP  OOOOO  SSSSS  SSSSS            EEEEE  N   N  CCCCC  RRR              V   V   AAA   L      SSSSS  
//		G      E        T         P   P  O   O  S      S                E      NN  N  C      R  R             V   V  A   A  L      S      
//		G  GG  EEE      T         PPPPP  O   O  SSSSS  SSSSS            EEE    N N N  C      RRR              V   V  AAAAA  L      SSSSS  
//		G   G  E        T         P      O   O      S      S  ..        E      N  NN  C      R  R   ..         V V   A   A  L          S  
//		GGGGG  EEEEE    T         P      OOOOO  SSSSS  SSSSS  ..        EEEEE  N   N  CCCCC  R   R  ..          V    A   A  LLLLL  SSSSS  
//
/**
 * Returns all possible encrypted values of given value
 * Meant to support searching by encryptedField with unknown encryption_key_id
 * 
 * @param	Model	$Model	Model using the behavior
 * @param	string	$value	string to be encrypted
 * 
 * @return	array	encrypted values indexed by encryption_key_id
 */
	public function getPossibleEncryptedValues(Model $Model, $value = '')
	{
		$out = [];

		// Read the available keys from external config file
		$keys = Configure::read('encryption.keys');

		// If we loaded any keys
		if ( !empty($keys) )
		{
			foreach ($keys as $key_id => $key)
			{
				// Reinitialize encryption module with this key
				$this->setKey($Model, $key_id);

				// Encrypt the value with this key
				$out[$key_id] = $this->__encrypt($value);
			}
		}

		return $out;
	}

//		                                               
//		SSSSS  EEEEE  TTTTT       K   K  EEEEE  Y   Y  
//		S      E        T         K  K   E       Y Y   
//		SSSSS  EEE      T         KKK    EEE      Y    
//		    S  E        T         K  K   E        Y    
//		SSSSS  EEEEE    T         K   K  EEEEE    Y    
//
/**
 * load the key specified by $encryption_key_id from Configure (see app/Config/encryption.php)
 * 
 * @param	Model	$Model	Model using the behavior
 * @param	int		$encryption_key_id	ID of the encryption key
 * 
 * @return	bool	true if key found in Config, false if not
 */
	public function setKey(Model $Model, $encryption_key_id = null)
	{
		// No reason to reinitialize encryption if the same encryption key is being used again
		if ( !is_null($this->__activeEncryptionKeyId) && $this->__activeEncryptionKeyId == $encryption_key_id )
		{
			return true;
		}

		// Load the key from Configure
		$key = Configure::read('encryption.keys.'.$encryption_key_id);
		
		// If the key can be found in Configure
		if ( !empty($key) )
		{
			// Set the key
			$this->__key = substr(sha1($key), 0, mcrypt_enc_get_key_size($this->__module));

			// Initialize encryption for this key
			mcrypt_generic_init($this->__module, $this->__key, $this->__iv);

			// Remember the key ID used in case the next time this method executes is for the same key ID
			$this->__activeEncryptionKeyId = $encryption_key_id;
			return true;
		}
		// Invalid key, reset behavior properties
		else
		{
			$this->__key = null;
			$this->__activeEncryptionKeyId = null;
			return false;
		}
	}

//		                                                 
//		EEEEE  N   N  CCCCC  RRR    Y   Y  PPPPP  TTTTT  
//		E      NN  N  C      R  R    Y Y   P   P    T    
//		EEE    N N N  C      RRR      Y    PPPPP    T    
//		E      N  NN  C      R  R     Y    P        T    
//		EEEEE  N   N  CCCCC  R   R    Y    P        T    
//
/**
 * encrypts the text using the models loaded __key
 * setKey() should always be called before this method
 * 
 * @param	string		$plain_text		plain text to be encrypted
 * 
 * @return	string/bool					encrypted text if successful, false if no text or key present
 */
	public function __encrypt($plain_text = null) 
	{
		if ( !empty($this->__key) && !empty($plain_text) )
		{
			return base64_encode(mcrypt_generic($this->__module, $plain_text));
		}
		else
		{
			return false;
		}
	}

/**
 * public wrapper for __encrypt, can specify encryption key ID
 * 
 * @param	Model	$Model	Model using the behavior
 * @param	string		$plain_text			plain text to be decrypted
 * @param	int			$encrypted_key_id	ID of encryption key to use, defaults to last entry in Configure encryption.keys
 * 
 * @return	string/bool						encrypted text if successful, false if no text or invalid key present
 */
	public function encrypt(Model $Model, $plain_text = null, $encryption_key_id = null)
	{
		// If no key was passed, use the default key
		if ( empty($encryption_key_id) )
		{
			$encryption_key_id = Configure::read('defaultEncryptionKeyId');
		}

		$this->setKey($Model, $encryption_key_id);

		return $this->__encrypt($plain_text);
	}

//		                                                 
//		DDDD   EEEEE  CCCCC  RRR    Y   Y  PPPPP  TTTTT  
//		D   D  E      C      R  R    Y Y   P   P    T    
//		D   D  EEE    C      RRR      Y    PPPPP    T    
//		D   D  E      C      R  R     Y    P        T    
//		DDDD   EEEEE  CCCCC  R   R    Y    P        T    
//
/**
 * decrypts the text using the models loaded __key
 * setKey() should always be called before this method
 * 
 * @param	string		$encrypted_text		encrypted text to be decrypted
 * 
 * @return	string/bool						decrypted text if successful, false if no text or key present
 */
	public function __decrypt($encrypted_text = null) 
	{
		if ( !empty($this->__key) && !empty($encrypted_text) )
		{
			return (string) trim(mdecrypt_generic($this->__module, (string) base64_decode(trim($encrypted_text))));
		}
		else
		{
			return false;
		}
	}

/**
 * public wrapper for __decrypt, can specify encryption key ID
 * 
 * @param	Model	$Model				Model using the behavior
 * @param	string	$encrypted_text		encrypted text to be decrypted
 * @param	int		$encrypted_key_id	ID of encryption key to use, defaults to last entry in Configure encryption.keys
 * 
 * @return	string/bool					decrypted text if successful, false if no text or invalid key present
 */
	public function decrypt(Model $Model, $encrypted_text = null, $encryption_key_id = null)
	{
		// If no key was passed, use the default key
		if ( empty($encryption_key_id) )
		{
			$encryption_key_id = Configure::read('defaultEncryptionKeyId');
		}

		$this->setKey($Model, $encryption_key_id);

		return $this->__decrypt($encrypted_text);
	}

//		                                                                           
//		BBBB   EEEEE  FFFFF  OOOOO  RRR    EEEEE       FFFFF  IIIII  N   N  DDDD   
//		B   B  E      F      O   O  R  R   E           F        I    NN  N  D   D  
//		BBBB   EEE    FFF    O   O  RRR    EEE         FFF      I    N N N  D   D  
//		B   B  E      F      O   O  R  R   E           F        I    N  NN  D   D  
//		BBBB   EEEEE  F      OOOOO  R   R  EEEEE       F      IIIII  N   N  DDDD   
//
/**
 * Replaces encryptedField singular value with OR array of possible encrypted values
 * 
 * @param	Model	$Model	Model using the behavior
 * @param	array	$query	Query parameters as set by cake
 * @return	array
 */
	public function beforeFind(Model $Model, $query)
	{
		// Clear the encryptedFieldsSearched
		if ( count($this->__encryptedFieldsSearched) )
		{
			$this->__encryptedFieldsSearched = [];
		}

		if (!empty($query['conditions']) && is_array($query['conditions']))
		{
			foreach ($this->__encryptedFields as $encryptedField)
			{
				$key = null;

				// EncryptedField is a condition
				if ( !empty($query['conditions'][$encryptedField]) )
				{
					$key = $encryptedField;
				}
				// Model.encryptedField is a condition
				elseif ( !empty($query['conditions'][$Model->alias.'.'.$encryptedField]) )
				{
					$key = $Model->alias.'.'.$encryptedField;
				}

				// Searching by this encryptedField
				if ( !empty($key) )
				{
					// Remember original search value
					$this->__encryptedFieldsSearched[$encryptedField] = $query['conditions'][$key];

					$possibilities = $this->getPossibleEncryptedValues($Model, $query['conditions'][$key]);

					// Disregard encryption_key_ids because they may not be sequential or start at 0
					$query['conditions'][$key] = array_values($possibilities);
				}
			}
		}

		if ( !empty($query['fields']) && is_array($query['fields']) && !in_array($this->__encryptionKeyIdField, $query['fields']) )
		{
			$query['fields'][] = $this->__encryptionKeyIdField;
		}

		return $query;
	}

//		                                                                           
//		BBBB   EEEEE  FFFFF  OOOOO  RRR    EEEEE       SSSSS   AAA   V   V  EEEEE  
//		B   B  E      F      O   O  R  R   E           S      A   A  V   V  E      
//		BBBB   EEE    FFF    O   O  RRR    EEE         SSSSS  AAAAA  V   V  EEE    
//		B   B  E      F      O   O  R  R   E               S  A   A   V V   E      
//		BBBB   EEEEE  F      OOOOO  R   R  EEEEE       SSSSS  A   A    V    EEEEE  
//
/**
 * encrypts all fields specified in $this->__encryptedFields
 * 
 * @param	Model	$Model		Model using the behavior
 * @param	array	$options	Options passed from Model::save().
 * @return	bool	true to continue, false to abort the save
 * @see		Model::save()
 */
	public function beforeSave(Model $Model, $options = []) 
	{
		$encryption_key_id = $Model->data[$Model->alias][$this->__encryptionKeyIdField];

		// If a valid encryption_key_id is present
		if( !empty($encryption_key_id) && $this->setKey($Model, $encryption_key_id) )
		{
			// Encrypt all encrypted fields
			foreach ($this->__encryptedFields as $encryptedField) 
			{
				if ( isset($Model->data[$Model->alias][$encryptedField]) && !empty($Model->data[$Model->alias][$encryptedField]) ) 
				{
					$Model->data[$Model->alias][$encryptedField] = $this->__encrypt($Model->data[$Model->alias][$encryptedField]);
				}
			}
			return true;
		}
		else
		{
			return false;
		}
	}

//		                                                                    
//		 AAA   FFFFF  TTTTT  EEEEE  RRR         FFFFF  IIIII  N   N  DDDD   
//		A   A  F        T    E      R  R        F        I    NN  N  D   D  
//		AAAAA  FFF      T    EEE    RRR         FFF      I    N N N  D   D  
//		A   A  F        T    E      R  R        F        I    N  NN  D   D  
//		A   A  F        T    EEEEE  R   R       F      IIIII  N   N  DDDD   
//
/**
 * decrypts all fields specified in $this->__encryptedFields for each record
 * 
 * @param	Model	$Model		Model using the behavior
 * @param	mixed	$results	The results of the find operation
 * @param	bool	$primary	Whether this model is being queried directly (vs. being queried as an association)
 * @return	mixed	Result of the find operation
 */
	public function afterFind(Model $Model, $results, $primary = false)
	{
		$results_to_discard = [];

		// Find out if this was primary search or not (there are two different possible formats of $results array)
		// For belongsTo association, find(), or similar
		if ( array_key_exists(0, $results) && array_key_exists($Model->alias, $results[0])) 
		{
			// Loop through records
			foreach ($results as $key => &$result) 
			{
				// If we can load the correct encryption key from config
				if (
					// Key ID field is present
					array_key_exists($this->__encryptionKeyIdField, $result[$Model->alias])
					&&
					// The encryption key for this record's encryptionKeyIdField successfully loaded from config
					$this->setKey($Model, $result[$Model->alias][$this->__encryptionKeyIdField])
				)
				{
					foreach ($this->__encryptedFields as $encryptedField) 
					{
						// Decrypt any encrypted fields present
						if ( isset($result[$Model->alias][$encryptedField]) && !empty($result[$Model->alias][$encryptedField]) ) 
						{
							$result[$Model->alias][$encryptedField] = $this->__decrypt($result[$Model->alias][$encryptedField]);
						}

						// Discard results which do not match the original unenecrypted search condition
						if (
							!empty($this->__encryptedFieldsSearched[$encryptedField])
							&&
							!empty($result[$Model->alias][$encryptedField])
							&&
							$result[$Model->alias][$encryptedField] !== $this->__encryptedFieldsSearched[$encryptedField]
						)
						{
							$results_to_discard[] = $key;
						}
					}
				}
			}
		} 
		// For hasMany association or similar, ignoring paginator count query
		elseif ( isset($results[0][$Model->primaryKey]) && !isset($results[0][0]['count']) )
		{
			foreach ($results as $key => &$result)
			{
				// If we can load the correct encryption key from config
				if (
					// Key ID field is present
					array_key_exists($this->__encryptionKeyIdField, $result)
					&&
					// The encryption key for this record's encryptionKeyIdField successfully loaded from config
					$this->setKey($Model, $result[$this->__encryptionKeyIdField])
				)
				{
					foreach ($this->__encryptedFields as $encryptedField)
					{
						// Decrypt any encrypted fields present
						if ( isset($result[$encryptedField]) && !empty($result[$encryptedField]) )
						{
							$result[$encryptedField] = $this->__decrypt($result[$encryptedField]);
						}

						// Discard results which do not match the original unenecrypted search condition
						if (
							!empty($this->__encryptedFieldsSearched[$encryptedField])
							&&
							$result[$encryptedField] !== $this->__encryptedFieldsSearched[$encryptedField]
						)
						{
							$results_to_discard[] = $Model->name;
						}
					}
				}
			}
		}
		if ( count($results_to_discard) )
		{
			foreach ($results_to_discard as $key)
			{
				unset($results[$key]);
			}
			$results = array_values($results);
		}

		return $results;
	}

}
