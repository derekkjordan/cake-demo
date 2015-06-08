<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 */
class PostsController extends AppController
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
		$this->Post->recursive = 0;
		$this->set('posts', $this->Paginator->paginate());
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
			$this->Post->create();
			if ($this->Post->save($this->request->data))
			{
				$this->_successFlash(__('The post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The post could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Post->Category->find('list');
		$users = $this->Post->User->find('list');
		$tags = $this->Post->Tag->find('list');
		$this->set(compact('categories', 'users', 'tags'));
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
		$this->Post->id = $id;
		if (!$this->Post->exists())
		{
			throw new NotFoundException(__('Invalid post'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Post->delete())
		{
			$this->_successFlash(__('The post has been deleted.'));
		}
		else
		{
			$this->_errorFlash(__('The post could not be deleted. Please, try again.'));
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
		$this->Post->id = $id;
		if (!$this->Post->exists())
		{
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->Post->save($this->request->data))
			{
				$this->_successFlash(__('The post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The post could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->Post->find('first', array(
				'conditions'	=>	array(
					'Post.id'	=>	$id
				),
			));
		}
		$categories = $this->Post->Category->find('list');
		$users = $this->Post->User->find('list');
		$tags = $this->Post->Tag->find('list');
		$this->set(compact('categories', 'users', 'tags'));
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
		$this->Post->id = $id;
		if (!$this->Post->exists())
		{
			throw new NotFoundException(__('Invalid post'));
		}
		$this->set('post', $this->Post->find('first', array(
			'conditions'	=>	array(
				'Post.id'	=>	$id
			),
		)));
	}
}
