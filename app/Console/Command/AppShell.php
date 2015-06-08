<?php
/**
 * AppShell file
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
 * @since         CakePHP(tm) v 2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Shell', 'Console');

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class AppShell extends Shell
{

	protected $_commands		= array();
	protected $_defaultCommand	= 'Q';

	public function startup()
	{
		parent::startup();

		// all of our shells have the quit command as q. added here so it can be the last item in the list
		$this->_commands['Q'] = array(
			'method'	=>	'quit',
			'title'		=>	'Quit',
			// 'argv'		=>	array(),
		);
		$this->_setStyles();
	}

	public function main()
	{
		$this->out(null, 2);
		$this->out(__('Welcome to the %s Shell!', $this->_style($this->name, 'info')), 0);
		$this->hr(1);
	}

	public function quit()
	{
		$this->_stop();
	}

	protected function _generateRandomString($len=0, $chars='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
	{
		$out = '';

		if ( !$len )
		{
			$len = rand(3, 13);
		}

		for ($i=0; $i<$len; $i++ )
		{
			$out .= $chars{rand(0, strlen($chars)-1)};
		}
		return $out;
	}

/**
 * print an array to stdout using print_r
 * 
 * @return void
 */
	protected function _pr($arr = array(), $newlines = 1, $level = Shell::NORMAL)
	{
		$this->out(print_r($arr, true), $newlines, $level);
	}

/**
 * promts the user to choose one of the available AppShell::_commands to run (choice is case insensitive)
 * 
 * @return void
 */
	protected function _promptForCommand()
	{
		$options = array();

		foreach ($this->_commands as $choice => $settings)
		{
			$choice_pos = strpos($settings['title'], $choice);
			$this->_qout(substr_replace($settings['title'], '['.$choice.']', $choice_pos, strlen($choice)));
		}

		$user_choice = strtoupper($this->in('What would you like to do?', array_keys($this->_commands), $this->_defaultCommand));
		$this->out(null);

		foreach ($this->params as $param => $isset)
		{
			if ( $isset )
			{
				$options['param'] = '--'.$param;
			}
		}

		if ( !empty($this->_commands[$user_choice]['args']) && is_array($this->_commands[$user_choice]['args']) )
		{
			$options = am($options, $this->_commands[$user_choice]['args']);
		}

		if ( $user_choice == 'Q' )
		{
			$this->_qout('Good bye!', 2);
			$command = 'quit --quiet';
		}
		else
		{
			$command =	$this->_commands[$user_choice]['method'].' '.
						implode(' ',array_values($options));

			$this->_qout(__('Running Command: %s', $this->_style($command, 'info')), 0);
			$this->hr(1);
		}

		$this->dispatchShell(Inflector::underscore($this->name).' '.$command);
	}

/**
 * Set output styles 
 * 
 * available styles from core:
 *		success		Green				Success messages. 
 *		error		Red underlined		Error messages. 
 *		warning		Yellow 				Warning messages. 
 *		info		Cyan				Informational messages. 
 *		comment		Blue				Additional text. 
 *		question	Magenta				Text that is a question.
 * 
 * available style options:
 *		text and background:
 * 			black, red, green, yellow, blue, magenta, cyan, white
 * 
 * 		style: ('style' => true)
 *			bold, underline, blink, reverse
 * 
 * @return void
 */
	protected function _setStyles()
	{
		$this->stdout->styles('u', array('underline' => true));
		$this->stdout->styles('b', array('bold' => true));
	}

/**
 * Wrap $text with $style tag
 * 
 * @param	string	$text	text to be styled
 * @param	string	$style	style tag to apply
 * @return	string
 */
	protected function _style($text, $style)
	{
		return sprintf('<%s>%s</%s>', $style, $text, $style);
	}

