<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setLabel('#')->hideOnForm(),
            TextField::new('title')->setColumns(12),
            ImageField::new('image')->setColumns(12)->setBasePath('/images/events/')->setUploadDir('public/images/events/'),
            TextEditorField::new('content')->setColumns(12),


            DateField::new('startDate')->setColumns(6)->setCssClass('w-100'),
            TimeField::new('startTime')->setColumns(6)->setCssClass('w-100'),
            
            DateField::new('endDate')->setColumns(6)->setCssClass('w-100'),
            TimeField::new('time')->setLabel('End time')->setColumns(6)->setCssClass('w-100'),
        
        ];
    }
    
}
