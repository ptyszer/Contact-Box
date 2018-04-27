<?php

namespace ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="ContactBundle\Repository\PersonRepository")
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=50)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="imagePath", type="string", length=255, nullable=true)
     */
    private $imagePath;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="person")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person")
     */
    private $phoneNumbers;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="person")
     */
    private $emails;

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Person
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phoneNumbers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add phoneNumber
     *
     * @param \ContactBundle\Entity\Phone $phoneNumber
     *
     * @return Person
     */
    public function addPhoneNumber(\ContactBundle\Entity\Phone $phoneNumber)
    {
        $this->phoneNumbers[] = $phoneNumber;

        return $this;
    }

    /**
     * Remove phoneNumber
     *
     * @param \ContactBundle\Entity\Phone $phoneNumber
     */
    public function removePhoneNumber(\ContactBundle\Entity\Phone $phoneNumber)
    {
        $this->phoneNumbers->removeElement($phoneNumber);
    }

    /**
     * Get phoneNumbers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * Add email
     *
     * @param \ContactBundle\Entity\Email $email
     *
     * @return Person
     */
    public function addEmail(\ContactBundle\Entity\Email $email)
    {
        $this->emails[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \ContactBundle\Entity\Email $email
     */
    public function removeEmail(\ContactBundle\Entity\Email $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add address
     *
     * @param \ContactBundle\Entity\Address $address
     *
     * @return Person
     */
    public function addAddress(\ContactBundle\Entity\Address $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \ContactBundle\Entity\Address $address
     */
    public function removeAddress(\ContactBundle\Entity\Address $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
}
