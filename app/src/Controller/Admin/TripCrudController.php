<?php

namespace App\Controller\Admin;

use App\Entity\Trip;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TripCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trip::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('type')->setColumns(12)->setLabel('Type'),
            
            TextField::new('title')->setColumns(12)->setLabel('Title'),
            ImageField::new('photo')->setRequired(false)->setLabel('Image')->setColumns(6)->setCssClass('mb-3')->setBasePath('/images/trips/')->setUploadDir('public/images/trips/'),
            
            DateField::new('date')->setColumns(6)->setLabel('Date'),
            
            NumberField::new('tripDaysLong')->setColumns(12)->setLabel('Duration'), 
            TextEditorField::new('content')->setColumns(12)->setLabel('Description'),
            

            

        ];
    }
    
}
