<?php

namespace App\Controller\Admin;

use App\Entity\RoomReservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class RoomReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RoomReservation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('room'),
            AssociationField::new('user'),
            DateTimeField::new('checkIn'),
            DateTimeField::new('checkout'), 
            DateTimeField::new('createdAt')
            
        ];
    }
    
}
