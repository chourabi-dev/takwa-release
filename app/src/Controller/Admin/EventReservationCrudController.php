<?php

namespace App\Controller\Admin;

use App\Entity\EventReservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EventReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventReservation::class;
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
