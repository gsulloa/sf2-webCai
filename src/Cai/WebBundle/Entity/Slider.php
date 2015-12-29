<?php

namespace Cai\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slider
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Slider
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
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\OneToMany(targetEntity="Slide", mappedBy="slider")
     */
    private $slides;


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
     * Set titulo
     *
     * @param string $titulo
     * @return Slider
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
     * Constructor
     */
    public function __construct()
    {
        $this->slides = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add slides
     *
     * @param \Cai\WebBundle\Entity\Slide $slides
     * @return Slider
     */
    public function addSlide(\Cai\WebBundle\Entity\Slide $slides)
    {
        $this->slides[] = $slides;

        return $this;
    }

    /**
     * Remove slides
     *
     * @param \Cai\WebBundle\Entity\Slide $slides
     */
    public function removeSlide(\Cai\WebBundle\Entity\Slide $slides)
    {
        $this->slides->removeElement($slides);
    }

    /**
     * Get slides
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSlides()
    {
        return $this->slides;
    }
    public function __toString()
    {
        return $this->titulo;
    }
}
