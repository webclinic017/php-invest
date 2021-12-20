<?php

namespace App\Repository;

use App\Entity\Execution;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Execution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Execution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Execution[]    findAll()
 * @method Execution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExecutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Execution::class);
    }

    public function getPositionsForUser(User $user)
    {
        $q = $this->_em->createQueryBuilder()
            ->select(
                'i as instrument',
                'a.id as accountid',
                'a.name as accountname',
                'asset.id as assetid',
                'asset.name as assetname',
                'asset.symbol as assetsymbol',
                'SUM(e.amount * e.direction) as amount',
                'SUM(e.price * e.amount * e.direction) AS totalvalue'
            )
            ->from('App\Entity\Account', 'a')
            ->innerJoin('App\Entity\Transaction', 't', Join::WITH, 't.account = a.id')
            ->innerJoin('App\Entity\Execution', 'e', Join::WITH, 'e.transaction = t.id')
            ->innerJoin('App\Entity\Instrument', 'i', Join::WITH, 'i.id = t.instrument')
            ->innerJoin('App\Entity\Asset', 'asset', Join::WITH, 'asset.id = i.underlying')
            ->where('a.owner = :user')
            ->groupBy('t.instrument')
            ->setParameter('user', $user)
            ->getQuery();
        return $q->getResult();
    }
}