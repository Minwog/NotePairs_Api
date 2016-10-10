<?php

namespace AppBundle\Repository;

/**
 * CoursHasGroupeRepository
 *
 */
class CoursHasGroupeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCoursByGroupe($id)
    {
        return $this->_em->createQuery(
            "
            SELECT DISTINCT c
            FROM  AppBundle:CoursHasGroupe chg, AppBundle:Cours c, AppBundle:Groupe g
            WHERE g.id=chg.groupe AND c.id=chg.cours AND g.id=$id"
        );
    }

    public function findGroupeByCours($id)
    {
        return $this->_em->createQuery(
            "
            SELECT DISTINCT g
            FROM  AppBundle:CoursHasGroupe chg, AppBundle:Cours c, AppBundle:Groupe g
            WHERE g.id=chg.groupe AND c.id=chg.cours AND c.id=$id"
        );
    }
}