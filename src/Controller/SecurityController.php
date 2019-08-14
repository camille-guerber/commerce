<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route(
 *     path="/leboncoin/user"
 * )
 */
class SecurityController extends AbstractController
{
    /**
     * @Route(
     *     path="/register",
     *     name="app_register"
     * )
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        $registrationForm = $this->createForm(UserType::class, $user);
        $registrationForm->handleRequest($request);

        if($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice', 'Bravo '.$user->getUsername().' vous êtes désormais inscrit.');
            return $this->redirectToRoute('home_index');
        }

        return $this->render('security/register.html.twig', [
            'form' => $registrationForm->createView(),
            'title' => "Formulaire d'inscription",
        ]);
    }

    /**
     * @Route(
     *     path="/login",
     *     name="app_login"
     * )
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/block/login-modal.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route(
     *     path="/logout",
     *     name="app_logout",
     * )
     */
    public function logout(Request $request)
    {
        $this->addFlash('notice', "A bientôt !");
    }

    /**
     * @Route(
     *     path="/home",
     *     name="app_home",
     * )
     */
    public function home(Request $request)
    {
        $user = $this->getUser();

        return $this->render('security/user-home.html.twig', [
            'title' => 'Profil de '.$user->getUsername(),
            'user' => $user,
        ]);
    }

    /**
     * @Route(
     *     path="/profile",
     *     name="app_profile",
     * )
     */
    public function profile(Request $request)
    {
        $user = $this->getUser();

        if(null === $user) {
            $this->addFlash('notice', "Vous devez être connecté pour accéder à cette page.");
            return $this->redirectToRoute('app_login');
        }

        $userEditForm = $this->createForm(UserEditType::class, $user);

        $userEditForm->handleRequest($request);

        if($userEditForm->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('notice', 'Les informations de votre profil ont bien été mises à jour.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/user-profile.html.twig', [
            'form' => $userEditForm->createView(),
            'title' => 'Modifier mes informations',
        ]);
    }

    /**
     * @Route(
     *     path="/annonces",
     *     name="app_annonces",
     * )
     */
    public function annonces(Request $request)
    {
        $user = $this->getUser();

        $annonces = $this->getDoctrine()->getRepository(Produit::class)->findAllUserAnnoncesOrderByDateCreation($user, 'DESC');

        $total = count($annonces);

        return $this->render('security/user-annonces.html.twig', [
            'annonces' => $annonces,
            'user' => $user,
            'title' => 'Vos annonces',
            'total' => $total,
        ]);


    }
}
