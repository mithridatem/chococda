<?php

namespace App\Repository;

use App\Entity\Chocoblast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\TopChocoblastAuthorDTO;
/**
 * @extends ServiceEntityRepository<Chocoblast>
 *
 * @method Chocoblast|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chocoblast|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chocoblast[]    findAll()
 * @method Chocoblast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChocoblastRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chocoblast::class);
    }

    //    /**
    //     * @return Chocoblast[] Returns an array of Chocoblast objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Chocoblast
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

        public function countChocoblast(){
            return $this->createQueryBuilder('c')
                ->select(
                    'NEW App\DTO\ExempleDTO(a.lastname, a.firstname, COUNT(a.id))'
                )
                ->innerJoin('c.author', 'a')
                ->groupBy('a.id')
                ->getQuery()
                ->getResult();
        }

        /**
         * @return TopChocoblastAuthorDTO[]
         */
        public function topChocoblastAuthor() {
            return $this->createQueryBuilder('c')
                ->select('NEW App\DTO\TopChocoblastAuthorDTO(u.firstname, u.lastname, COUNT(u.id))')
                ->innerJoin('c.author', 'u')
                ->groupBy('u.id')
                ->getQuery()
                ->getResult();
        }

                /**
         * @return TopChocoblastAuthorDTO[]
         */
        public function topChocoblastTarget() {
            return $this->createQueryBuilder('c')
                ->select('NEW App\DTO\TopChocoblastAuthorDTO(u.firstname, u.lastname, COUNT(u.id))')
                ->innerJoin('c.target', 'u')
                ->groupBy('u.id')
                ->getQuery()
                ->getResult();
        }
}
