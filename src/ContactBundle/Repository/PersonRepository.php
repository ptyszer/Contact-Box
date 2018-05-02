<?php

namespace ContactBundle\Repository;

/**
 * PersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllOrderedByName(){
        $em = $this->getEntityManager();
        $persons = $em->createQuery(
            'SELECT p FROM ContactBundle:Person p ORDER BY p.firstName ASC'
        )->getResult();
        return $persons;
    }
}
