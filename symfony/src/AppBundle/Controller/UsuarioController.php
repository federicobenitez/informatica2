<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Usuario;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;

class UsuarioController extends Controller
{
	public function newAction(Request $request)
	{
		$helpers = $this->get(Helpers::class);

		$json = $request->get("json", null);
		$params = json_decode($json);

		$data = array(
			'status' => 'error',
			'code' => 400,
			'msg' => 'usuario no creado '
		);

		if ($json != null)
		{
			$createdAt = new \Datetime('now');
			$role = 'user';

			$email = (isset($params->email)) ? $params->email : null;
			$nombre = (isset($params->nombre)) ? $params->nombre : null;
			$apellido = (isset($params->apellido)) ? $params->apellido : null;
			$password = (isset($params->password)) ? $params->password : null;

			$emailConstraint = new Assert\Email();
			$emailConstraint->message = 'Email inválido';
			$validate_email = $this->get('validator')->validate($email, $emailConstraint);

			if($email != null && count($validate_email) == 0 && $password != null && $nombre != null && $apellido != null)
			{
				$em = $this->getDoctrine()->getManager();

				$usuario = new Usuario();
				$usuario->setRole($role);
				$usuario->setNombre($nombre);
				$usuario->setApellido($apellido);
				$usuario->setEmail($email);
				
				$usuario->setCreatedAt($createdAt);

				//cifrar la contraseña
				$pwd = hash('sha256', $password);
				$usuario->setPassword($pwd);

				$issetUser = $em->getRepository('AppBundle:Usuario')->findBy(array( 
					'email' => $email
				));

				if(count($issetUser) == 0)
				{
					$em->persist($usuario);
					$em->flush();

					$data = array(
						'status' => 'success',
						'code' => 200,
						'msg' => 'nuevo usuario creado ',
						'usuario' => $usuario
					);


				}else{

					$data = array(
						'status' => 'error',
						'code' => 400,
						'msg' => 'usuario no creado, duplicado '
					);

				}
			}
		}

		return $helpers->json($data);
	}

	public function editAction(Request $request)
	{
		$helpers = $this->get(Helpers::class);
		$jwtAuth = $this->get(JwtAuth::class);

		$token = $request->get('authorization', null);
		$authCheck = $jwtAuth->checkToken($token);//devulve el token codificado

		if($authCheck == true)
		{
			$em = $this->getDoctrine()->getManager();
			//datos del usuario identificado
			$identity = $jwtAuth->checkToken($token, true);//devuleve el token decodificado

			//print_r($identity);
			//die();

			$usuario = $em->getRepository('AppBundle:Usuario')->findOneBy(array(
				'id' => $identity->sub
			));

			$json = $request->get('json', null);
			$params = json_decode($json);

			//print_r($json);
			//die();

			$data = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'usuario no actualizado'
			);

			if ($json != null)
			{
				//$createdAt = new \Datetime('now');
				//$role = 'usuario';
				$role = $usuario->getRole();
				$email = (isset($params->email)) ? $params->email : null;
				$nombre = (isset($params->nombre)) ? $params->nombre : null;
				$apellido = (isset($params->apellido)) ? $params->apellido : null;
				$password = (isset($params->password)) ? $params->password : null;

				$emailConstraint = new Assert\Email();
				$emailConstraint->message = 'Email inválido';
				$validate_email = $this->get('validator')->validate($email, $emailConstraint);

				if($email != null && count($validate_email) == 0  && $nombre != null && $apellido != null)
				{
					

					//$usuario = new Usuario(); se actualiza, no se crea
					$usuario->setRole($role);
					$usuario->setNombre($nombre);
					$usuario->setApellido($apellido);
					$usuario->setEmail($email);
					//$usuario->setPassword($password);
					//$usuario->setCreatedAt($createdAt);
					if($password != null)
					{
						//cifrar la contraseña
						$pwd = hash('sha256', $password);
						$usuario->setPassword($pwd);
					}

					$issetUser = $em->getRepository('AppBundle:Usuario')->findBy(array( 
						'email' => $email
					));

					if(count($issetUser) != 0 || $identity->email == $email)
					{
						$em->persist($usuario);
						$em->flush();

						$data = array(
							'status' => 'success',
							'code' => 200,
							'msg' => 'usuario actualizado',
							'usuario' => $usuario
						);


					}else{

						$data = array(
							'status' => 'error',
							'code' => 400,
							'msg' => 'usuario no creado, duplicado '
						);

					}
				}
			}
		}else{
			$data = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'autorizacion inválida'
			);
		}

		return $helpers->json($data);
	}		

}