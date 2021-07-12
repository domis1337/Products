<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    /**
     * @return Cars[]
     */
    public function findByUseridField($value, $order)
    {
		switch ($order) {
			case 1:
				return $this->createQueryBuilder('o')
					->andWhere('o.user_id = :val')
					->setParameter('val', $value)
					->orderBy('o.created_at', 'ASC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;
				break;
			case 2:
				return $this->createQueryBuilder('o')
					->andWhere('o.user_id = :val')
					->setParameter('val', $value)
					->orderBy('o.created_at', 'DESC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;
				break;
			default:
				return $this->createQueryBuilder('o')
					->andWhere('o.user_id = :val')
					->setParameter('val', $value)
					->orderBy('o.id', 'ASC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;	
		}
    }
	
	public function findByEmailField($value, $order)
    {
        switch ($order) {
			case 1:
				return $this->createQueryBuilder('o')
					->andWhere('o.email = :val')
					->setParameter('val', $value)
					->orderBy('o.created_at', 'ASC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;
				break;
			case 2:
				return $this->createQueryBuilder('o')
					->andWhere('o.email = :val')
					->setParameter('val', $value)
					->orderBy('o.created_at', 'DESC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;
				break;
			default:
				return $this->createQueryBuilder('o')
					->andWhere('o.email = :val')
					->setParameter('val', $value)
					->orderBy('o.id', 'ASC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;	
		}
    }
	
	public function findAllOrders($value, $order)
    {
        switch ($order) {
			case 1:
				return $this->createQueryBuilder('o')
					->orderBy('o.created_at', 'ASC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;
				break;
			case 2:
				return $this->createQueryBuilder('o')
					->orderBy('o.created_at', 'DESC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;
				break;
			default:
				return $this->createQueryBuilder('o')
					->orderBy('o.id', 'ASC')
					//->setMaxResults(10)
					->getQuery()
					->getResult()
				;	
		}
    }
	
	public function findOneByIdField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id like :val')
			->setParameter('val', '%'.$value.'%')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Orders
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
