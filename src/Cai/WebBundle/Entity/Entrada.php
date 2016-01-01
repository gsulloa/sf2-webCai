<?php

namespace Cai\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entrada
 *
 * @ORM\Table(name="web_entrada")
 * @ORM\Entity
 */
class Entrada
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
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="cuerpo", type="text")
     */
    private $cuerpo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\ManyToMany(targetEntity="Categoria", inversedBy="entradas")
     * @ORM\JoinTable(name="web_entrada_categoria")
     */
    private $categorias;

    /**
     * @ORM\ManyToOne(targetEntity="\Gulloa\SecurityBundle\Entity\User", inversedBy="entradas")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Imagen",inversedBy="entradas")
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
     * Set titulo
     *
     * @param string $titulo
     * @return Entrada
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
     * Set slug
     *
     * @param string $slug
     * @return Entrada
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set cuerpo
     *
     * @param string $cuerpo
     * @return Entrada
     */
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * Get cuerpo
     *
     * @return string 
     */
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Entrada
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categorias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categorias
     *
     * @param \Cai\WebBundle\Entity\Categoria $categorias
     * @return Entrada
     */
    public function addCategoria(\Cai\WebBundle\Entity\Categoria $categorias)
    {
        $this->categorias[] = $categorias;

        return $this;
    }

    /**
     * Remove categorias
     *
     * @param \Cai\WebBundle\Entity\Categoria $categorias
     */
    public function removeCategoria(\Cai\WebBundle\Entity\Categoria $categorias)
    {
        $this->categorias->removeElement($categorias);
    }

    /**
     * Get categorias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Set user
     *
     * @param \Gulloa\SecurityBundle\Entity\User $user
     * @return Entrada
     */
    public function setUser(\Gulloa\SecurityBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Gulloa\SecurityBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return $this->titulo;
    }

    /**
     * Set imagen
     *
     * @param \Cai\WebBundle\Entity\Imagen $imagen
     * @return Entrada
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
