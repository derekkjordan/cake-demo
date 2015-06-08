<?php

App::import('Helper','Form');

class ExtendedFormHelper extends FormHelper 
{
	public $helpers = array('Session','Html');

	// public $allowed_links = array(); // see AppHelper

	public $stateOptions = array(
		'AL' => 'Alabama','AK' => 'Alaska','AZ' => 'Arizona','AR' => 'Arkansas','CA' => 'California','CO' => 'Colorado',
		'CT' => 'Connecticut','DE' => 'Delaware','FL' => 'Florida','GA' => 'Georgia','HI' => 'Hawaii','ID' => 'Idaho',
		'IL' => 'Illinois','IN' => 'Indiana','IA' => 'Iowa','KS' => 'Kansas','KY' => 'Kentucky','LA' => 'Louisiana',
		'ME' => 'Maine','MD' => 'Maryland','MA' => 'Massachusetts','MI' => 'Michigan','MN' => 'Minnesota',
		'MS' => 'Mississippi','MO' => 'Missouri','MT' => 'Montana','NE' => 'Nebraska','NV' => 'Nevada',
		'NH' => 'New Hampshire','NJ' => 'New Jersey','NM' => 'New Mexico','NY' => 'New York','NC' => 'North Carolina',
		'ND' => 'North Dakota','OH' => 'Ohio','OK' => 'Oklahoma','OR' => 'Oregon','PA' => 'Pennsylvania',
		'RI' => 'Rhode Island','SC' => 'South Carolina','SD' => 'South Dakota','TN' => 'Tennessee','TX' => 'Texas',
		'UT' => 'Utah','VT' => 'Vermont','VA' => 'Virginia','WA' => 'Washington','WV' => 'West Virginia',
		'WI' => 'Wisconsin','WY' => 'Wyoming'
	);

