<?php
/*
 * CakePHP database schema for single blog application with random data generator.
 */
App::uses('ClassRegistry', 'Utility');
class AppSchema extends CakeSchema {

	public $categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'post_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'comment' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => false, 'default' => 'draft', 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'post_id' => array('column' => 'post_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $posts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'featured' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'published' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'category_id' => array('column' => 'category_id', 'unique' => 0), 'user_id' => array('column' => 'user_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $posts_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'post_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'tag_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'post_id' => array('column' => 'post_id', 'unique' => 0), 'tag_id' => array('column' => 'tag_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 255),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'slug' => array('column' => 'slug', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);
	public $groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'state' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'zip' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'web' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'group_id' => array('column' => 'group_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	/**
	 * Generate some randomized data matching field format
	 * 
	 * Schema callbacks (before and after) are fired foreach table, so we are using destructor here.
	 */
	public function __destruct() {
		$config = array(
			'categories' => 0,
			'comments' => 0,
			'posts' => 0,
			'posts_tags' => 0,
			'tags' => 0,
			'groups' => 0,
			'users' => 0,
		);

		foreach ($config as $table => $numRecords) {
			$model = ClassRegistry::init($table);
			$model->getDataSource()->cacheMethods = false;

			for ($i = 1; $i <= $numRecords; $i++) {
				$data = $this->{$table}($config);
				if (is_array($data)) {
					$data['created'] = date('Y-m-d H:i:s', strtotime('-'. rand(100, 9999) . ' minutes'));
					$data['modified'] = date('Y-m-d H:i:s', strtotime('-'. rand(100, 9999) . ' minutes'));
					$model->create();
					$model->save($data, false);
				}
			}
		}
	}

	protected function categories() {
		return array(
			'name' => $this->lorem(2),
			'slug' => $this->lorem(2),
			'description' => $this->lorem(rand(4, 12)) . '.'
		);
	}

	protected function comments($config) {
		return array(
			'post_id' => rand(1, $config['posts']),
			'user_id' => rand(1, $config['users']),
			'title' => $this->lorem(rand(2, 7)),
			'comment' => $this->lorem(rand(3, 100)) . '.'
		);
	}

	protected function posts($config) {
		return array(
			'user_id' => rand(1, $config['users']),
			'category_id' => rand(1, $config['categories']),
			'title' => $this->lorem(rand(4, 9)),
			'description' => $this->lorem(rand(9, 22)) . '.',
			'body' => $this->lorem(rand(200, 800)) . '.',
			'published' => 1,
			'featured' => rand(1, 0),
		);
	}

	protected function posts_tags($config) {
		static $i = 0;
		$i++;
		if ($i > $config['posts'] || $i > $config['tags']) {
			return false;
		}

		return array(
			'post_id' => $i,
			'tag_id' => $i,
		);
	}

	protected function tags() {
		return array(
			'name' => $this->lorem(1),
			'slug' => strtolower($this->lorem(1)),
			'weight' => rand(1, 9),
		);
	}

	protected function groups() {
		return array(
			'name' => $this->lorem(1),
			'description' => $this->lorem(1),
		);
	}

	protected function users() {
		return array(
			'group_id' => rand(1, $config['posts']),
			'first_name' => ucfirst($this->lorem(1)) . ' ' . ucfirst($this->lorem(1)),
			'last_name' => ucfirst($this->lorem(1)) . ' ' . ucfirst($this->lorem(1)),
			'email' => lcfirst($this->lorem(1)) . '@' . lcfirst($this->lorem(1)) . '.com',
			'password' => md5($this->lorem(1)),
			'address' => $this->lorem(3),
			'city' => $this->lorem(1),
			'state' => $this->lorem(1),
			'phone' => rand(200, 999) . '-' . rand(200, 999) . '-' . rand(0, 9999),
			'mobile_phone' => rand(200, 999) . '-' . rand(200, 999) . '-' . rand(0, 9999),
			'zip' => rand(10000, 99999),
			'web' => 'http://www.' . lcfirst($this->lorem(1)) . '.com',
		);
	}

	/**
	 * Lorem Ipsum words generator
	 * 
	 * @param integer $numWords Numer of words to generate
	 * @return string "Lorem ipsum" words with first letter upper cased.
	 */
	protected function lorem($numWords = 1) {
		$words = "Lorem ipsum dolor sit amet consectetur adipiscing elit Vestibulum blandit interdum dignissim "
			. "libero eleifend sit amet Vivamus dolor sed tortor congue posuere Donec varius congue "
			. "pulvinar ante imperdiet vel Mauris orci nisl egestas dapibus malesuada blandit nisi Cras "
			. "ligula sit amet mauris dictum eleifend libero Proin pellentesque auctor vitae tincidunt quis "
			. "lacus Phasellus turpis nibh sollicitudin consequat quis aliquet Morbi vitae diam tortor  "
			. "Quisque tellus vestibulum sed congue sed venenatis at risus Integer consectetur lacinia "
			. "diam tristique leo fringilla Donec fermentum congue congue Cum sociis natoque penatibus "
			. "et magnis dis parturient montes nascetur ridiculus mus Donec mollis orci euismod blandit "
			. "tincidunt vitae consectetur Maecenas sagittis placerat sodales ullamcorper  mperdiet ligula ";

		$list = explode(' ', $words);
		shuffle($list);
		$out = array();
		for ($i = 0; $i < $numWords; $i++) {
			if (isset($list[$i])) {
				$out[] = $list[$i];
			}
		}

		if ($numWords === 1) {
			$out = trim($out[0]);
		} else {
			$out = implode(' ', $out);
		}
		
		return ucfirst($out);

	}

}
