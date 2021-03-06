<?php

namespace Alala\MoviedbBundle\Repository;

/**
 * MovieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MovieRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Recherche en fonction de filtre et retourne avec une page et un nombre délément définit
     * @param array $filters
     * @param number $page page de résultat à renvoyer
     * @param number $bypage nombre de résultat à renvoyer
     * @return array|mixed|\Doctrine\DBAL\Driver\Statement|NULL
     */
    public function search($filters = null, $page = 1, $bypage = 15){
        
        $qb = $this->createQueryBuilder('mo');
        if($filters){
            foreach($filters as $field => $filter){
                $qb->where($field . ' LIKE :filter')
                    ->setParameter('filter', $value);
            }
        }
        
        $qb->setMaxResults($bypage);
        $qb->setFirstResult((($page - 1) * $bypage));
        
        return $qb->getQuery()->getResult();
    }

    public function total($filters = null){
        $qb = $this->createQueryBuilder('mo')
            ->select('mo.id');
        if($filters){
            foreach($filters as $field => $filter){
                $qb->where($field . ' LIKE :filter')
                    ->setParameter('filter', $value);
            }
        }

        return count($qb->getQuery()->getArrayResult());
    }
}
