<?php

namespace App\Repository;

use App\Entity\Activiteit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * ActiviteitRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActiviteitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activiteit::class);
    }

    public function getBeschikbareActiviteiten($userid): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.datum, a.tijd, a.max_deelnemers as maxDeelnemers')
            ->leftJoin('a.users', 'u', Join::WITH, 'u.id = :id')
            ->andWhere('u.id IS NULL')
            ->setParameter('id', $userid)
            ->join('a.soort', 's')
            ->addSelect('s.naam, s.prijs')
            ->leftJoin('a.users', 'u1')
            ->addSelect('COUNT(u1.id) as totaalRegistraties')
            ->andWhere('a.datum >= CURRENT_DATE()')
            ->having('maxDeelnemers > totaalRegistraties')
            ->groupBy('a.id')
            ->orderBy('a.datum')
            ->getQuery()
            ->getResult();
    }

    public function getIngeschrevenActiviteiten($userid)
    {

        return $this->createQueryBuilder('a')
            ->select('a.id, a.datum, a.tijd, a.max_deelnemers as maxDeelnemers')
            ->leftJoin('a.users', 'u',)
            ->andWhere('u.id = :id')
            ->setParameter('id', $userid)
            ->join('a.soort', 's')
            ->addSelect('s.naam, s.prijs')
            ->leftJoin('a.users', 'u1')
            ->addSelect('COUNT(u1.id) as totaalRegistraties')
            ->andWhere('a.datum >= CURRENT_DATE()')
            ->groupBy('a.id')
            ->orderBy('a.datum')
            ->getQuery()
            ->getResult();
    }

    public function getTotaal($activiteiten)
    {

        $totaal = 0;
        foreach ($activiteiten as $a) {
            $totaal += $a['prijs'];
        }
        return $totaal;

    }

    public function findAll()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.datum >= CURRENT_DATE()')
            ->orderBy('a.datum')
            ->getQuery()
            ->getResult();
    }

    public function getTotaalActiviteiten(): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getAantalDeelnemers($activiteitid)
    {
        $em = $this->getEntityManager();


        $query = $em->createQuery("SELECT d FROM App:User d WHERE :activiteitid MEMBER OF d.activiteiten")
            ->getSingleScalarResult();

        $query->setParameter('activiteitid', $activiteitid);

        return $query->getResult();
    }
}
