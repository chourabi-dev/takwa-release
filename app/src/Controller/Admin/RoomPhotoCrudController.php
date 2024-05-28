<?php

namespace App\Controller\Admin;

use App\Entity\RoomPhoto;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class RoomPhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RoomPhoto::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            AssociationField::new('room')->setColumns(6)->setLabel('Room'),
            
            ImageField::new('photo')->setLabel('Image')->setColumns(6)->setCssClass('mb-3')->setBasePath('/images/rooms/')->setUploadDir('public/images/rooms/')
            
           
        ];
    }
    
}
