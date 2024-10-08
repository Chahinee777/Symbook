<?php

namespace App\Controller\Admin;

use App\Entity\Livres;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class LivresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livres::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre', 'Titre'),
            TextField::new('slug', 'Slug'),
            ImageField::new('image', 'Image')->setUploadDir('public/uploads/images')->setBasePath('uploads/images'),
            TextField::new('ISBN', 'ISBN'),
            TextField::new('editeur', 'Éditeur'),
            DateTimeField::new('editedAt', 'Date d\'édition'),
            TextEditorField::new('resume', 'Résumé'),
            NumberField::new('prix', 'Prix'),
            AssociationField::new('categorie', 'Catégorie'),
            TextField::new('auteur', 'Auteur'),
        ];
    }
}
?>