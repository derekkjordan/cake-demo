<?php

App::import('Helper','Html');

class ExtendedHtmlHelper extends HtmlHelper 
{
	public $helpers = array('Session');

	// public $allowed_links = array(); // see AppHelper

/**
 * Creates an HTML link.
 *
 * If $url starts with "http://" this is treated as an external link. Else,
 * it is treated as a path to controller/action and parsed with the
 * HtmlHelper::url() method.
 *
 * If the $url is empty, $title is used instead.
 *
 * ### Options
 *
 * - `escape` Set to false to disable escaping of title and attributes.
 * - `escapeTitle` Set to false to disable escaping of title. (Takes precedence over value of `escape`)
 * - `confirm` JavaScript confirmation message.
 *
 * @param string $title The content to be wrapped by <a> tags.
 * @param string|array $url Cake-relative URL or array of URL parameters, or external URL (starts with http://)
 * @param array $options Array of options and HTML attributes.
 * @param string $confirmMessage JavaScript confirmation message.
 * @return string An `<a />` element.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::link
 */
	public function link($title, $url = null, $options = array(), $confirmMessage = false)
	{
		$escapeTitle = true;
		if ($url !== null) 
		{
			$url = $this->url($url);
		}
		else
		{
			$url = $this->url($title);
			$title = htmlspecialchars_decode($url, ENT_QUOTES);
			$title = h(urldecode($title));
			$escapeTitle = false;
		}

		if (isset($options['escapeTitle'])) 
		{
			$escapeTitle = $options['escapeTitle'];
			unset($options['escapeTitle']);
		}
		elseif (isset($options['escape'])) 
		{
			$escapeTitle = $options['escape'];
		}

		if ($escapeTitle === true) 
		{
			$title = h($title);
		}
		elseif (is_string($escapeTitle)) 
		{
			$title = htmlentities($title, ENT_QUOTES, $escapeTitle);
		}

		if (!empty($options['confirm'])) 
		{
			$confirmMessage = $options['confirm'];
			unset($options['confirm']);
		}
		if ($confirmMessage) 
		{
			$options['onclick'] = $this->_confirm($confirmMessage, 'return true;', 'return false;', $options);
		}
		elseif (isset($options['default']) && !$options['default']) 
		{
			if (isset($options['onclick'])) 
			{
				$options['onclick'] .= ' ';
			}
			else
			{
				$options['onclick'] = '';
			}
			$options['onclick'] .= 'event.returnValue = false; return false;';
			unset($options['default']);
		}

		// modification for acl

		$this->allowed_links = am($this->allowed_links,array(
			array('auction_items','items'),
			array('members','login'),
		));

		$parsed_url = Router::parse($url);

		if (
			empty($options['override'])
			&&
			!empty($parsed_url['controller'])
			&&
			!empty($parsed_url['action'])
			&&
			!in_array($parsed_url['controller'], array('mailto:','javascript:void(0)','#'))
			&&
			strpos($parsed_url['controller'], '#') === false
			&&
			!in_array(array($parsed_url['controller'],$parsed_url['action']), $this->allowed_links)
			&&
			!$this->Session->check('Auth.User.Permissions.controllers/'.Inflector::camelize($parsed_url['controller']).'/'.strtolower(Inflector::underscore($parsed_url['action'])))
		)
		{
			
			return false;
		}



		// end acl modification

		return sprintf($this->_tags['link'], $url, $this->_parseAttributes($options), $title);
	}


/**
 * Creates a formatted IMG element.
 *
 * This method will set an empty alt attribute if one is not supplied.
 *
 * ### Usage:
 *
 * Create a regular image:
 *
 * `echo $this->Html->image('cake_icon.png', array('alt' => 'CakePHP'));`
 *
 * Create an image link:
 *
 * `echo $this->Html->image('cake_icon.png', array('alt' => 'CakePHP', 'url' => 'http://cakephp.org'));`
 *
 * ### Options:
 *
 * - `url` If provided an image link will be generated and the link will point at
 *   `$options['url']`.
 * - `fullBase` If true the src attribute will get a full address for the image file.
 * - `plugin` False value will prevent parsing path as a plugin
 *
 * @param string $path Path to the image file, relative to the app/webroot/img/ directory.
 * @param array $options Array of HTML attributes. See above for special options.
 * @return string completed img tag
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/html.html#HtmlHelper::image
 */
	public function image($path, $options = array())
	{
		$path = $this->assetUrl($path, $options + array('pathPrefix' => Configure::read('App.imageBaseUrl')));
		$options = array_diff_key($options, array('fullBase' => null, 'pathPrefix' => null));

		if (!isset($options['alt']))
		{
			$options['alt'] = '';
		}

		$url = false;
		if (!empty($options['url']))
		{
			$url = $options['url'];
			unset($options['url']);
		}

		$image = sprintf($this->_tags['image'], $path, $this->_parseAttributes($options, null, '', ' '));

		if ($url)
		{
			$link_options = array();

			if ( isset($options['target']) )
			{
				$link_options['target'] = $options['target'];
			}

			return sprintf($this->_tags['link'], $this->url($url), $this->_parseAttributes($link_options, null, '', ' '), $image);
		}
		return $image;
	}

	public function numberCell($value)
	{
		return array(number_format($value), array('class'=>'number'));
	}

	public function moneyCell($value)
	{
		return array('$'.number_format($value,2), array('class'=>'money'));
	}

	public function percentCell($value)
	{
		return array('%'.($value*100), array('class'=>'percent'));
	}

	public function textCell($value)
	{
		return array(h($value), array('class'=>'text'));
	}

	public function actionsCell($value)
	{
		return array($value, array('class'=>'actions'));
	}

	public function tableTotalsRow(array $data, array $oddTrOptions = null, array $evenTrOptions = null, $useCount = false, $continueOddEven = true )
	{
		$oddTrOptions = am(array('class'=>'totals'), $oddTrOptions);
		$evenTrOptions = am(array('class'=>'totals'), $evenTrOptions);

		return $this->tableCells($data, $oddTrOptions, $evenTrOptions, $useCount, $continueOddEven);
	}

}

