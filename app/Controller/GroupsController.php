<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 */
class GroupsController extends AppController
{

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');



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
		$this->Group->recursive = 0;
		$this->set('groups', $this->Paginator->paginate());
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
			$this->Group->create();
			if ($this->Group->save($this->request->data))
			{
				$this->_successFlash(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The group could not be saved. Please, try again.'));
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
		$this->Group->id = $id;
		if (!$this->Group->exists())
		{
			throw new NotFoundException(__('Invalid group'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Group->delete())
		{
			$this->_successFlash(__('The group has been deleted.'));
		}
		else
		{
			$this->_errorFlash(__('The group could not be deleted. Please, try again.'));
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
		$this->Group->id = $id;
		if (!$this->Group->exists())
		{
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->Group->save($this->request->data))
			{
				$this->_successFlash(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The group could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->Group->find('first', array(
				'conditions'	=>	array(
					'Group.id'	=>	$id
				),
			));
		}
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
		$this->Group->id = $id;
		if (!$this->Group->exists())
		{
			throw new NotFoundException(__('Invalid group'));
		}
		$this->set('group', $this->Group->find('first', array(
			'conditions'	=>	array(
				'Group.id'	=>	$id
			),
		)));
	}
}
