<?php

namespace App\Controller\Admin;

use App\Entity\TripReservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class TripReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TripReservation::class;
    }


    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('trip')->setColumns(12)->setLabel('Trip'),
            AssociationField::new('user')->setColumns(12)->setLabel('User'),
             
            DateField::new('createdAt')->setColumns(6)->setLabel('Date'),
           

            

        ];
    }
}
