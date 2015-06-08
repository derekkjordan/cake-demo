<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $components = array(
		'Acl',
		'Auth'	=>	array(
			'authError'		=>	'You shall not pass!!!',
			'authenticate'	=>	array(
				'Form' =>	array(
					'fields'	=>	array(
						'username'	=>	'email'
					)
				)
			),
			'authorize'	=>	array(
				'Actions'	=>	array(
					'actionPath'	=>	'controllers'
				),
			),
		),
		'DebugKit.Toolbar',
		'Session'
	);

	public $helpers = array(
		'Html',
		'Form',
		'Session'
	);

	public function beforeFilter()
	{
		//Configure AuthComponent
		$this->Auth->loginAction = array(
			'controller'	=>	'users',
			'action'		=>	'login',
		);
		$this->Auth->logoutRedirect = array(
			'controller'	=>	'users',
			'action'		=>	'login',
		);
		$this->Auth->loginRedirect = array(
			'controller'	=>	'users',
			'action'		=>	'index',
		);
	}

//		                                                                           
//		EEEEE  RRR    RRR    OOOOO  RRR         FFFFF  L       AAA   SSSSS  H   H  
//		E      R  R   R  R   O   O  R  R        F      L      A   A  S      H   H  
//		EEE    RRR    RRR    O   O  RRR         FFF    L      AAAAA  SSSSS  HHHHH  
//		E      R  R   R  R   O   O  R  R        F      L      A   A      S  H   H  
//		EEEEE  R   R  R   R  OOOOO  R   R       F      LLLLL  A   A  SSSSS  H   H  
//
	protected function _errorFlash($message = '')
	{
		$this->Session->setFlash($message,'default',array('class'=>'error'));
	}


//		                                                                                                     
//		GGGGG  EEEEE  TTTTT       DDDD    AAA   TTTTT  EEEEE  SSSSS        AAA   FFFFF  TTTTT  EEEEE  RRR    
//		G      E        T         D   D  A   A    T    E      S           A   A  F        T    E      R  R   
//		G  GG  EEE      T         D   D  AAAAA    T    EEE    SSSSS       AAAAA  FFF      T    EEE    RRR    
//		G   G  E        T         D   D  A   A    T    E          S       A   A  F        T    E      R  R   
//		GGGGG  EEEEE    T         DDDD   A   A    T    EEEEE  SSSSS       A   A  F        T    EEEEE  R   R  
//
	protected function _getDatesAfter($date_str = '', $count = 7, $period = 'day', $format = 'Y-m-d')
	{
		$dates = array();

		for($i=1; $i<=$count; $i++)
		{
			$dates[] = date($format,strtotime('+'.$i.' '.$period.'s',strtotime($date_str)));
		}

		return $dates;
	}
	
//		                                                      
//		GGGGG  EEEEE  TTTTT       M   M  IIIII  M   M  EEEEE  
//		G      E        T         MM MM    I    MM MM  E      
//		G  GG  EEE      T         M M M    I    M M M  EEE    
//		G   G  E        T         M   M    I    M   M  E      
//		GGGGG  EEEEE    T         M   M  IIIII  M   M  EEEEE  
//
	protected function _getMime($file) 
	{
		if (function_exists("finfo_file")) 
		{
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
			$mime = finfo_file($finfo, $file);
			finfo_close($finfo);
			return $mime;
		}
		else if (!stristr(ini_get("disable_functions"), "shell_exec"))
		{
			// http://stackoverflow.com/a/134930/1593459
			$file = escapeshellarg($file);
			$mime = shell_exec("file -bi " . $file);
			return $mime;
		}
		else if (function_exists("mime_content_type"))
		{
			$mime = mime_content_type($file);
			return $mime;
		}
		else
		{
			return false;
		}
	} // get_mime

//		                                                                                                                                 
//		RRR     AAA   N   N  DDDD   OOOOO  M   M  IIIII  ZZZZZ  EEEEE       FFFFF  IIIII  L      EEEEE       N   N   AAA   M   M  EEEEE  
//		R  R   A   A  NN  N  D   D  O   O  MM MM    I       Z   E           F        I    L      E           NN  N  A   A  MM MM  E      
//		RRR    AAAAA  N N N  D   D  O   O  M M M    I      Z    EEE         FFF      I    L      EEE         N N N  AAAAA  M M M  EEE    
//		R  R   A   A  N  NN  D   D  O   O  M   M    I     Z     E           F        I    L      E           N  NN  A   A  M   M  E      
//		R   R  A   A  N   N  DDDD   OOOOO  M   M  IIIII  ZZZZZ  EEEEE       F      IIIII  LLLLL  EEEEE       N   N  A   A  M   M  EEEEE  
//
	protected function _randomizeFileName($filename = '')
	{
		$extension = substr($filename, strrpos($filename, '.'));
		$name = substr($filename, 0, strrpos($filename, '.'));

		$name .= '_'.rand(123456789,987654321);

		return $name.$extension;
	}

