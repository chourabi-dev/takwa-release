<?php

namespace App\Controller\Admin;

use App\Entity\BusDriver;
use App\Entity\BusReservations;
use App\Entity\BusTrip;
use App\Entity\Event;
use App\Entity\EventReservation;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\RoomPhoto;
use App\Entity\RoomReservation;
use App\Entity\Trip;
use App\Entity\TripReservation;
use App\Entity\TripType;
use DateTime;
use DateTimeZone;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
{


    function sendPuchNotification(BusDriver $driver, $title, $content){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "to":"'.$driver->getFcm().'",
          "notification":{
            "title":"'.$title.'",
            "body":"'.$content.'"
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: key=AAAAo5izmBI:APA91bHEARU7Abgln4fqD4ln2verHvo-KiH9BbWU8Lv-P9S7cVl3cnSVbIwj3Rmykan8Hq8UDp15RrT59ttkr64BgUEUZ84Pwfyqcc730EGB2uNdHG3RgoSH6oT6btonT3vPpppnFzVG',
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;
    }






    /**
     * @Route("/admin", name="admin_route")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig',[]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Ambiance voyage');
    }






    /**
     * @Route("/admin/new-trip-selector", name="new_bus_trip_route")
     */
    public function new_trip_for_bus_driver(AdminContext $adminContext): Response
    {
        $busreservations = $this->getDoctrine()->getRepository(BusReservations::class)->findAll();
        $drivers = $this->getDoctrine()->getRepository(BusDriver::class)->findAll();

        if( $adminContext->getRequest()->getMethod() == 'POST' ){
            $body = $adminContext->getRequest()->request;

            $driver = $this->getDoctrine()->getRepository(BusDriver::class)->findOneBy(['id'=>$body->get('driver')]);
            $reservation = $this->getDoctrine()->getRepository(BusReservations::class)->findOneBy(['id'=>$body->get('reservation')]);

            $busTrip = new BusTrip();
            $busTrip->setDriver($driver);
            $busTrip->setTrip($reservation);
            $busTrip->setCreatedAt(new DateTime('now',new DateTimeZone('africa/tunis')));
            $busTrip->setStatus(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($busTrip);
            $entityManager->flush();


            $this->sendPuchNotification($driver,'Nouvel voyage','Vous avez un nouveau voyage, veuillez vérifier votre application');


            // flushh success
            $this->addFlash('success', 'Trip added successfully');
            
        }





        return $this->render('admin/new-trip-bus.html.twig',[
            'drivers'=>$drivers,
            'reservations'=>$busreservations
        ]);
    }







    public function configureMenuItems(): iterable
    {
        $reservations = $this->getDoctrine()->getRepository(RoomReservation::class)->findAll();
        $reservationsEvents = $this->getDoctrine()->getRepository(EventReservation::class)->findAll();
        $busreservations = $this->getDoctrine()->getRepository(BusReservations::class)->findAll();
        
        $tripReservations = $this->getDoctrine()->getRepository(TripReservation::class)->findAll();
        
        

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Regions', 'fas fa-list', Region::class);
        yield MenuItem::linkToCrud('Drivers', 'fas fa-bus', BusDriver::class);
        yield MenuItem::linkToCrud('Bus reservations', 'fa fa-bus', BusReservations::class)->setBadge(sizeof($busreservations));
        

        yield MenuItem::linkToRoute('New bus trip', 'fa fa-bus', 'new_bus_trip_route');
        
        yield MenuItem::linkToCrud('Ongoing bus trip', 'fa fa-bus', BusTrip::class);
        



        yield MenuItem::linkToCrud('Trip types', 'fas fa-list', TripType::class);
        
        yield MenuItem::linkToCrud('Rooms', 'fa fa-bed', Room::class);
        yield MenuItem::linkToCrud('Rooms reservations', 'fa fa-bed', RoomReservation::class)->setBadge(sizeof($reservations));
        

        yield MenuItem::linkToCrud('Trips', 'fa fa-plane', Trip::class);
        yield MenuItem::linkToCrud('Trip reservations', 'fa fa-plane', TripReservation::class)->setBadge(sizeof($tripReservations));
        

        yield MenuItem::linkToCrud('Rooms photos', 'fa fa-camera', RoomPhoto::class); 
        yield MenuItem::linkToCrud('Events', 'fa fa-calendar', Event::class); 
        yield MenuItem::linkToCrud('Event reservations', 'fa fa-calendar', EventReservation::class)->setBadge(sizeof($reservationsEvents));
        
        
       
        
        
    }
}
