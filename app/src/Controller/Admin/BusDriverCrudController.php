<?php

namespace App\Controller\Admin;

use App\Entity\BusDriver;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BusDriverCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BusDriver::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setLabel('#')->hideOnForm(),
            TextField::new('fullname')->setColumns(12),
            TextField::new('cin')->setColumns(12),
            
            TextField::new('phone')->setColumns(12),
            TextField::new('email')->setColumns(12),
            TextField::new('address')->setColumns(12),
            TextField::new('accessCode')->setColumns(12),
             

            ImageField::new('avatar')->setRequired(false)->setColumns(12)->setBasePath('/images/bus-drivers/')->setUploadDir('public/images/bus-drivers/'),
         
        ];
    }
    
}
