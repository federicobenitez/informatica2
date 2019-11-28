<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Tarea;
use AppBundle\Entity\Usuario;

class TareaController extends Controller
{
	public function newAction(Request $request, $id = null){
		$helpers = $this->get(Helpers::class);
		$jwt_auth = $this->get(JwtAuth::class);

		$token = $request->get('authorization', null);
		$authCheck = $jwt_auth->checkToken($token);

		if($authCheck == true){
			$identity = $jwt_auth->checkToken($token, true);
			$json = $request->get('json', null);

			if($json != null){
				$params = json_decode($json);

				$createdAt = new \Datetime('now');
				$updatedAt = new \Datetime('now');

				$usuario_id = ($identity->sub != null) ? $identity->sub : null;
				$nRegistro = (isset($params->nRegistro)) ? $params->nRegistro : null;
				$solicitante = (isset($params->solicitante)) ? $params->solicitante : null;
				$sReparacion = (isset($params->sReparacion)) ? $params->sReparacion : null;
				$sRedes = (isset($params->sRedes)) ? $params->sRedes : null;
				$sTelefonico = (isset($params->sTelefonico)) ? $params->sTelefonico : null;
				$sAsesoramiento = (isset($params->sAsesoramiento)) ? $params->sAsesoramiento : null;
				$marca = (isset($params->marca)) ? $params->marca : null;
				$modelo = (isset($params->modelo)) ? $params->modelo : null;
				$nInventario = (isset($params->nInventario)) ? $params->nInventario : null;
				$rrevTecnica = (isset($params->rrevTecnica)) ? $params->rrevTecnica : null;
				$fallaHard = (isset($params->fallaHard)) ? $params->fallaHard : null;
				$fallaSoft = (isset($params->fallaSoft)) ? $params->fallaSoft : null;
				$recomendaciones = (isset($params->recomendaciones)) ? $params->recomendaciones : null;
				$destino = (isset($params->destino)) ? $params->destino : null;
				$fechaDest = (isset($params->fechaDest)) ? $params->fechaDest : null;
				$horaDest = (isset($params->horaDest)) ? $params->horaDest : null;
				$motivo = (isset($params->motivo)) ? $params->motivo : null;
				$fallasDet = (isset($params->fallasDet)) ? $params->fallasDet : null;
				$medidasTom = (isset($params->medidasTom)) ? $params->medidasTom : null;



				if($usuario_id != null && $nRegistro != null){
					// crear tarea
					$em = $this->getDoctrine()->getManager();

					$usuario = $em->getRepository('AppBundle:Usuario')->findOneBy(array(
						'id' => $usuario_id
					));

					if($id == null){
						$tarea = new Tarea();
						$tarea->setUsuario($usuario);
						$tarea->setNRegistro($nRegistro);
						$tarea->setSolicitante($solicitante);
						$tarea->setSReparacion($sReparacion);

						$tarea->setSRedes($sRedes);
						$tarea->setSTelefonico($sTelefonico);
						$tarea->setSAsesoramiento($sAsesoramiento);
						$tarea->setMarca($marca);
						$tarea->setModelo($modelo);
						$tarea->setNInventario($nInventario);
						$tarea->setRrevTecnica($rrevTecnica);
						$tarea->setFallaHard($fallaHard);
						$tarea->setFallaSoft($fallaSoft);
						$tarea->setRecomendaciones($recomendaciones);
						$tarea->setDestino($destino);
						$tarea->setFechaDest($fechaDest);
						$tarea->setHoraDest($horaDest);
						$tarea->setMotivo($motivo);
						$tarea->setFallasDet($fallasDet);
						$tarea->setMedidasTom($medidasTom);

						$tarea->setCreatedAt($createdAt);
						$tarea->setUpdatedAt($updatedAt);

						$em->persist($tarea);
						$em->flush();

						$data = array(
							"status" => "success",
							"code" => 200,
							"msg" => "tarea creada",
							"data" => $tarea
						);
					}else{
						$tarea = $em->getRepository('AppBundle:Tarea')->findOneBy(array(
							'id' => $id
						));

						if(isset($identity->sub) && $identity->sub == $tarea->getUsuario()->getId())
						{
							$tarea->setNRegistro($nRegistro);
							$tarea->setSolicitante($solicitante);
							$tarea->setSReparacion($sReparacion);

							$tarea->setSRedes($sRedes);
							$tarea->setSTelefonico($sTelefonico);
							$tarea->setSAsesoramiento($sAsesoramiento);
							$tarea->setMarca($marca);
							$tarea->setModelo($modelo);
							$tarea->setNInventario($nInventario);
							$tarea->setRrevTecnica($rrevTecnica);
							$tarea->setFallaHard($fallaHard);
							$tarea->setFallaSoft($fallaSoft);
							$tarea->setRecomendaciones($recomendaciones);
							$tarea->setDestino($destino);
							$tarea->setFechaDest($fechaDest);
							$tarea->setHoraDest($horaDest);
							$tarea->setMotivo($motivo);
							$tarea->setFallasDet($fallasDet);
							$tarea->setMedidasTom($medidasTom);

							$tarea->setCreatedAt($createdAt);

							$em->persist($tarea);
							$em->flush();

							$data = array(
								"status" => "success",
								"code" => 200,
								"msg" => "tarea actualizada",
								"data" => $tarea
							);

						}else{
							$data = array(
								"status" => "error",
								"code" => 400,
								"msg" => 'tarea no actualizada, no eres propietario'
							);
						}
					}

				}else{
					$data = array(
						"status" => "error",
						"code" => 400,
						"msg" => 'tarea no creada, fallo validacion'
					);
				}

				
			}else{
				$data = array(
					"status" => "error",
					"code" => 400,
					"msg" => 'tarea no creada, fallo de parametros'
				);
			}


		}else{
			$data = array(
				"status" => "error",
				"code" => 400,
				"msg" => 'autorizacion no valida'
			);
		}

		return $helpers->json($data);
	}
	public function listAction(Request $request){

		$helpers = $this->get(Helpers::class);
		$jwtAuth = $this->get(JwtAuth::class);

		$token = $request->get('authorization', null);
		$authCheck = $jwtAuth->checkToken($token);

		if ($authCheck == true){

			$identity = $jwtAuth->checkToken($token, true);
			//$json = $request->get('json', null)

			$em = $this->getDoctrine()->getManager();

			//poner comillas dobles al usar {} para pasar variables en la cosulta
			$dql = "SELECT t from AppBundle:Tarea t WHERE t.usuario = {$identity->sub} ORDER BY t.id DESC";
			$query = $em->createQuery($dql);

			$page = $request->query->getInt('page',1);
			$paginator = $this->get('knp_paginator');
			$itemsPerPage = 10;
			$pagination = $paginator->paginate($query, $page, $itemsPerPage);
			$totalItems = $pagination->getTotalItemCount();

			$data = array(
				'status' => 'success',
				'code' => 200,
				'total_items' => $totalItems,
				'pagina_actual' => $page,
				'items_por_pagina' => $itemsPerPage,
				'total_de_paginas' => ceil($totalItems / $itemsPerPage),
				'data' => $pagination
			);

		}else{

			$data = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'Autorización no válida'
			);

		}

