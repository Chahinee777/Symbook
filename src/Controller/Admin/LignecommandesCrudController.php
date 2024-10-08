<?php

namespace App\Controller\Admin;

use App\Entity\Lignecommandes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class LignecommandesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lignecommandes::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('commande', 'Commande')->hideOnForm(),
            AssociationField::new('livre', 'Livre'),
            IntegerField::new('quantite', 'Quantité'),
        ];
    }
}
?>