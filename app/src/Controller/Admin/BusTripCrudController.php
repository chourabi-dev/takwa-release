<?php

namespace App\Controller\Admin;

use App\Entity\BusTrip;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class BusTripCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BusTrip::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setLabel('#')->hideOnForm(), 
            AssociationField::new('driver')->setLabel('Driver'),
            AssociationField::new('trip')->setLabel('Reservation'),
            IntegerField::new('status')->setLabel('Status')->setTemplatePath('admin/elements/status.html.twig'),
            
        ];
    }
    
}
