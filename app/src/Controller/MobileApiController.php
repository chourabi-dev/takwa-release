<?php

namespace App\Controller;

use App\Repository\BusDriverRepository;
use App\Repository\BusReservationsRepository;
use App\Repository\BusTripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mobile/api")
 */
class MobileApiController extends AbstractController
{
    /**
     * @Route("/auth", name="auth_route")
     */
    public function auth(Request $request, BusDriverRepository $busDriverRepository): Response
    {
        $body = $request->request;
        $access_code = $body->get('access_code');

        $driver = $busDriverRepository->findOneBy(['accessCode'=>$access_code]);

        if ( $driver != null ) {
            $token = md5(uniqid());

            $driver->setToken($token);

            // save it
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($driver);
            $entityManager->flush();

            return $this->json(['success'=>true,   'token'=>$token]);
            
        } else {
            return $this->json(['success'=>false, 'message'=>"Mauvais code d'accès." ]);
        }
        


    }









    /**
     * @Route("/info", name="my_info_route")
     */
    public function my_info_route(Request $request, BusDriverRepository $busDriverRepository): Response
    {
        $body = $request->request;
        $token = $request->headers->get('Authorization');
        $driver = $busDriverRepository->findOneBy(['token'=>$token]); 

        return $this->json([
            'id'=>$driver->getId(),
            'fullname'=>$driver->getFullname(),
            'email'=>$driver->getEmail(),
            'photo'=>'http://localhost:8000/images/bus-drivers/'.$driver->getAvatar()
            
        ]); 
    }




    
    /**
     * @Route("/save-fcm", name="save_my_fcm_route")
     */
    public function save_my_fcm_route(Request $request, BusDriverRepository $busDriverRepository): Response
    {
        $body = $request->request;
        $token = $request->headers->get('Authorization');
        $driver = $busDriverRepository->findOneBy(['token'=>$token]); 

        $driver->setFcm($body->get('fcm')); 
        return $this->json(['success'=>true]);
    }


    /**
     * @Route("/update-trip-status", name="update_trip_status_route")
     */
    public function update_trip_status_route(Request $request, BusTripRepository $repo): Response
    {
        $body = $request->request;
        $token = $request->headers->get('Authorization');

        $reservation = $repo->findOneBy(['id'=>$body->get('id')]);
        $reservation->setStatus($body->get('status'));
        
        $em  = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();

        
        return $this->json(['success'=>true]);
    
    }

    


    
    /**
     * @Route("/trips", name="my_trips_route")
     */
    public function trips(Request $request, BusDriverRepository $busDriverRepository): Response
    {
        $body = $request->request;
        $token = $request->headers->get('Authorization');
        $driver = $busDriverRepository->findOneBy(['token'=>$token]); 


        $trips = [];

        foreach ($driver->getBusTrips() as $key => $trip) {
            array_push(
                $trips,
                array(
                    'id'=>$trip->getId(), 
                    'createdAt'=>$trip->getCreatedAt()->format('d/m/y H:i'),
                    'status'=>$trip->getStatus(),
                    'destination'=>$trip->getTrip()->getDestination(),
                    'contact_name'=>$trip->getTrip()->getContactName(),
                    'check_in'=>$trip->getTrip()->getCheckin()->format('d/m/y H:i'),
                    'check_out'=>$trip->getTrip()->getCheckout()->format('d/m/y H:i'),
                    'places'=>$trip->getTrip()->getPlaces(),
                    'phone'=>$trip->getTrip()->getPhone(),
                    'email'=>$trip->getTrip()->getEmail()  
                )
            );
        }

        return $this->json($trips); 
    }



    
}
