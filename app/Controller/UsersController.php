<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController
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
	}

/**
 * index method
 *
 * @return void
 */
	public function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
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
			$this->User->create();
			if ($this->User->save($this->request->data))
			{
				$this->_successFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
		$this->User->id = $id;
		if (!$this->User->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete())
		{
			$this->_successFlash(__('The user has been deleted.'));
		}
		else
		{
			$this->_errorFlash(__('The user could not be deleted. Please, try again.'));
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
		$this->User->id = $id;
		if (!$this->User->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->User->save($this->request->data))
			{
				$this->_successFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->User->find('first', array(
				'conditions'	=>	array(
					'User.id'	=>	$id
				),
			));
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	public function login()
	{
		if ($this->request->is('post'))
		{
			if ($this->Auth->login())
			{
				$acos = $this->Acl->Aco->children();

				$permissions = array();

				$group_id = $this->Session->read('Auth.User.group_id');

				foreach ($acos as &$aco)
				{
					$aco_chain = $this->Acl->Aco->getPath($aco['Aco']['id']);
					$path = array();

					foreach ($aco_chain as &$link)
					{
						$path[] = $link['Aco']['alias'];
					}

					$str_path = implode('/', $path);

					if ($this->Acl->check(array('model'=>'Group','foreign_key'=>$group_id), $str_path))
					{
						$permissions[$str_path] = true;
					}
				}
				$this->Session->write('Auth.User.Permissions',$permissions);

				$this->_successFlash('Welcome, '.$this->Session->read('Auth.User.first_name').'!');
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Session->setFlash(__('Invalid username or password, try again'));
		}
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
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
		$this->User->id = $id;
		if (!$this->User->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->find('first', array(
			'conditions'	=>	array(
				'User.id'	=>	$id
			),
		)));
	}
}
