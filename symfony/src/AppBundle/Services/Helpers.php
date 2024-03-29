<?php
namespace AppBundle\Services;

class Helpers
{
	public $manager;

	public function __construct($manager)
	{
		$this->manager = $manager;
	}

	public function json($data)
	{
		$normalizers = array(new \Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer());
		$encoders = array("json" => new \Symfony\Component\Serializer\Encoder\JsonEncoder());

		$serializer = new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);

		$json = $serializer->serialize($data, 'json'); 

		$response = new \Symfony\Component\HttpFoundation\Response(); //respuesta http
		$response->setContent($json);
		$response->headers->set('Content-Type', 'application/json');

		return $response;
	}
}