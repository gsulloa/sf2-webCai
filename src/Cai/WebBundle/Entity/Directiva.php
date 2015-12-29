<?php

namespace Cai\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Directiva
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Directiva
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
     * @ORM\Column(name="anno", type="integer")
     */
    private $anno;

    /**
     * @ORM\OneToMany(targetEntity="Persona", mappedBy="directiva")
     */
    private $personas;

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
     * Set anno
     *
     * @param integer $anno
     * @return Directiva
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;

        return $this;
    }

    /**
     * Get anno
     *
     * @return integer 
     */
    public function getAnno()
    {
        return $this->anno;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add personas
     *
     * @param \Cai\WebBundle\Entity\Persona $personas
     * @return Directiva
     */
    public function addPersona(\Cai\WebBundle\Entity\Persona $personas)
    {
        $this->personas[] = $personas;

        return $this;
    }

    /**
     * Remove personas
     *
     * @param \Cai\WebBundle\Entity\Persona $personas
     */
    public function removePersona(\Cai\WebBundle\Entity\Persona $personas)
    {
        $this->personas->removeElement($personas);
    }

    /**
     * Get personas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersonas()
    {
        return $this->personas;
    }

    public function __toString()
    {
        return "Directiva ".$this->anno;
    }
}
