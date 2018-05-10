<?php

namespace ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ContactGroup
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="ContactBundle\Repository\ContactGroupRepository")
 */
class ContactGroup
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
     * @ORM\Column(name="name", type="string", length=155, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Person", mappedBy="groups")
     */
    private $persons;

    /**
     * ContactGroup constructor.
     */
    public function __construct()
    {
        $this->persons = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return ContactGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add person to group
     *
     * @param \ContactBundle\Entity\Person $person
     *
     * @return ContactGroup
     */
    public function addPerson(\ContactBundle\Entity\Person $person)
    {
        $this->persons[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param \ContactBundle\Entity\Person $person
     */
    public function removePerson(\ContactBundle\Entity\Person $person)
    {
        $this->persons->removeElement($person);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersons()
    {
        return $this->persons;
    }
}

