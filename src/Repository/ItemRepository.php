<?php


namespace App\Repository;


use App\Entity\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Item;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function findLastStatus (int $status, int $limit = 5) : array
    {
        $qb = $this->createQueryBuilder('i');

        $qb = $qb->innerJoin('i.status', 's')
            ->where($qb->expr()->eq('s.id', $status))
            ->orderBy('i.createdAt', 'DESC')
            ->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult();
    }
}