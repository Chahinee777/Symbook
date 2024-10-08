<?php

namespace App\Repository;

use App\Entity\Lignecommandes;
use App\Entity\Livres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LignecommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lignecommandes::class);
    }

    public function findBestSellingBookByPeriod(string $period)
    {
        $startDate = $this->getStartDateForPeriod($period);

        $result = $this->createQueryBuilder('lc')
            ->select('IDENTITY(lc.livre) as livreId, SUM(lc.quantite) AS totalQuantity')
            ->andWhere('lc.createdAt >= :startDate')
            ->setParameter('startDate', $startDate)
            ->groupBy('livreId')
            ->orderBy('totalQuantity', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }

    private function getStartDateForPeriod(string $period): \DateTime
    {
        switch ($period) {
            case 'weekly':
                return new \DateTime('monday this week');
            case 'monthly':
                return new \DateTime('first day of this month');
            case 'daily':
            default:
                return new \DateTime('today');
        }
    }
}
?>
