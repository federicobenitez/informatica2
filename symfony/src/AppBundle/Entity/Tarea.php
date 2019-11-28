<?php

namespace AppBundle\Entity;

/**
 * Tarea
 */
class Tarea
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nRegistro;

    /**
     * @var string
     */
    private $solicitante;

    /**
     * @var string
     */
    private $sReparacion;

    /**
     * @var string
     */
    private $sRedes;

    /**
     * @var string
     */
    private $sTelefonico;

    /**
     * @var string
     */
    private $sAsesoramiento;

    /**
     * @var string
     */
    private $marca;

    /**
     * @var string
     */
    private $modelo;

    /**
     * @var string
     */
    private $nInventario;

    /**
     * @var string
     */
    private $rrevTecnica;

    /**
     * @var string
     */
    private $fallaHard;

    /**
     * @var string
     */
    private $fallaSoft;

    /**
     * @var string
     */
    private $recomendaciones;

    /**
     * @var string
     */
    private $destino;

    /**
     * @var string
     */
    private $fechaDest;

    /**
     * @var string
     */
    private $horaDest;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var string
     */
    private $fallasDet;

    /**
     * @var string
     */
    private $medidasTom;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;
    //@var \AppBundle\Entity\Usuario

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     */
    private $usuario;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nRegistro
     *
     * @param string $nRegistro
     *
     * @return Tarea
     */
    public function setNRegistro($nRegistro)
    {
        $this->nRegistro = $nRegistro;

        return $this;
    }

    /**
     * Get nRegistro
     *
     * @return string
     */
    public function getNRegistro()
    {
        return $this->nRegistro;
    }

    /**
     * Set solicitante
     *
     * @param string $solicitante
     *
     * @return Tarea
     */
    public function setSolicitante($solicitante)
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    /**
     * Get solicitante
     *
     * @return string
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set sReparacion
     *
     * @param string $sReparacion
     *
     * @return Tarea
     */
    public function setSReparacion($sReparacion)
    {
        $this->sReparacion = $sReparacion;

        return $this;
    }

    /**
     * Get sReparacion
     *
     * @return string
     */
    public function getSReparacion()
    {
        return $this->sReparacion;
    }

    /**
     * Set sRedes
     *
     * @param string $sRedes
     *
     * @return Tarea
     */
    public function setSRedes($sRedes)
    {
        $this->sRedes = $sRedes;

        return $this;
    }

    /**
     * Get sRedes
     *
     * @return string
     */
    public function getSRedes()
    {
        return $this->sRedes;
    }

    /**
     * Set sTelefonico
     *
     * @param string $sTelefonico
     *
     * @return Tarea
     */
    public function setSTelefonico($sTelefonico)
    {
        $this->sTelefonico = $sTelefonico;

        return $this;
    }

    /**
     * Get sTelefonico
     *
     * @return string
     */
    public function getSTelefonico()
    {
        return $this->sTelefonico;
    }

    /**
     * Set sAsesoramiento
     *
     * @param string $sAsesoramiento
     *
     * @return Tarea
     */
    public function setSAsesoramiento($sAsesoramiento)
    {
        $this->sAsesoramiento = $sAsesoramiento;

        return $this;
    }

    /**
     * Get sAsesoramiento
     *
     * @return string
     */
    public function getSAsesoramiento()
    {
        return $this->sAsesoramiento;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return Tarea
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     *
     * @return Tarea
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set nInventario
     *
     * @param string $nInventario
     *
     * @return Tarea
     */
    public function setNInventario($nInventario)
    {
        $this->nInventario = $nInventario;

        return $this;
    }

    /**
     * Get nInventario
     *
     * @return string
     */
    public function getNInventario()
    {
        return $this->nInventario;
    }

    /**
     * Set rrevTecnica
     *
     * @param string $rrevTecnica
     *
     * @return Tarea
     */
    public function setRrevTecnica($rrevTecnica)
    {
        $this->rrevTecnica = $rrevTecnica;

        return $this;
    }

    /**
     * Get rrevTecnica
     *
     * @return string
     */
    public function getRrevTecnica()
    {
        return $this->rrevTecnica;
    }

    /**
     * Set fallaHard
     *
     * @param string $fallaHard
     *
     * @return Tarea
     */
    public function setFallaHard($fallaHard)
    {
        $this->fallaHard = $fallaHard;

        return $this;
    }

    /**
     * Get fallaHard
     *
     * @return string
     */
    public function getFallaHard()
    {
        return $this->fallaHard;
    }

    /**
     * Set fallaSoft
     *
     * @param string $fallaSoft
     *
     * @return Tarea
     */
    public function setFallaSoft($fallaSoft)
    {
        $this->fallaSoft = $fallaSoft;

        return $this;
    }

    /**
     * Get fallaSoft
     *
     * @return string
     */
    public function getFallaSoft()
    {
        return $this->fallaSoft;
    }

    /**
     * Set recomendaciones
     *
     * @param string $recomendaciones
     *
     * @return Tarea
     */
    public function setRecomendaciones($recomendaciones)
    {
        $this->recomendaciones = $recomendaciones;

        return $this;
    }

    /**
     * Get recomendaciones
     *
     * @return string
     */
    public function getRecomendaciones()
    {
        return $this->recomendaciones;
    }

    /**
     * Set destino
     *
     * @param string $destino
     *
     * @return Tarea
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return string
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set fechaDest
     *
     * @param string $fechaDest
     *
     * @return Tarea
     */
    public function setFechaDest($fechaDest)
    {
        $this->fechaDest = $fechaDest;

        return $this;
    }

    /**
     * Get fechaDest
     *
     * @return string
     */
    public function getFechaDest()
    {
        return $this->fechaDest;
    }

    /**
     * Set horaDest
     *
     * @param string $horaDest
     *
     * @return Tarea
     */
    public function setHoraDest($horaDest)
    {
        $this->horaDest = $horaDest;

        return $this;
    }

    /**
     * Get horaDest
     *
     * @return string
     */
    public function getHoraDest()
    {
        return $this->horaDest;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return Tarea
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set fallasDet
     *
     * @param string $fallasDet
     *
     * @return Tarea
     */
    public function setFallasDet($fallasDet)
    {
        $this->fallasDet = $fallasDet;

        return $this;
    }

    /**
     * Get fallasDet
     *
     * @return string
     */
    public function getFallasDet()
    {
        return $this->fallasDet;
    }

    /**
     * Set medidasTom
     *
     * @param string $medidasTom
     *
     * @return Tarea
     */
    public function setMedidasTom($medidasTom)
    {
        $this->medidasTom = $medidasTom;

        return $this;
    }

    /**
     * Get medidasTom
     *
     * @return string
     */
    public function getMedidasTom()
    {
        return $this->medidasTom;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Tarea
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Tarea
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Tarea
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}