/**
 * Build $data into table format. 
 * 
 * First row will be used for headings and automatically bolded and centered
 * Columns will be left aligned by default
 * 
 *		+------------------+------------------+------------------+
 *		|   Left Aligned   |  Center Aligned  |  Right Aligned   |
 *		+------------------+------------------+------------------+
 *		| Data             |       Data       |             Data |
 *		| Really Long Data | Really Long Data | Really Long Data |
 *		+------------------+------------------+------------------+
 * 
 * @param	array	$data		2D array of strings
 * @param	array	$options	see below for available options
 * @return	array	table rows as strings 
 */
	protected function _table($data, $options = array())
	{
		if ( !is_array($data) || !is_array($data[0]) )
		{
			return false;
		}

		$table = array();
		$max_col_widths = array();

		$default_options = array(
			'borderstyle'	=>	array('text' => 'white'),
			'cellDefaults'	=>	array(
				'align'			=>	'left',
				'style'			=>	'',
				'colspan'		=>	1,
			),
			'cellpadding'	=>	1,
			'chars'			=>	array(
				'data'			=>	array(
					'default'		=>	' ',
					'padding'		=>	' ',
					'divider'		=>	'|',
				),
				'divider'		=>	array(
					'default'		=>	'-',
					'padding'		=>	'-',
					'divider'		=>	'+',
				),
			),
		);

		// note: array_merge_recursive does not work the way we need it to
		foreach ($default_options as $option => $value)
		{
			if ( !array_key_exists($option, $options) )
			{
				$options[$option] = $default_options[$option];
			}
			elseif ( is_array($options[$option]) )
			{
				$options[$option] = am($default_options[$option], $options[$option]);
			}
		}

		// set style for border
		$this->stdout->styles('border', $options['borderstyle']);

		// find the longest string in each column
		for ($r=0; $r<count($data); $r++)
		{
			for ($c=0; $c<count($data[$r]); $c++)
			{
				// get the width of this column
				$width = strlen(( is_array($data[$r][$c]) ? $data[$r][$c][0] : $data[$r][$c] ));

				// update max column width
				if (
					!array_key_exists($c, $max_col_widths)
					||
					$width > $max_col_widths[$c]
				)
				{
					$max_col_widths[$c] = $width;
				}
			}
		}

		// row like: +----+-----+ 
		$divider_row = $options['chars']['divider']['divider'];
		for ($w=0; $w<count($max_col_widths); $w++)
		{
			$divider_row .= str_repeat($options['chars']['divider']['padding'], $options['cellpadding']).
							str_repeat($options['chars']['divider']['default'], $max_col_widths[$w]).
							str_repeat($options['chars']['divider']['padding'], $options['cellpadding']).
							$options['chars']['divider']['divider'];
		}
		$divider_row = $this->_style($divider_row, 'border');

		// build table
		for ($r=0; $r<count($data); $r++)
		{
			// initialize row with divider char
			$row = $this->_style($options['chars']['data']['divider'], 'border');

			// output divider before first row
			if ( $r === 0 )
			{
				$table[] = $divider_row;
			}

			// build row by columns
			for ($c=0; $c<count($data[$r]); $c++)
			{
				$column = '';

				// if the cell is an array, the [0] should be the text and [1] should be cell-specific options
				if ( is_array($data[$r][$c]) )
				{
					$text = $data[$r][$c][0];
					$cell_options = am($options['cellDefaults'], $data[$r][$c][1]);
				}
				else
				{
					$text = $data[$r][$c];
					$cell_options = $options['cellDefaults'];
				}

				// if header alignment has not been specified, center it
				if ( $r === 0 && empty($data[$r][$c][1]['align']) )
				{
					$cell_options['align'] = 'center';
				}

				// set STR_PAD constant based on alignment, default left align
				$pad_type = STR_PAD_RIGHT;
				if ( $cell_options['align'] == 'right' )
				{
					$pad_type = STR_PAD_LEFT;
				}
				elseif ( $cell_options['align'] == 'center' )
				{
					$pad_type = STR_PAD_BOTH;
				}

				// wrap the padded text with cellpadding
				$column .=	str_repeat($options['chars']['data']['padding'], $options['cellpadding']).
							str_pad($text, $max_col_widths[$c], $options['chars']['data']['default'], $pad_type).
							str_repeat($options['chars']['data']['padding'], $options['cellpadding']).
							$this->_style($options['chars']['data']['divider'], 'border');

				// if header style has not been specified, use bold
				if ( $r === 0 && empty($cell_options['style']) )
				{
					$cell_options['style'] = 'b';
				}

				// replace text with styled text after it has been padded so the tags don't break the column
				if ( !empty($cell_options['style']) )
				{
					$column = str_replace($text, $this->_style($text, $cell_options['style']), $column);
				}

				$row .= $column;
			}

			// add the row to the table
			$table[] = $row;

			// add divider after headers
			if ( $r === 0 )
			{
				$table[] = $divider_row;
			}
		}

		// if we output more than a header, add a final divider row
		if ( $r > 1 )
		{
			$table[] = $divider_row;
		}
		return $table;
	}

/**
 * Outputs a single or multiple messages to stdout when level is QUIET.
 * If no parameters are passed, outputs just a newline.
 *
 * @param string|array $message A string or a an array of strings to output
 * @param integer $newlines Number of newlines to append
 * @return integer|boolean Returns the number of bytes returned from writing to stdout.
 * @link http://book.cakephp.org/2.0/en/console-and-shells.html#Shell::out
 */
	protected function _qout($message = null, $newlines = 1)
	{
		return $this->out($message, $newlines, Shell::QUIET);
	}

/**
 * Outputs a single or multiple messages to stdout when level is VERBOSE.
 * If no parameters are passed, outputs just a newline.
 *
 * @param string|array $message A string or a an array of strings to output
 * @param integer $newlines Number of newlines to append
 * @return integer|boolean Returns the number of bytes returned from writing to stdout.
 * @link http://book.cakephp.org/2.0/en/console-and-shells.html#Shell::out
 */
	protected function _vout($message = null, $newlines = 1)
	{
		return $this->out($message, $newlines, Shell::VERBOSE);
	}
}
