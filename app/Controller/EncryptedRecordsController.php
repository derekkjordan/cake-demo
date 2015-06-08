<?php
App::uses('AppController', 'Controller');
/**
 * EncryptedRecords Controller
 *
 * @property EncryptedRecord $EncryptedRecord
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class EncryptedRecordsController extends AppController
{

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow();
	}

/**
 * index method
 *
 * @return void
 */
	public function index()
	{
		$this->EncryptedRecord->recursive = 0;
		$this->set('encryptedRecords', $this->Paginator->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add()
	{
		if ($this->request->is('post'))
		{
			$this->EncryptedRecord->create();
			if ($this->EncryptedRecord->save($this->request->data))
			{
				$this->_successFlash(__('The encrypted record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The encrypted record could not be saved. Please, try again.'));
			}
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null)
	{
		$this->EncryptedRecord->id = $id;
		if (!$this->EncryptedRecord->exists())
		{
			throw new NotFoundException(__('Invalid encrypted record'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->EncryptedRecord->delete())
		{
			$this->_successFlash(__('The encrypted record has been deleted.'));
		}
		else
		{
			$this->_errorFlash(__('The encrypted record could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null)
	{
		$this->EncryptedRecord->id = $id;
		if (!$this->EncryptedRecord->exists())
		{
			throw new NotFoundException(__('Invalid encrypted record'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->EncryptedRecord->save($this->request->data))
			{
				$this->_successFlash(__('The encrypted record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The encrypted record could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->EncryptedRecord->find('first', array(
				'conditions'	=>	array(
					'EncryptedRecord.id'	=>	$id
				),
			));
		}
	}

	public function test()
	{
		// Generate some records
		// for ($i=0; $i < 2500; $i++)
		// { 
		// 	$lorem = 'Lorem '.$i;

		// 	$encrypted_record = array('EncryptedRecord'=>array(
		// 		'encryption_key_id'	=>	1,
		// 		'secure1'			=>	$lorem,
		// 		'decrypted1'		=>	$lorem,
		// 	));

		// 	$this->EncryptedRecord->create();
		// 	$this->EncryptedRecord->save($encrypted_record);
		// }

		// change keys
		// $start_time = microtime(true);

		// $current_id = 3;
		// $new_id = 4;

		// $changed1 = ( $this->EncryptedRecord->changeKeys($current_id, $new_id) ? 'Yes' : 'No' );

		// $current_id = 4;
		// $new_id = 2;

		// $changed2 = ( $this->EncryptedRecord->changeKeys($current_id, $new_id) ? 'Yes' : 'No' );

		// $time_elapsed = microtime(true) - $start_time;

		// $data = $this->EncryptedRecord->query(
		//    "SELECT		COUNT(EncryptedRecord.id) AS count,
		// 				EncryptedRecord.encryption_key_id
		// 	FROM		encrypted_records AS EncryptedRecord
		// 	GROUP BY	EncryptedRecord.encryption_key_id"
		// );

		// $stats = array();
		// foreach ($data as &$row)
		// {
		// 	$stats[ $row['EncryptedRecord']['encryption_key_id'] ] = $row[0]['count'];
		// }

		// pr(compact('changed1','changed2','time_elapsed','stats'));

		// test find operations
		$user = $this->EncryptedRecord->User->find('first', array(
			'contain'		=>	array('EncryptedRecord'),
			// 'recursive' => 1
		));

		$encrypted_record = $this->EncryptedRecord->find('first', array(
			'conditions'	=>	array(
				'EncryptedRecord.secure1'	=>	'Lorem 1',
			),
		));

		$encrypted_records = $this->EncryptedRecord->find('all', array(
			'conditions'	=>	array(
				'EncryptedRecord.encryption_key_id'		=>	1,
			),
			'limit'			=>	5,
		));

		pr(compact('user', 'encrypted_record', 'encrypted_records'));
		exit;
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null)
	{
		$this->EncryptedRecord->id = $id;
		if (!$this->EncryptedRecord->exists())
		{
			throw new NotFoundException(__('Invalid encrypted record'));
		}
		$this->set('encryptedRecord', $this->EncryptedRecord->find('first', array(
			'conditions'	=>	array(
				'EncryptedRecord.id'	=>	$id
			),
		)));
	}
}
