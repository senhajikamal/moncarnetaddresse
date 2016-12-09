<?php
namespace CarnetBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 */
 
class Contact
{   /**
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    
     /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;
     /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;
    /**
     * @ORM\Column(type="string", length=255,  nullable=true )
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=255,  nullable=true )
     */
    private $adresse;
     /**
     * @ORM\Column(type="string", length=255,  nullable=true )
     */
    private $tel;
    /**
     * @ORM\Column(type="string", length=255,  nullable=true )
     */
    private $website;
    
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
     * Set nom
     *
     * @param string $nom
     * @return Contact
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }
    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Contact
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }
    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
    /**
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Contact
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }
    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
    /**
     * Set tel
     *
     * @param string $tel
     * @return Contact
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
        return $this;
    }
    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }
    /**
     * Set website
     *
     * @param string $website
     * @return Contact
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }
    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }
   
    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $idUser
     * @return Contact
     */
    public function setIdUser(\AppBundle\Entity\User $idUser = null)
    {
        $this->user = $idUser;
        return $this;
    }
    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getIdUser()
    {
        return $this->user;
    }
    /**
     * Set user
     *
     * @param \CarnetBundle\Entity\Utilisateurs $user
     * @return Contact
     */
    public function setUser(\CarnetBundle\Entity\Utilisateurs $user)
    {
        $this->user = $user;
        return $this;
    }
    /**
     * Get user
     *
     * @return \CarnetBundle\Entity\Utilisateurs 
     */
    public function getUser()
    {
        return $this->user;
    }
}
?>