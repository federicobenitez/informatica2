<?php
namespace AppBundle\Services;

use Firebase\JWT\JWT;

class JwtAuth
{
	public $manager;
	public $key;

	public function __construct($manager)
	{
		$this->manager = $manager;	
		$this->key = 'estaeslaclavesecreta455154654987454333';
	}

	public function signup($email, $password, $hash = null)
	{
		$usuario = $this->manager->getRepository('AppBundle:Usuario')->findOneBy(array(
			'email' => $email,
			'password' => $password
		));

		$signup = false;
		if(is_object($usuario))
		{
			$signup = true;
		}

		if ($signup == true)
		{
			//GENERAR EL TOKEN JWT
			$token = array(
				'sub' => $usuario->getId(),
				'email' => $usuario->getEmail(),
				'nombre' => $usuario->getNombre(),
				'apellido' => $usuario->getApellido(),
				'role' => $usuario->getRole(),
				'iat' => time(),
				'exp' => time() + (7*24*60*60) //una semana
			);

			$jwt = JWT::encode($token, $this->key, 'HS256');
			$decoded = JWT::decode($jwt, $this->key,array('HS256'));
			if($hash == null || $hash == false)
			{
				$data = $jwt;

			}else{ 
			
				$data = $decoded;
			}

		}else{
			$data = array(
				'status' => 'error',
				'data' => 'Login Failed!'
			);
		}

		return $data;
	}

	public function checkToken($jwt, $getIdentity = false)
	{
		$auth = false;
		try
		{
			$decoded = JWT::decode($jwt,$this->key,array('HS256'));

		}catch(\UnexpectedValueException $e){
			$auth = false;
		}catch(\DomainException $e){
			$auth = false;
		}

		if(isset($decoded) && is_object($decoded) && isset($decoded->sub))
		{
			$auth = true;

		}else{
			$auth = false;
		}

		if($getIdentity == false)
		{
			return $auth;
		}else {
			return $decoded;
		}

	}
}