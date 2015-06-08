<?php
App::uses('AppController', 'Controller');
/**
 * Tags Controller
 *
 * @property Tag $Tag
 * @property PaginatorComponent $Paginator
 */
class TagsController extends AppController
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
		$this->Tag->recursive = 0;
		$this->set('tags', $this->Paginator->paginate());
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
			$this->Tag->create();
			if ($this->Tag->save($this->request->data))
			{
				$this->_successFlash(__('The tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The tag could not be saved. Please, try again.'));
			}
		}
		$posts = $this->Tag->Post->find('list');
		$this->set(compact('posts'));
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
		$this->Tag->id = $id;
		if (!$this->Tag->exists())
		{
			throw new NotFoundException(__('Invalid tag'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tag->delete())
		{
			$this->_successFlash(__('The tag has been deleted.'));
		}
		else
		{
			$this->_errorFlash(__('The tag could not be deleted. Please, try again.'));
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
		$this->Tag->id = $id;
		if (!$this->Tag->exists())
		{
			throw new NotFoundException(__('Invalid tag'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->Tag->save($this->request->data))
			{
				$this->_successFlash(__('The tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The tag could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->Tag->find('first', array(
				'conditions'	=>	array(
					'Tag.id'	=>	$id
				),
			));
		}
		$posts = $this->Tag->Post->find('list');
		$this->set(compact('posts'));
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
		$this->Tag->id = $id;
		if (!$this->Tag->exists())
		{
			throw new NotFoundException(__('Invalid tag'));
		}
		$this->set('tag', $this->Tag->find('first', array(
			'conditions'	=>	array(
				'Tag.id'	=>	$id
			),
		)));
	}
}
