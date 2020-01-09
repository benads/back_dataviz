<?php


namespace App\Controller\Dashboard;

use App\Entity\Paris;
use App\Form\ParisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;


class ParisController extends AbstractController
{

    public function getApiToken()
    {
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://dataviz-api.benjaminadida.fr/api/login', [
            'json' => [
                'username' => $_SERVER['USERNAME_API'],
                'password' => $_SERVER['PASSWORD_API']
            ]
        ]);
        $token = $response->toArray()['token'];
        return $token;
    }


    /**
     * @Route("/paris", name="index-paris")
     */
    public function indexParis()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://dataviz-api.benjaminadida.fr/api/paris', [
            'auth_bearer' => $this->getApiToken(),
        ]);
        $paris = $response->toArray();
        return $this->render('paris/index.html.twig', compact('paris'));
    }

    /**
     * @Route("/paris/{id}/delete", name="delete-paris")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function deleteParis($id, Request $request)
    {
        $client = HttpClient::create();

        $response = $client->request('DELETE', 'http://dataviz-api.benjaminadida.fr/api/paris/'.$id.'/delete', [
            'auth_bearer' => $this->getApiToken(),
        ]);

        return $this->redirectToRoute('index-paris');
    }
}