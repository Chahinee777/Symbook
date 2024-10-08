<?php
namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Entity\Lignecommandes;
use App\Entity\Livres;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class AdminDashboardController extends AbstractDashboardController
{
    private $entityManager;
    private $logger;
    private $chartBuilder;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, ChartBuilderInterface $chartBuilder)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->chartBuilder = $chartBuilder;
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $period = $_GET['period'] ?? 'daily';

        $bestSellingBookData = $this->getBestSellingBook($period);
        $totalOrdersData = $this->getTotalOrders($period);

        return $this->render('admin/dashboard.html.twig', [
            'bestSellingBookData' => $bestSellingBookData,
            'totalOrdersData' => $totalOrdersData,
        ]);
    }

    #[Route('/admin/dashboard/best-selling-book', name: 'admin_dashboard_best_selling_book')]
    public function getBestSellingBookData(): JsonResponse
    {
        $period = $_GET['period'] ?? 'daily';
        $this->logger->info('Fetching best-selling book for period: ' . $period);
        $bestSellingBook = $this->getBestSellingBook($period);

        return new JsonResponse($bestSellingBook);
    }

    #[Route('/admin/dashboard/total-orders', name: 'admin_dashboard_total_orders')]
    public function getTotalOrdersData(): JsonResponse
    {
        $period = $_GET['period'] ?? 'daily';
        $this->logger->info('Fetching total orders for period: ' . $period);
        $totalOrders = $this->getTotalOrders($period);

        return new JsonResponse(['totalOrders' => $totalOrders]);
    }

    private function getBestSellingBook(string $period)
    {
        $repository = $this->entityManager->getRepository(Lignecommandes::class);
        $result = $repository->findBestSellingBookByPeriod($period);

        if ($result) {
            $livre = $this->entityManager->getRepository(Livres::class)->find($result['livreId']);
            return [
                'livre' => $livre->getTitre(),
                'totalQuantity' => $result['totalQuantity']
            ];
        }

        return null;
    }

    private function getTotalOrders(string $period): int
    {
        $repository = $this->entityManager->getRepository(Commande::class);
        $startDate = $this->getStartDateForPeriod($period);
        return $repository->countOrdersByPeriod($startDate, new \DateTime());
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

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('SymBook');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Commandes', 'fas fa-box', Commande::class);
        yield MenuItem::linkToCrud('Lignecommandes', 'fas fa-list', Lignecommandes::class);
        yield MenuItem::linkToCrud('Livres', 'fas fa-book', Livres::class);
    }
}
?>