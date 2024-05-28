<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/redirect", name="redirect_route")
     */
    public function redirect_route(AuthenticationUtils $authenticationUtils): Response
    {
        if( $this->getUser() ){
            $role = $this->getUser()->getRoles()[0];

            if( $role == 'ROLE_ADMIN' ){
                return $this->redirectToRoute('admin_route');
            }

            if( $role == 'ROLE_USER' ){
                return $this->redirectToRoute('index_route');
            }
            

        }else{
            return $this->redirectToRoute('index_route');
        }
    }


    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }



    


    /**
     * @Route("/create-account", name="create_account_route")
     */
    public function create_account_route( Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $userPasswordEncoderInterface): Response
    {
        $error = '';
        if ( $request->getMethod() == 'POST' ) {
            
            $body = $request->request;
            
                if( $userRepository->findOneBy(['email'=>$body->get('email')]) == null ){
                    $user = new User();
                    $user->setEmail($body->get("email"));
                    $user->setPhone($body->get('phone'));
                    $user->setFullname($body->get('fullname')); 
                    $user->setRoles(['ROLE_USER']);
                    $user->setPassword( $userPasswordEncoderInterface->encodePassword($user,$body->get('password') )  );

                    $userRepository->add($user,true);

                    return $this->redirectToRoute('app_login');
                }else{
                    $error = 'Email déja utilisé.';
                }
            }

            return $this->render('security/create-account.html.twig', [
                'error'=>$error
            ]);
    }


    /**
     * @Route("/create-admin-account", name="create_admin_account_route")
     */
    public function create_admin_account_route(UserRepository $userRepository, UserPasswordEncoderInterface $userPasswordEncoderInterface): Response
    {
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword( $userPasswordEncoderInterface->encodePassword($user,'admin')  );

        $userRepository->add($user,true);

        return $this->render('security/login.html.twig', [
            
        ]);
    }




   

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
