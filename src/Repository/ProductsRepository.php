<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    // /**
    //  * @return Products[] Returns an array of Products objects
    //  */
	
	/*public function findOrderProducts($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'select p
			from App\Entity\Products p
			inner join App\Entity\OrdersProducts op on p.id = op.product_id
			where
			op.order_id = :val'
        )->setParameter('val', $value);

        // returns an array of Product objects
        return $query->getResult();
    }
	*/
	
	public function findOrderProducts($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'select p from App\Entity\Products p join App\Entity\OrdersProducts op where op.order_id = :val and op.product_id is not null'
        )->setParameter('val', $value);

        // returns an array of Product objects
        return $query->getResult();
    }
	
	/*public function findOrderProducts($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $em->createQuery(
            'select p
			from App\Entity\Products p
			inner join App\Entity\OrdersProducts op
			on p.id = op.product_id
			where
			op.order_id = :val'
        )->setParameter('val', $searchValue);
		
		$qb = $em->createQueryBuilder('p')
        ->join('od.order', 'o')
        ->addSelect('o')
        ->where('o.userid = :userid')
        ->andWhere('od.orderstatusid IN (:orderstatusid)')
        ->setParameter('userid', $userid)
        ->setParameter('orderstatusid', array(5, 6, 7, 8, 10))
        ->getQuery()->getResult()
		;

        // returns an array of Product objects
        return $query->getResult();
    }
	*/
	
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Products
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
