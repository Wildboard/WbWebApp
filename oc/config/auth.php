<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

	'driver'       => 'oc',
	'hash_method'  => 'sha256',
	'hash_key'     => 'j80pb__lbvxc3537',
	'lifetime'     => 90*24*60*60,
	'session_type' => Session::$default,
	'session_key'  => 'auth_user',
	'cookie_salt'  => 'cookie_j80pb__lbvxc3537',
	'ql_key'       => 'ql_j80pb__lbvxc3537',
    'ql_lifetime'  => 7*24*60*60,
    'ql_separator' => '|',
    'ql_mode'      => MCRYPT_MODE_NOFB,
    'ql_cipher'    => MCRYPT_RIJNDAEL_128,

);