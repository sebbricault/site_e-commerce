<?php

namespace App\Repository;

use App\Entity\Commmantaire;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @extends ServiceEntityRepository<Commmantaire>
 *
 * @method Commmantaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commmantaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commmantaire[]    findAll()
 * @method Commmantaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommmantaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commmantaire::class);
    }

    public function save(Commmantaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commmantaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Commmantaire[] Returns an array of Commmantaire objects
    */
   public function findByComm(int $value): array
   {
       return $this->createQueryBuilder('c')
    //    ->leftJoin(Product::class, 'd', 'c.produit_id = d.id')
           ->select('c')
           ->Where('c.produit =:val ')
            ->setParameter('val', $value)
           ->getQuery()
           ->getResult();

       ;
   }

//    public function findOneBySomeField($value): ?Commmantaire
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
