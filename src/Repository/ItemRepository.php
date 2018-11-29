<?php


namespace App\Repository;


use App\Entity\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Item;
use Doctrine\ORM\NonUniqueResultException;
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

    public function findByStatus (string $status, int $limit = null) : array
    {
        $qb = $this->createQueryBuilder('i');

        $qb = $qb->innerJoin('i.status', 's')
            ->where($qb->expr()->eq('s.label', ":status"))
            ->andWhere($qb->expr()->isNull('i.dateEnd'))
            ->orderBy('i.createdAt', 'DESC')
            ->setMaxResults($limit);

        return $qb->setParameter('status', $status)
                ->getQuery()
            ->getResult();
    }

    public function findByCategory(int $category) : array
    {
        $qb = $this->createQueryBuilder('i');

        $qb = $qb->where($qb->expr()->eq('i.category', ":category"))
            ->andWhere($qb->expr()->isNull('i.dateEnd'))
            ->orderBy('i.createdAt', 'DESC');

        return $qb->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function findByCity (int $cityId) : array
    {
        $qb = $this->createQueryBuilder('i');

        $qb = $qb->where($qb->expr()->eq('i.city', $cityId));

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findBySearch(int $category, int $county , string $date = null) : array
    {
        $qb = $this->createQueryBuilder('i');

        $qb = $qb->where($qb->expr()->eq('i.category', ":category"))
        ->andWhere($qb->expr()->eq('i.county', ":county"));

        if ($date) {
            $qb = $qb->andWhere($qb->expr()->eq('i.dateBegin', ':date'))
                    ->setParameter('date', $date);
        }

        return $qb->setParameter('category', $category)
            ->setParameter('county', $county)
            ->getQuery()
            ->getResult();
    }

    public function findItemsResolved()
    {
        $qb = $this->createQueryBuilder('i');

            $qb
                ->select('COUNT(i)')
                ->where($qb->expr()->isNotNull('i.dateEnd'));
        try {
            return $qb->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
        }

    }
}