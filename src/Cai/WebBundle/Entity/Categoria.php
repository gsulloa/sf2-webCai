<?php

namespace Cai\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria
 *
 * @ORM\Table(name="web_categoria")
 * @ORM\Entity
 */
class Categoria
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
     * @ORM\Column(name="etiqueta", type="string", length=255)
     */
    private $etiqueta;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="\Gulloa\SecurityBundle\Entity\User", mappedBy="categorias")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Entrada", mappedBy="categorias")
     */
    private $entradas;

    /**
     * @ORM\ManyToMany(targetEntity="Pagina", mappedBy="categorias")
     */
    private $paginas;

    /**
     * @ORM\OneToMany(targetEntity="Evento",mappedBy="categoria")
     */
    private $eventos;

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
     * Set etiqueta
     *
     * @param string $etiqueta
     * @return Categoria
     */
    public function setEtiqueta($etiqueta)
    {
        $this->etiqueta = $etiqueta;

        return $this;
    }

    /**
     * Get etiqueta
     *
     * @return string 
     */
    public function getEtiqueta()
    {
        return $this->etiqueta;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->entradas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->paginas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add users
     *
     * @param \Gulloa\SecurityBundle\Entity\User $users
     * @return Categoria
     */
    public function addUser(\Gulloa\SecurityBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Gulloa\SecurityBundle\Entity\User $users
     */
    public function removeUser(\Gulloa\SecurityBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add entradas
     *
     * @param \Cai\WebBundle\Entity\Entrada $entradas
     * @return Categoria
     */
    public function addEntrada(\Cai\WebBundle\Entity\Entrada $entradas)
    {
        $this->entradas[] = $entradas;

        return $this;
    }

    /**
     * Remove entradas
     *
     * @param \Cai\WebBundle\Entity\Entrada $entradas
     */
    public function removeEntrada(\Cai\WebBundle\Entity\Entrada $entradas)
    {
        $this->entradas->removeElement($entradas);
    }

    /**
     * Get entradas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEntradas()
    {
        return $this->entradas;
    }

    /**
     * Add paginas
     *
     * @param \Cai\WebBundle\Entity\Pagina $paginas
     * @return Categoria
     */
    public function addPagina(\Cai\WebBundle\Entity\Pagina $paginas)
    {
        $this->paginas[] = $paginas;

        return $this;
    }

    /**
     * Remove paginas
     *
     * @param \Cai\WebBundle\Entity\Pagina $paginas
     */
    public function removePagina(\Cai\WebBundle\Entity\Pagina $paginas)
    {
        $this->paginas->removeElement($paginas);
    }

    /**
     * Get paginas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPaginas()
    {
        return $this->paginas;
    }
    public function __toString()
    {
        return $this->etiqueta;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Categoria
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
     * Add eventos
     *
     * @param \Cai\WebBundle\Entity\Evento $eventos
     * @return Categoria
     */
    public function addEvento(\Cai\WebBundle\Entity\Evento $eventos)
    {
        $this->eventos[] = $eventos;

        return $this;
    }

    /**
     * Remove eventos
     *
     * @param \Cai\WebBundle\Entity\Evento $eventos
     */
    public function removeEvento(\Cai\WebBundle\Entity\Evento $eventos)
    {
        $this->eventos->removeElement($eventos);
    }

    /**
     * Get eventos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEventos()
    {
        return $this->eventos;
    }
}
