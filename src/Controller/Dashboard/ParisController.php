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

    /**
     * @Route("/paris/create", name="create-paris")
     */
    public function createParis(Request $request)
    {
        $paris = new Paris();

        $form = $this->createForm(ParisType::class, $paris);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $client = HttpClient::create();

            $client->request('POST', 'http://dataviz-api.benjaminadida.fr/api/paris/create', [
                'json' => [
                    'borough' => $form->get('district')->getData(),
                    'district' => $form->get('borough')->getData(),
                    'count_hotel' => $form->get('count_hotel')->getData(),
                    'latitude' => $form->get('latitude')->getData(),
                    'longitude' => $form->get('longitude')->getData()
                ],
                'auth_bearer' => $this->getApiToken(),
            ]);

            $this->addFlash('success', 'Un nouvel item à été ajouté');
            return $this->redirectToRoute('index-paris');
        }
        return $this->render('paris/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}