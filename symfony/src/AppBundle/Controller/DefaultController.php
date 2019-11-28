<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use Symfony\Component\Validator\Constraints as Assert;

class DefaultController extends Controller
{
    public function pruebasAction(Request $request)
    {
        $token = $request->get('authorization', null);

        $helpers = $this->get(Helpers::class);
        $jwt_auth = $this->get(JwtAuth::class);

        if($token && $jwt_auth->checkToken($token) == true)
        {
            $em = $this->getDoctrine()->getManager();
            $userRepo = $em->getRepository('AppBundle:Usuario')->findAll();

            //get contenedor de servicios
            
            return $helpers->json(array(
                'status' => 'success',
                'users' => $userRepo
            ));
        }else{
            return $helpers->json(array(
                'status' => 'error',
                'code' => 400,
                'data' => 'Login Failed'
            ));
        }
    }

    public function loginAction(Request $request)
    {
        $helpers = $this->get(Helpers::class);

        //recibir los datos por post
        $json = $request->get('json', null); //por defecto null

        $data = array(
            'status' => 'error',
            'data' => 'send json via post'
        );

        if($json != null)
        {
            //hace el login

            //se convierte un json en un objeto php
            $params = json_decode($json);

            $email = (isset($params->email)) ? $params->email : null;
            $password = (isset($params->password)) ? $params->password : null;
            $hash = (isset($params->hash)) ? $params->hash : null;

            $emailConstraint = new Assert\Email();
            $emailConstraint->message = 'email inválido';

            $validar_email = $this->get('validator')->validate($email, $emailConstraint);

            //cifrar contraseña
            $pwd = hash('sha256', $password);

            if($email != null && count($validar_email) == 0 && $password != null)
            {

                $jwt_auth = $this->container->get(JwtAuth::class);
                if($hash == null || $hash == false)
                { 
                    $signup = $jwt_auth->signup($email, $pwd);

                }else{
                    $signup = $jwt_auth->signup($email, $pwd, true);
                }

                return $this->json($signup); 
            }else{
                $data = array(
                    'status' => 'error',
                    'data' => 'acceso denegado, contraseña o Usuario inválido'
                );
            }
        }else{
            //no hace el login
        }

        return $helpers->json($data);
    }
}
