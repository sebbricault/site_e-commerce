<?php

namespace App\Controller\Admin;

use App\Entity\Commmantaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommmantaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commmantaire::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
