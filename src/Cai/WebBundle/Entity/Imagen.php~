<?php

namespace Cai\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Imagen
 *
 * @ORM\Table(name="web_imagen")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Imagen
{
    private $deleteForm;
    private $temp;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    protected $filename;

    /**
     *
     * @ORM\Column(name="filenamebinary", type="string", length=255, nullable=false)
     */
    protected $filenamebinary;

    /**
     *
     * @ORM\OneToMany(targetEntity="Entrada", mappedBy="imagen")
     */
    protected $entradas;

    /**
     * @ORM\OneToMany(targetEntity="Slide", mappedBy="imagen")
     */
    protected $slide;

    /**
     *
     * @Assert\File(
     *  maxSize="15360k",
     * mimeTypes = {"image/png","image/jpeg","image/gif"}
     * )
     * @Assert\NotBlank()
     */
    protected $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->filenamebinary)) {
            // store the old name to delete after the update
            $this->temp = $this->filenamebinary;
            $this->filenamebinary = null;
        } else {
            $this->filenamebinary = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->filenamebinary
            ? null
            : $this->getUploadRootDir() . $this->filename;
    }

    public function getWebPath()
    {
        return null === $this->filenamebinary
            ? null
            : $this->getUploadDir() . '/' . $this->filenamebinary;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/biblioteca/imagenes/' . $this->filenamebinary . '/';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // compute a random name and try to guess the extension (more secure)
            $extension = $this->getFile()->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }

            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->filenamebinary = $filename;
            $this->filename = $this->filename . '.' . $extension;
            //$this->filename = $this->getFile()->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->filename);

        ## CONFIGURACION #############################

        # ruta de la imagen a redimensionar
        $imagen = $this->getUploadRootDir() . $this->filename;
        # ruta de la imagen final, si se pone el mismo nombre que la imagen, esta se sobreescribe
        $imagen_final_small = $this->getUploadRootDir() . 'small-' . $this->filename;
        $imagen_final_medium = $this->getUploadRootDir() . 'medium-' . $this->filename;
        $ancho_nuevo = 200;
        $alto_nuevo = 200;
        /*
        if (!is_dir($this->getUploadRootDir().'/small/')) {
            mkdir($this->getUploadRootDir().'/small/', 0777, true);
        }*/
        ## FIN CONFIGURACION #############################

        $this->redim($imagen, $imagen_final_small, $ancho_nuevo, $alto_nuevo);
        $ancho_nuevo = 800;
        $alto_nuevo = 800;
        $this->redim($imagen, $imagen_final_medium, $ancho_nuevo, $alto_nuevo);

        // check if we have an old image
        /*
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/big'.$this->temp);
            unlink($this->getUploadRootDir().'/small'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }*/
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
            unlink($this->getUploadRootDir() . '/small-' . $this->filename);
            rmdir($this->getUploadDir());
        }
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Imagen
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set filenamebinary
     *
     * @param string $filenamebinary
     * @return Imagen
     */
    public function setFilenamebinary($filenamebinary)
    {
        $this->filenamebinary = $filenamebinary;

        return $this;
    }

    /**
     * Get filenamebinary
     *
     * @return string
     */
    public function getFilenamebinary()
    {
        return $this->filenamebinary;
    }

    public function getDeleteForm()
    {
        return $this->deleteForm;
    }

    public function setDeleteForm($deleteForm)
    {
        $this->deleteForm = $deleteForm;
    }


    function redim($ruta1, $ruta2, $ancho, $alto)
    {
        # se obtene la dimension y tipo de imagen
        $datos = getimagesize($ruta1);

        $ancho_orig = $datos[0]; # Anchura de la imagen original
        $alto_orig = $datos[1];    # Altura de la imagen original
        $tipo = $datos[2];

        if ($tipo == 1) { # GIF
            if (function_exists("imagecreatefromgif"))
                $img = imagecreatefromgif($ruta1);
            else
                return false;
        } else if ($tipo == 2) { # JPG
            if (function_exists("imagecreatefromjpeg"))
                $img = imagecreatefromjpeg($ruta1);
            else
                return false;
        } else if ($tipo == 3) { # PNG
            if (function_exists("imagecreatefrompng"))
                $img = imagecreatefrompng($ruta1);
            else
                return false;
        }

        # Se calculan las nuevas dimensiones de la imagen
        if ($ancho_orig > $alto_orig) {
            $ancho_dest = $ancho;
            $alto_dest = ($ancho_dest / $ancho_orig) * $alto_orig;
        } else {
            $alto_dest = $alto;
            $ancho_dest = ($alto_dest / $alto_orig) * $ancho_orig;
        }

        // imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+
        $img2 = @imagecreatetruecolor($ancho_dest, $alto_dest) or $img2 = imagecreate($ancho_dest, $alto_dest);

        // Redimensionar
        // imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+
        @imagecopyresampled($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig) or imagecopyresized($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig);

        // Crear fichero nuevo, según extensión.
        if ($tipo == 1) // GIF
            if (function_exists("imagegif"))
                imagegif($img2, $ruta2);
            else
                return false;

        if ($tipo == 2) // JPG
            if (function_exists("imagejpeg"))
                imagejpeg($img2, $ruta2);
            else
                return false;

        if ($tipo == 3)  // PNG
            if (function_exists("imagepng"))
                imagepng($img2, $ruta2);
            else
                return false;

        return true;
    }

    public function __toString()
    {
        return $this->filename;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entradas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add entradas
     *
     * @param \Cai\WebBundle\Entity\Entrada $entradas
     * @return Imagen
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
     * Add slide
     *
     * @param \Cai\WebBundle\Entity\Slide $slide
     * @return Imagen
     */
    public function addSlide(\Cai\WebBundle\Entity\Slide $slide)
    {
        $this->slide[] = $slide;

        return $this;
    }

    /**
     * Remove slide
     *
     * @param \Cai\WebBundle\Entity\Slide $slide
     */
    public function removeSlide(\Cai\WebBundle\Entity\Slide $slide)
    {
        $this->slide->removeElement($slide);
    }

    /**
     * Get slide
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSlide()
    {
        return $this->slide;
    }
}
