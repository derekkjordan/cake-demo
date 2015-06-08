<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class CategoriesController extends AppController
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
		$this->Category->recursive = 0;
		$this->set('categories', $this->Paginator->paginate());
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
			$this->Category->create();
			if ($this->Category->save($this->request->data))
			{
				$this->_successFlash(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The category could not be saved. Please, try again.'));
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
		$this->Category->id = $id;
		if (!$this->Category->exists())
		{
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Category->delete())
		{
			$this->_successFlash(__('The category has been deleted.'));
		}
		else
		{
			$this->_errorFlash(__('The category could not be deleted. Please, try again.'));
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
		$this->Category->id = $id;
		if (!$this->Category->exists())
		{
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put')))
		{
			if ($this->Category->save($this->request->data))
			{
				$this->_successFlash(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->_errorFlash(__('The category could not be saved. Please, try again.'));
			}
		}
		else
		{
			$this->request->data = $this->Category->find('first', array(
				'conditions'	=>	array(
					'Category.id'	=>	$id
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
		$this->Category->id = $id;
		if (!$this->Category->exists())
		{
			throw new NotFoundException(__('Invalid category'));
		}
		$this->set('category', $this->Category->find('first', array(
			'conditions'	=>	array(
				'Category.id'	=>	$id
			),
		)));
	}
}
