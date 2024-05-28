<?php

namespace App\Controller;

use App\Entity\BusReservations;
use App\Entity\EventReservation;
use App\Entity\RoomReservation;
use App\Entity\TripReservation;
use App\Form\BusReservationType;
use App\Repository\EventRepository;
use App\Repository\EventReservationRepository;
use App\Repository\RegionRepository;
use App\Repository\RoomRepository;
use App\Repository\RoomReservationRepository;
use App\Repository\TripRepository;
use App\Repository\TripReservationRepository;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index_route")
     */
    public function index( RegionRepository $regionRepository ): Response
    {
        return $this->render('main/index.html.twig', [
            'regions'=>$regionRepository->findAll() 
        ]);
    }


    

    /**
    * @Route("/our-trips", name="our_trips_route")
    */
   public function our_trips_route(TripRepository $tripRepository, Request $request): Response
   {
       $type = $request->query->get('type');
       $trips = [];

       if( $type != null ){
           $trips = $tripRepository->findBy(['type'=>$type]);
       }else{
           $trips = $tripRepository->findAll();
       }

       return $this->render('main/trips.html.twig', [
           'trips'=> $trips
       ]);
   }



    /**
    * @Route("/our-trips/details/trip/{id}", name="trip_details_route")
    */
    public function trip_details_route(TripRepository $tripRepository, Request $request, $id): Response
    {
        $trip = $tripRepository->findOneBy(['id'=>$id]);
        $success = null;
        $error = null;
    
        return $this->render('main/trip-details.html.twig', [
            'trip'=> $trip,
            'error'=>$error,
            'success'=>$success
        ]);
    }


    /**
    * @Route("/app-user/our-trips/details/trip/{id}/make-reservation", name="send_reservation_for_trip_route")
    */
    public function send_reservation_for_trip_route(TripRepository $tripRepository, TripReservationRepository $tripReservationRepository, Request $request, $id): Response
    {
        $trip = $tripRepository->findOneBy(['id'=>$id]);
        $success = null;
        $error = null;


        $check = $tripReservationRepository->findOneBy(['trip'=>$trip->getId(), 'user'=>$this->getUser()->getId()]);

        if( $check == null ){
            $reservation = new TripReservation();
            $reservation->setCreatedAt( new DateTime('now', new DateTimeZone('africa/tunis')) );
            $reservation->setUser($this->getUser());
            $reservation->setTrip($trip);
            // save it
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
            

            $success ='Réservation effectuée avec succès';
        }else{
            $error ='Réservation déjà envoyée veuillez patienter, nous vous contacterons bientôt';
        }




    
        return $this->render('main/trip-details.html.twig', [
            'trip'=> $trip,
            'error'=>$error,
            'success'=>$success
        ]);
    }
 


    


    /**
     * @Route("/events", name="events_route")
     */
    public function events(EventRepository $eventRepository): Response
    {
        return $this->render('main/events.html.twig', [
            'events'=>$eventRepository->findAll()
        ]);
    }



    /**
     * @Route("/app-user/bus-reservation", name="bus_reservation_route")
     */
    public function bus_reservation_route(Request $request): Response
    {
        // create BusReservation form 
        $busReservation = new BusReservations();
        $user = $this->getUser();

        $success = null;
        
        $form = $this->createForm(BusReservationType::class, $busReservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $busReservation->setStatus(0);
            $busReservation->setClient($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($busReservation);
            $entityManager->flush();

            $success = 'Demande de reservation enregistrée avec success';


        }


 

        return $this->render('main/bus-reservation.html.twig', [
            'success'=>$success,
            'form'=>$form->createView()
        ]);
    }



    /**
     * @Route("/hotel-reservations", name="rooms_list")
     */
    public function rooms_list(RoomRepository $roomRepository, Request $request): Response
    {
        $region = $request->query->get('region');
        $rooms = [];

        if( $region != null ){
            $rooms = $roomRepository->findBy(['region'=>$region]);
        }else{
            $rooms = $roomRepository->findAll();
        }

        return $this->render('main/rooms.html.twig', [
            'rooms'=> $rooms
        ]);
    }





    /**
     * @Route("/hotel-reservations/listing/{id}", name="room_details_route")
     */
    public function room_details_route(RoomRepository $roomRepository, Request $request, $id): Response
    {
        $room = $roomRepository->findOneBy(['id'=>$id]);
        $success = null;
        $error = null;
        return $this->render('main/room.html.twig', [
            'room'=> $room,
            'error'=>$error,
            'success'=>$success
        ]);
    }







   


    


    


    /**
     * @Route("/events/details/{id}", name="event_details_route")
     */
    public function event_details(EventRepository $eventRepository, $id): Response
    {
        $success = null;
        $error = null;
        
        $event = $eventRepository->findOneBy(['id'=>$id]);

        return $this->render('main/event.html.twig', [
            'event'=>$event,
            'error'=>$error,
            'success'=>$success
        ]);
    }


    /**
     * @Route("/app-user/events/details/{id}/book-event", name="event_details_book_route")
     */
    public function event_details_book_route(EventRepository $eventRepository,EventReservationRepository $eventReservationRepository, $id, Request $request): Response
    {
        $success = null;
        $error = null;

        if ($this->getUser() != null) {


            $event = $eventRepository->findOneBy(['id'=>$id]);

           if( $eventReservationRepository->findOneBy(['event'=>$event->getId(), 'user'=>$this->getUser()->getId()]) == null){
                $reservation = new EventReservation();
                $reservation->setUser($this->getUser());
                $reservation->setEvent($event);
                $reservation->setCreatedAt(new DateTime('now',new DateTimeZone('africa/tunis'))); 
                $eventReservationRepository->add($reservation,true);
  
                $success='Réservation enregistrée avec succès.';
           }else{
                $error='Réservation déjà enregistrée';
           }


            return $this->render('main/event.html.twig', [
                'event'=>$event,
                'error'=>$error,
                'success'=>$success
            ]);
            
        }else{
            return $this->redirectToRoute('app_login');
        }
    }





    /**
     * @Route("/app-user/hotel-reservations/listing/{id}/book-room", name="make_room_resercation")
     */
    public function make_room_resercation(RoomRepository $roomRepository,RoomReservationRepository $roomReservationRepository, $id, Request $request): Response
    {
        $success = null;
        $error = null;

        if ($this->getUser() != null) {


            $room = $roomRepository->findOneBy(['id'=>$id]);

           if( $roomReservationRepository->findOneBy(['room'=>$room->getId(), 'user'=>$this->getUser()->getId()]) == null ){
               $body = $request->request;

                $reservation = new RoomReservation();
                $reservation->setUser($this->getUser());
                $reservation->setRoom($room);
                $reservation->setCheckIn(new DateTime($body->get('checkin'),new DateTimeZone('africa/tunis')));
                $reservation->setCheckout(new DateTime($body->get('checkout'),new DateTimeZone('africa/tunis')));
                
                $reservation->setCreatedAt(new DateTime('now',new DateTimeZone('africa/tunis')));

                $roomReservationRepository->add($reservation,true);

                $success='Réservation enregistrée avec succès.';


           }else{
                $error='Réservation déjà enregistrée';
           }


            return $this->render('main/room.html.twig', [
                'room'=>$room,
                'error'=>$error,
                'success'=>$success
            ]);
            
        }else{
            return $this->redirectToRoute('app_login');
        }
    }





    


    
}
