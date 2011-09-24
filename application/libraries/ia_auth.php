<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class IA_Auth {

	private $ci;
	private $rounds = 12;
	private $prefix = 'waffles';

	function __construct()
	{
		$this->ci = & get_instance();
		log_message('debug', 'Authorization class initialized.');

		$this->ci->load->database();
		$this->ci->load->library('session');
	}

	/**
	 * Attempt to login using the given condition
	 *
	 * Accepts an associative array as input, containing login condition
	 * Example: $this->auth->try_login(array('email'=>$email, 'password'=>dohash($password)))
	 *
	 * @access	public
	 * @param	array	login conditions
	 * @return	boolean
	 */
	function login($email, $password)
	{
		$this->ci->db->select('id');

		$credentials = array(
			'email' => $email,
			'password' => $password
		);

		$query = $this->ci->db->getwhere('ia_users', $credentials, 1, 0);

		if ($query->num_rows != 1)
		{
			return FALSE;
		}
		
		else
		{
			$row = $query->row();
			$this->ci->session->set_userdata(array('user_id' => $row->id));
			return TRUE;
		}
	}

	/**
	 * Logs a user out
	 *
	 * Example: $this->erkanaauth->logout()
	 *
	 * @access	public
	 * @return	void
	 */
	function logout()
	{
		$this->ci->session->set_userdata(array('user_id' => FALSE));
	}

	/**
	 * Checks whether user is logged in
	 * 
	 * @return int/bool User id if loggged in, FALSE if not
	 */
	function logged_in()
	{
		return $this->ci->session->userdata('user_id');
	}

	/**
	 * Creates a new user
	 * 
	 * @param $email User's email address
	 * @param $password User's password
	 * 
	 * @return bool TRUE on success, FALSE on failure
	 */
	function create_user($email, $password, $role = 'user')
	{
		$hash = $this->hash($password);
		unset($password);
		
		if( ! $this->role_exists())
		{
			show_error('The role "' . $role . '" does not exist.');
		}
		
		$role_id = $this->get_role_id($role);
		
		$credentials = array(
			'email'    => $email,
			'hash'     => $hash,
			'role_id'  => $role_id
		);
		
		$this->ci->db->insert('ia_users', $credentials);
	}

	/**
	 * Returns a field from the user's table for the logged in user
	 *
	 * Example: $this->erkanaauth->getField('username')
	 *
	 * @access	public
	 * @param	string	field to return
	 * @return	string
	 */
	function get_field($field = '')
	{
		$this->ci->db->select($field);
		$query = $this->ci->db->get_where('users', array('id' => $this->ci->session->userdata('user_id')), 1, 0);

		if ($query->num_rows() == 1)
		{
			$row = $query->row();
			return $row->$field;
		}
	}
	
	/**
	 * Check whether a role exists in the database
	 * 
	 * @param $role The role to check
	 * 
	 * @return int/bool The role ID if role exists in db, otherwise false
	 */
	function role_exists($role)
	{
		$query = $this->ci->db->get_where('ia_roles', array('name' => $role));
		
		if ($query->num_rows() == 1)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 * Gets role ID from database
	 * 
	 * @param $role The role to get the ID of
	 * 
	 * @return int $role_id The role ID form the database
	 */
	function get_role_id($role)
	{
		$this->ci->db->select('id');
		$query = $this->ci->db->get_where('ia_roles', array('name' => $role));
		
		if ($query->num_rows() == 1)
		{
			$row = $query->row();
			return $row->name;
		}
	}

	/**
	 * Returns the user's role
	 *
	 * Example: $this->erkanaauth->getRole()
	 *
	 * @access	public
	 * @return	string
	 */
	function get_role()
	{
		$this->ci->db->select('ia_roles.name');
		$this->ci->db->join('ia_roles', 'ia_users.role_id = ia_roles.id');
		$query = $this->ci->db->get_where('ia_users', array('ia_users.id' => $this->ci->session->userdata('user_id')), 1, 0);

		if ($query->num_rows() == 1)
		{
			$row = $query->row();
			return $row->name;
		}
	}
	
	/**
	 * Checks whether logged in user is admin
	 * 
	 * @return bool Whether logged in user is admin or not
	 */
	function is_admin()
	{
		return $this->get_role() === 'admin';
	}
	
	
	private function hash($input)
	{
		$hash = crypt($input, $this->get_salt());

		if (strlen($hash) > 13)
		{
			return $hash;
		}

		return false;
	}

	private function verify($input, $existingHash)
	{
		$hash = crypt($input, $existingHash);

		return $hash === $existingHash;
	}

	private function get_salt()
	{
		// the base64 function uses +'s and ending ='s; translate the first, and cut out the latter
		return sprintf('$2a$%02d$%s', $this->rounds, substr(strtr(base64_encode($this->get_bytes()), '+', '.'), 0, 22));
	}

	private function get_bytes()
	{
		$bytes = '';

		if (function_exists('openssl_random_pseudo_bytes') &&
				(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN'))
		{ // OpenSSL slow on Win
			$bytes = openssl_random_pseudo_bytes(18);
		}

		if ($bytes === '' && is_readable('/dev/urandom') &&
				($hRand = @fopen('/dev/urandom', 'rb')) !== FALSE)
		{
			$bytes = fread($hRand, 18);
			fclose($hRand);
		}

		if ($bytes === '')
		{
			$key = uniqid($this->prefix, true);

			// 12 rounds of HMAC must be reproduced / created verbatim, no known shortcuts.
			// Salsa20 returns more than enough bytes.
			for ($i = 0; $i < 12; $i++)
			{
				$bytes = hash_hmac('salsa20', microtime() . $bytes, $key, true);
				usleep(10);
			}

			// uniqid() is adequate, probably better than microtime + pid
			//mt_srand(unpack('N1', uniqid()));
			// packed as 16bit unsigned integers, rather than 32 bits. Most the higher registers aren't
			// populated when used as 32bit integers. (more chaos)
			//$bytes = pack('n8', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand());
		}

		return $bytes;
	}

}

?>