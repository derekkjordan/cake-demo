<?php
App::uses('AppController', 'Controller');
/**
 * Comments Controller
 *
 * @property Comment $Comment
 * @property PaginatorComponent $Paginator
 */
class CommentsController extends AppController
{

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index()
	{
		$this->Comment->recursive = 0;
		$this->set('comments', $this->Paginator->paginate());
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
			$this->Comment->create();
			if ($this->Comment->save($this->request->data))
			{
				$this->_successFlash(__('The comment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The comment could not be saved. Please, try again.'));
			}
		}
		$posts = $this->Comment->Post->find('list');
		$users = $this->Comment->User->find('list');
		$this->set(compact('posts', 'users'));
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
		$this->Comment->id = $id;
		if (!$this->Comment->exists())
		{
			throw new NotFoundException(__('Invalid comment'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Comment->delete())
		{
			$this->_successFlash(__('The comment has been deleted.'));
		}
		else
		{
			$this->_errorFlash(__('The comment could not be deleted. Please, try again.'));
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
		$this->Comment->id = $id;
		if (!$this->Comment->exists())
		{
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->Comment->save($this->request->data))
			{
				$this->_successFlash(__('The comment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The comment could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->Comment->find('first', array(
				'conditions'	=>	array(
					'Comment.id'	=>	$id
				),
			));
		}
		$posts = $this->Comment->Post->find('list');
		$users = $this->Comment->User->find('list');
		$this->set(compact('posts', 'users'));
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
		$this->Comment->id = $id;
		if (!$this->Comment->exists())
		{
			throw new NotFoundException(__('Invalid comment'));
		}
		$this->set('comment', $this->Comment->find('first', array(
			'conditions'	=>	array(
				'Comment.id'	=>	$id
			),
		)));
	}
}
