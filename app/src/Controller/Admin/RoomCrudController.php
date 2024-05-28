<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Room::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title')->setColumns(12)->setLabel('Room name'),
            NumberField::new('price')->setColumns(12)->setLabel('Price'), 
            TextEditorField::new('description')->setColumns(12)->setLabel('Description'),

            TextField::new('address')->setColumns(12)->setLabel('Address'),
            


            NumberField::new('lng')->setColumns(6)->setLabel('Lng')->hideOnIndex(), 
            NumberField::new('lat')->setColumns(6)->setLabel('Lat')->hideOnIndex(),


            AssociationField::new('region')->setColumns(12)->setLabel('Region'),
            

            
            

            

        ];
    }
    
}
