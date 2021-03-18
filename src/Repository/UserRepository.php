<?php
// src/App/Repository/UserRepository.php
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getDeelnemers($activiteitid)
    {
        $em = $this->getEntityManager();


        $query = $em->createQuery("SELECT d FROM App:User d WHERE :activiteitid MEMBER OF d.activiteiten");

        $query->setParameter('activiteitid', $activiteitid);

        return $query->getResult();
    }
}