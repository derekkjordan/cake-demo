<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper 
{
	protected $allowed_links = array(
		array('members','register'),
		array('members','login'),
	);

    protected $pretty_date_format = 'F j, Y';
    protected $pretty_time_format = 'g:i a';
    protected $pretty_datetime_format = '';

    function __construct(View $View, $settings = array())
    {
    	parent::__construct($View, $settings);

    	// concat date and time formats for convenience
    	$this->pretty_datetime_format = $this->pretty_date_format.' '.$this->pretty_time_format;
    }

	protected function _aclUrlCheck($url,$permissions)
	{

		if (
			!empty($url['controller'])
			&&
			!empty($url['action'])
			&&
			!in_array($url['controller'], array('mailto:','javascript:void(0)','#'))
			&&
			!in_array(array($url['controller'],$url['action']), $this->allowed_links)
			&&
			!in_array('controllers/'.Inflector::camelize($url['controller']).'/'.strtolower(Inflector::camelize($url['action'])),$permissions)
		)
		{
			return false;
		}
		return true;
	}

	public function shorterString($string, $length = 100)
	{
		if (strlen($string)<$length) 
		{
			return $string;
		}
		return substr($string, 0, $length).'...';
	}

	public function prettyDateTime($datetime_str)
	{
		return date($this->pretty_datetime_format,strtotime($datetime_str));
	}

	public function prettyDate($date_str)
	{
		return date($this->pretty_date_format,strtotime($date_str));
	}

	public function prettyTime($time_str)
	{
		return date($this->pretty_time_format,strtotime($time_str));
	}

}
