<?php

namespace App\Controller;

use App\Entity\User;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

	/**
	 * @Route("/", name="app_login")
	 */
	public function login(AuthenticationUtils $authenticationUtils): Response
	{

		$user_data = $this->getDoctrine()->getRepository(User::class);
		$data = $user_data->showAllUsers();

		if (!$data) {
			return $this->redirectToRoute('app_index');
		}

		if ($this->getUser()) {
			return $this->redirectToRoute('app_home');
		}

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
	}

	/**
	 * @Route("/logout", name="app_logout")
	 */
	public function logout()
	{
		throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
	}
}