//		                                                                    
//		SSSSS  EEEEE  N   N  DDDD        EEEEE  M   M   AAA   IIIII  L      
//		S      E      NN  N  D   D       E      MM MM  A   A    I    L      
//		SSSSS  EEE    N N N  D   D       EEE    M M M  AAAAA    I    L      
//		    S  E      N  NN  D   D       E      M   M  A   A    I    L      
//		SSSSS  EEEEE  N   N  DDDD        EEEEE  M   M  A   A  IIIII  LLLLL  
//
	protected function _sendEmail($options = array())
	{
		if ( empty($options['emailFormat']) )
		{
			$options['emailFormat'] = 'html';
		}
		if ( empty($options['from']) )
		{
			$options['from'] = array('members@morrisburnerhotel.com' => 'The Morris Burner Hotel');
		}
		if ( empty($options['sender']) )
		{
			$options['sender'] = array('members@morrisburnerhotel.com' => 'The Morris Burner Hotel');
		}
		if ( empty($options['body']) )
		{
			$options['body'] = null;
		}

		$Email = new CakeEmail();
		$Email	->from($options['from'])
				->sender($options['sender'])
				->emailFormat($options['emailFormat'])
				->to($options['to'])
				->subject($options['subject']);

		if ( !empty($options['template'][0]) && !empty($options['template'][1]) )
		{
			$Email	->template($options['template'][0],$options['template'][1])
					->viewVars($options['viewVars']);
		}
		
		if ( !empty($options['debug']) && $options['debug'] )
		{
			$Email	->transport('Debug');
			pr($Email->send($options['body']));
			exit;
		}
		
		if ( $Email->send($options['body']) )
		{
			return true;
		}
		
		return false;
	}

//		                                                                                         
//		SSSSS  U   U  CCCCC  CCCCC  EEEEE  SSSSS  SSSSS       FFFFF  L       AAA   SSSSS  H   H  
//		S      U   U  C      C      E      S      S           F      L      A   A  S      H   H  
//		SSSSS  U   U  C      C      EEE    SSSSS  SSSSS       FFF    L      AAAAA  SSSSS  HHHHH  
//		    S  U   U  C      C      E          S      S       F      L      A   A      S  H   H  
//		SSSSS  UUUUU  CCCCC  CCCCC  EEEEE  SSSSS  SSSSS       F      LLLLL  A   A  SSSSS  H   H  
//
	protected function _successFlash($message = '')
	{
		$this->Session->setFlash($message, 'default', array('class'=>'success'));
	}

//		                                                                           
//		U   U  PPPPP  L      OOOOO   AAA   DDDD        FFFFF  IIIII  L      EEEEE  
//		U   U  P   P  L      O   O  A   A  D   D       F        I    L      E      
//		U   U  PPPPP  L      O   O  AAAAA  D   D       FFF      I    L      EEE    
//		U   U  P      L      O   O  A   A  D   D       F        I    L      E      
//		UUUUU  P      LLLLL  OOOOO  A   A  DDDD        F      IIIII  LLLLL  EEEEE  
//
	protected function _uploadFile(array $uploaded_file, array $options)
	{

		if ( empty($options['delete_old']) )
		{
			$options['delete_old'] = false;
		}

		// required options
		if ( empty($options['max_size']) || empty($options['type']) )
		{
			return false;
		}
		
		if ( $options['delete_old'] )
		{
			// required for deletion
			if ( 
				empty($options['model'])
				||
				empty($options['model']['className'])
				||
				empty($options['model']['field'])
				||
				empty($options['model']['conditions'])
			)
			{
				return false;
			}
		}

		$allowed_mimes = array(
			'image'	=>	array('image/gif','image/jpeg','image/png')
		);

		$upload_path = 'uploads/';

		if ( !empty($options['path']) )	
		{
			$upload_path .= $options['path'];
		}
		
		$file_name = $uploaded_file['name'];

		if ( $uploaded_file['error']<1 )
		{
			if ( $uploaded_file['size']<$options['max_size'] ) 
			{

				$temp_file = $uploaded_file['tmp_name'];

				$mime_info = explode(";",$this->_getMime($temp_file));

				if ( in_array($mime_info[0],$allowed_mimes[$options['type']]) ) 
				{
					// create the member's directory if it does not exist
					if ( !file_exists($upload_path) )
					{
						mkdir($upload_path);
					}

					// store new file
					if ( move_uploaded_file($temp_file, $upload_path.$file_name) )
					{
						if ( $options['delete_old'] )
						{
							// get old file's name
							$old_file_name = $this->{$options['model']['className']}->field(
								$options['model']['field'],
								$options['model']['conditions']
							);

							// delete the old file
							if ( file_exists($upload_path.$old_file_name) )
							{
								unlink($upload_path.$old_file_name);
							}
						}	

						// success!
						return $file_name;
					}
				}
				else 
				{
					$this->_errorFlash(__(
						'We\'re sorry, but there was an encoding problem with the file you uploaded. File name: %s',
						$file_name
					));
				}
			}
			else 
			{
				$this->_errorFlash(__(
					'We\'re sorry, but the file you uploaded is larger than the maximum allowed size (%s MB). Please try a smaller file. File name: %s, size: %s MB',
					$options['max_size']/1048576,
					$file_name,
					number_format($uploaded_file['size']/1048576,1)
				));
			}
		}
		else
		{
			$this->_errorFlash(__(
				'We\'re sorry, but there was a problem with a file you uploaded. Please try again. File name: %s',
				$file_name
			));
		}
		return false;
	} // _uploadFile


	protected function _startTransaction($model = 'User')
	{
		$this->{$model}->begin();
	}

	protected function _endTransaction($success = false, $model = 'User')
	{
		if ( $success )
		{
			$this->{$model}->commit();
		}
		else
		{
			$this->{$model}->rollback();
		}
	}
}
