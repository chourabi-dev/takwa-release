<?php

namespace App\Controller\Admin;

use App\Entity\TripType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TripTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TripType::class;
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