	public $countryOptions = array(
		'United States of America' => 'United States of America','Afghanistan' => 'Afghanistan','Albania' => 'Albania',
		'Algeria' => 'Algeria','Andorra' => 'Andorra','Angola' => 'Angola',
		'Antigua and Barbuda' => 'Antigua and Barbuda','Argentina' => 'Argentina','Armenia' => 'Armenia',
		'Aruba' => 'Aruba','Australia' => 'Australia','Austria' => 'Austria','Azerbaijan' => 'Azerbaijan',
		'The Bahamas' => 'The Bahamas','Bahrain' => 'Bahrain','Bangladesh' => 'Bangladesh','Barbados' => 'Barbados',
		'Belarus' => 'Belarus','Belgium' => 'Belgium','Belize' => 'Belize','Benin' => 'Benin','Bhutan' => 'Bhutan',
		'Bolivia' => 'Bolivia','Bosnia and Herzegovina' => 'Bosnia and Herzegovina','Botswana' => 'Botswana',
		'Brazil' => 'Brazil','Brunei' => 'Brunei','Bulgaria' => 'Bulgaria','Burkina Faso' => 'Burkina Faso',
		'Burma' => 'Burma','Burundi' => 'Burundi','Cambodia' => 'Cambodia','Cameroon' => 'Cameroon',
		'Canada' => 'Canada','Cape Verde' => 'Cape Verde','Central African Republic' => 'Central African Republic',
		'Chad' => 'Chad','Chile' => 'Chile','China' => 'China','Colombia' => 'Colombia','Comoros' => 'Comoros',
		'Congo, Democratic Republic of the' => 'Congo, Democratic Republic of the',
		'Congo, Republic of the' => 'Congo, Republic of the','Costa Rica' => 'Costa Rica',
		'Cote d\'Ivoire' => 'Cote d\'Ivoire','Croatia' => 'Croatia','Cuba' => 'Cuba','Curacao' => 'Curacao',
		'Cyprus' => 'Cyprus','Czech Republic' => 'Czech Republic','Denmark' => 'Denmark','Djibouti' => 'Djibouti',
		'Dominica' => 'Dominica','Dominican Republic' => 'Dominican Republic',
		'East Timor (see Timor-Leste)' => 'East Timor (see Timor-Leste)','Ecuador' => 'Ecuador','Egypt' => 'Egypt',
		'El Salvador' => 'El Salvador','Equatorial Guinea' => 'Equatorial Guinea','Eritrea' => 'Eritrea',
		'Estonia' => 'Estonia','Ethiopia' => 'Ethiopia','Fiji' => 'Fiji','Finland' => 'Finland','France' => 'France',
		'Gabon' => 'Gabon','The Gambia' => 'The Gambia','Georgia' => 'Georgia','Germany' => 'Germany',
		'Ghana' => 'Ghana','Greece' => 'Greece','Grenada' => 'Grenada','Guatemala' => 'Guatemala','Guinea' => 'Guinea',
		'Guinea-Bissau' => 'Guinea-Bissau','Guyana' => 'Guyana','Haiti' => 'Haiti','Holy See' => 'Holy See',
		'Honduras' => 'Honduras','Hong Kong' => 'Hong Kong','Hungary' => 'Hungary','Iceland' => 'Iceland',
		'India' => 'India','Indonesia' => 'Indonesia','Iran' => 'Iran','Iraq' => 'Iraq','Ireland' => 'Ireland',
		'Israel' => 'Israel','Italy' => 'Italy','Jamaica' => 'Jamaica','Japan' => 'Japan','Jordan' => 'Jordan',
		'Kazakhstan' => 'Kazakhstan','Kenya' => 'Kenya','Kiribati' => 'Kiribati','Korea, North' => 'Korea, North',
		'Korea, South' => 'Korea, South','Kosovo' => 'Kosovo','Kuwait' => 'Kuwait','Kyrgyzstan' => 'Kyrgyzstan',
		'Laos' => 'Laos','Latvia' => 'Latvia','Lebanon' => 'Lebanon','Lesotho' => 'Lesotho','Liberia' => 'Liberia',
		'Libya' => 'Libya','Liechtenstein' => 'Liechtenstein','Lithuania' => 'Lithuania','Luxembourg' => 'Luxembourg',
		'Macau' => 'Macau','Macedonia' => 'Macedonia','Madagascar' => 'Madagascar','Malawi' => 'Malawi',
		'Malaysia' => 'Malaysia','Maldives' => 'Maldives','Mali' => 'Mali','Malta' => 'Malta',
		'Marshall Islands' => 'Marshall Islands','Mauritania' => 'Mauritania','Mauritius' => 'Mauritius',
		'Mexico' => 'Mexico','Micronesia' => 'Micronesia','Moldova' => 'Moldova','Monaco' => 'Monaco',
		'Mongolia' => 'Mongolia','Montenegro' => 'Montenegro','Morocco' => 'Morocco','Mozambique' => 'Mozambique',
		'Namibia' => 'Namibia','Nauru' => 'Nauru','Nepal' => 'Nepal','Netherlands' => 'Netherlands',
		'Netherlands Antilles' => 'Netherlands Antilles','New Zealand' => 'New Zealand','Nicaragua' => 'Nicaragua',
		'Niger' => 'Niger','Nigeria' => 'Nigeria','North Korea' => 'North Korea','Norway' => 'Norway','Oman' => 'Oman',
		'Pakistan' => 'Pakistan','Palau' => 'Palau','Palestinian Territories' => 'Palestinian Territories',
		'Panama' => 'Panama','Papua New Guinea' => 'Papua New Guinea','Paraguay' => 'Paraguay','Peru' => 'Peru',
		'Philippines' => 'Philippines','Poland' => 'Poland','Portugal' => 'Portugal','Qatar' => 'Qatar',
		'Romania' => 'Romania','Russia' => 'Russia','Rwanda' => 'Rwanda',
		'Saint Kitts and Nevis' => 'Saint Kitts and Nevis','Saint Lucia' => 'Saint Lucia',
		'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines','Samoa' => 'Samoa',
		'San Marino' => 'San Marino','Sao Tome and Principe' => 'Sao Tome and Principe',
		'Saudi Arabia' => 'Saudi Arabia','Senegal' => 'Senegal','Serbia' => 'Serbia','Seychelles' => 'Seychelles',
		'Sierra Leone' => 'Sierra Leone','Singapore' => 'Singapore','Sint Maarten' => 'Sint Maarten',
		'Slovakia' => 'Slovakia','Slovenia' => 'Slovenia','Solomon Islands' => 'Solomon Islands','Somalia' => 'Somalia',
		'South Africa' => 'South Africa','South Korea' => 'South Korea','South Sudan' => 'South Sudan',
		'Spain' => 'Spain','Sri Lanka' => 'Sri Lanka','Sudan' => 'Sudan','Suriname' => 'Suriname',
		'Swaziland' => 'Swaziland','Sweden' => 'Sweden','Switzerland' => 'Switzerland','Syria' => 'Syria',
		'Taiwan' => 'Taiwan','Tajikistan' => 'Tajikistan','Tanzania' => 'Tanzania','Thailand' => 'Thailand',
		'Timor-Leste' => 'Timor-Leste','Togo' => 'Togo','Tonga' => 'Tonga',
		'Trinidad and Tobago' => 'Trinidad and Tobago','Tunisia' => 'Tunisia','Turkey' => 'Turkey',
		'Turkmenistan' => 'Turkmenistan','Tuvalu' => 'Tuvalu','Uganda' => 'Uganda','Ukraine' => 'Ukraine',
		'United Arab Emirates' => 'United Arab Emirates','United Kingdom' => 'United Kingdom','Uruguay' => 'Uruguay',
		'Uzbekistan' => 'Uzbekistan','Vanuatu' => 'Vanuatu','Venezuela' => 'Venezuela','Vietnam' => 'Vietnam',
		'Yemen' => 'Yemen','Zambia' => 'Zambia','Zimbabwe' => 'Zimbabwe'
	);

/**
 * Creates an HTML link, but access the URL using the method you specify (defaults to POST).
 * Requires javascript to be enabled in browser.
 *
 * This method creates a `<form>` element. So do not use this method inside an existing form.
 * Instead you should add a submit button using FormHelper::submit()
 *
 * ### Options:
 *
 * - `data` - Array with key/value to pass in input hidden
 * - `method` - Request method to use. Set to 'delete' to simulate HTTP/1.1 DELETE request. Defaults to 'post'.
 * - `confirm` - Can be used instead of $confirmMessage.
 * - Other options is the same of HtmlHelper::link() method.
 * - The option `onclick` will be replaced.
 *
 * @param string $title The content to be wrapped by <a> tags.
 * @param string|array $url Cake-relative URL or array of URL parameters, or external URL (starts with http://)
 * @param array $options Array of HTML attributes.
 * @param boolean|string $confirmMessage JavaScript confirmation message.
 * @return string An `<a />` element.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::postLink
 */
	public function postLink($title, $url = null, $options = array(), $confirmMessage = false) 
	{
		// pr($this->request);
		// pr($url);exit;

		// modification for acl

		if (empty($url['controller']))
		{
			$url['controller'] = $this->request->params['controller'];
		}

		if (
			empty($options['override'])
			&&
			!empty($url['controller'])
			&&
			!empty($url['action'])
			&&
			!in_array($url['controller'], array('mailto:','javascript:void(0)','#'))
			&&
			!in_array(array($url['controller'],$url['action']), $this->allowed_links)
			&&
			!$this->Session->check('Auth.User.Permissions.controllers/'.Inflector::camelize($url['controller']).'/'.strtolower(Inflector::underscore($url['action'])))
		)
		{
			return false;
		}
		// end acl mods


		$requestMethod = 'POST';
		if (!empty($options['method']))
		{
			$requestMethod = strtoupper($options['method']);
			unset($options['method']);
		}
		if (!empty($options['confirm']))
		{
			$confirmMessage = $options['confirm'];
			unset($options['confirm']);
		}

		$formName = str_replace('.', '', uniqid('post_', true));
		$formUrl = $this->url($url);
		$formOptions = array(
			'name' => $formName,
			'id' => $formName,
			'style' => 'display:none;',
			'method' => 'post',
		);
		if (isset($options['target']))
		{
			$formOptions['target'] = $options['target'];
			unset($options['target']);
		}

		$this->_lastAction = $formUrl;

		$out = $this->Html->useTag('form', $formUrl, $formOptions);
		$out .= $this->Html->useTag('hidden', '_method', array(
			'value' => $requestMethod
		));
		$out .= $this->_csrfField();

		$fields = array();
		if (isset($options['data']) && is_array($options['data']))
		{
			foreach (Hash::flatten($options['data']) as $key => $value)
			{
				$fields[$key] = $value;
				$out .= $this->hidden($key, array('value' => $value, 'id' => false));
			}
			unset($options['data']);
		}
		$out .= $this->secure($fields);
		$out .= $this->Html->useTag('formend');

		$url = '#';
		$onClick = 'document.' . $formName . '.submit();';
		if ($confirmMessage)
		{
			$options['onclick'] = $this->_confirm($confirmMessage, $onClick, '', $options);
		}
		else
		{
			$options['onclick'] = $onClick . ' ';
		}
		$options['onclick'] .= 'event.returnValue = false; return false;';

		$out .= $this->Html->link($title, $url, $options);
		return $out;
	}

	public function datepicker($field = '', $options = array())
	{
		echo $this->input($field.'',am(array(
			'type'		=>	'text',
			'class'		=>	'datepicker',
			'div'		=>	array(
				'class'		=>	'input date required'
			),
			'required'	=>	true
		),$options));
	}

	public function datepicker_time($field = '', $date_options = array(), $time_options = array())
	{
		echo $this->input($field.'.date',am(array(
			'type'		=>	'text',
			'class'		=>	'datepicker',
			'label'		=>	Inflector::humanize(substr($field,strrpos($field, '.')+1)),
			'div'		=>	array(
				'class'		=>	'input date required'
			),
			'required'	=>	true,
			'after'		=>	$this->input($field.'.time',am(array(
					'type'		=>	'text',
					'class'		=>	'timepicker',
					'label'		=>	false,
					'required'	=>	true
			),$time_options))
		),$date_options));
	}

	public function yes_no_radio($field = '', $options = array())
	{
		echo $this->input($field,am(array(
			'type'		=>	'radio',
			'options'	=>	array('No','Yes')
		),$options));
	}
}

