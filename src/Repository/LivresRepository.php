<?php

namespace App\Repository;

use App\Entity\categories;
use App\Entity\Livres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livres>
 *
 * @method Livres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livres[]    findAll()
 * @method Livres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livres::class);
    }

//    /**
//     * @return Livres[] Returns an array of Livres objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }



    /**
    * @return Livres[] Returns an array of Livres objects
     */
    public function findGreaterThan($prix): array
    {
        return $this->createQueryBuilder('l') // l est un objet livreeeee                               
           ->andWhere('l.prix > :val')
           ->setParameter('val', $prix)
            ->orderBy('l.id', 'ASC')
           //->setMaxResults(10)
            ->getQuery()
            ->getResult()
       ;
   }
/**
 * @param string|null $searchTerm
 * @return Livres[] Returns an array of Livres objects
 */
public function rechercher(?string $searchTerm): array
{
    $query = $this->createQueryBuilder('l');

    if ($searchTerm) {
        $query->andWhere('l.titre LIKE :searchTerm OR l.editeur LIKE :searchTerm')
              ->setParameter('searchTerm', '%'.$searchTerm.'%');
    }

    return $query->setMaxResults(10)
                 ->getQuery()
                 ->getResult();
}

public function findCategorieById(EntityManager $em,$id): ?categories
{
    return $em->find(categories::class, $id);
}




//    public function findOneBySomeField($value): ?Livres
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
