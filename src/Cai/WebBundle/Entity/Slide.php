<?php

namespace Cai\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slide
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Slide
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var integer
     *
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="Slider", inversedBy="slides")
     * @ORM\JoinColumn(name="slider_id", referencedColumnName="id")
     */
    private $slider;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\ManyToOne(targetEntity="Imagen", inversedBy="slide")
     * @ORM\JoinColumn(name="imagen_id", referencedColumnName="id")
     */
    private $imagen;


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
     * Set posicion
     *
     * @param integer $posicion
     * @return Slide
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer 
     */
    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Slide
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set slider
     *
     * @param \Cai\WebBundle\Entity\Slider $slider
     * @return Slide
     */
    public function setSlider(\Cai\WebBundle\Entity\Slider $slider = null)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return \Cai\WebBundle\Entity\Slider 
     */
    public function getSlider()
    {
        return $this->slider;
    }

    public function __toString()
    {
        return $this->titulo;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Slide
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    

    /**
     * Set imagen
     *
     * @param \Cai\WebBundle\Entity\Imagen $imagen
     * @return Slide
     */
    public function setImagen(\Cai\WebBundle\Entity\Imagen $imagen = null)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return \Cai\WebBundle\Entity\Imagen 
     */
    public function getImagen()
    {
        return $this->imagen;
    }
}