		return $helpers->json($data);

	}

	public function detailAction(Request $request, $id = null){

		$helpers = $this->get(Helpers::class);
		$jwtAuth = $this->get(JwtAuth::class);

		$token = $request->get('authorization', null);
		
		$authCheck = $jwtAuth->checkToken($token);	

		if($authCheck){
			$identity = $jwtAuth->checkToken($token, true);
			//$json = $request->get('json', null);
			$em = $this->getDoctrine()->getManager();
			$detalle = $em->getRepository('AppBundle:Tarea')->findOneBy(array(
				'id' => $id
			));

			if ($detalle && is_object($detalle) && $identity->sub == $detalle->getUsuario()->getId())
			{

				$data = array(
					'status' => 'success',
					'code' => 200,
					'msg' => $detalle
				);

			}else{
				$data = array(
				'status' => 'error',
				'code' => 404,
				'msg' => 'Tiket no hallado'
			);
			}

		}else{
			$data = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'Autorización no válida'
			);
		}

		return $helpers->json($data);

	}

	public function searchAction(Request $request, $search = null){
		$helpers = $this->get(Helpers::class);
		$jwtAuth = $this->get(JwtAuth::class);

		$token = $request->get('authorization', null);
		$authCheck = $jwtAuth->checkToken($token);

		if ($authCheck){
			$identity = $jwtAuth->checkToken($token,true);

			$em = $this->getDoctrine()->getManager();

			$order = $request->get('order', null);
			if(empty($order) || $order == 2){
				$order = 'DESC';
			}else{
				$order = 'ASC';
			}


			if ($search != null){
				$dql = 'SELECT t FROM AppBundle:Tarea t '
						.'WHERE t.usuario = '.$identity->sub.' AND '
						.'(t.nRegistro LIKE :search OR t.solicitante LIKE :search OR t.sReparacion LIKE :search)';

			}else{
				$dql = 'SELECT t FROM AppBundle:Tarea t WHERE t.usuario = '.$identity->sub;
			}
			
			// set order
			$dql .= " ORDER BY t.id $order";

			$query = $em->createQuery($dql);


			//set search
			if (!empty($search)){

					$query->setParameter('search', "%$search%");

			}

			$tareas = $query->getResult();

			if(!empty($tareas)){ 

				$data = array(
					'status' => 'success',
					'code' => 200,
					'data' => $tareas
				);
			}else{
				$data = array(
					'status' => 'error',
					'code' => 404,
					'msg' => 'Objeto no encontrado'
				);
			}


		}else{
			$data = array(
				'status' => 'error',
				'code' => 400,
				'msg' => 'Autorización no válida'
			);
		}

		return $helpers->json($data);
	}

	public function removeAction(Request $request, $id = null){
		$helpers = $this->get(Helpers::class);
		$jwtAuth = $this->get(JwtAuth::class);

		$token = $request->get('authorization', null);
		$authCheck = $jwtAuth->checkToken($token);

		if($authCheck){
			$identity = $jwtAuth->checkToken($token, true); 

			$em = $this->getDoctrine()->getManager();
			$tarea = $em->getRepository('AppBundle:Tarea')->findOneBy(array(
				'id' => $id
			));

			if ($tarea && is_object($tarea) && $identity->sub == $tarea->getUsuario()->getId()){

				$em->remove($tarea);
				$em->flush();

				$data = array(
					'status' => 'success',
					'code' => 200,
					'msg' => 'Tarea eliminada',
					'data' => $tarea
				);

			}else{
				$data = array(
					'status' => 'error',
					'code' => 404,
					'msg' => 'Tarea no hallada'
				);
			}
		}else{
			$data = array(
				'status' => 'error',
				'data' => 400,
				'msg' => 'Autenticación fallida'
			);
		}

		return $helpers->json($data);
	}

}