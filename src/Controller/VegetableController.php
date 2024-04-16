<?php

namespace App\Controller;

use App\Entity\Vegetable;
use App\Form\Type\VegetableType;
use App\Repository\VegetableRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VegetableController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer)
    {
    }


    #[Route('/api/vegetables', name:'api_index_vegetables')]
    public function index(VegetableRepository $vegetableRepository): Response
    {
        $vegetables = $vegetableRepository->findAll();

        $json = $this->serializeVegetable(['vegetables' => $vegetables]);

        return new Response($json, 200);
    }


    #[Route('/api/createVegetable', methods:'POST')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vegetable = new Vegetable();
        $form = $this->createForm(VegetableType::class, $vegetable);
        $this->processForm($request, $form);


        if($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($vegetable);
        $entityManager->flush();

        $json = $this->serializeVegetable($vegetable);
        $response = new Response($json, 201);
        $response->headers->set('Location', $this->generateUrl('api_index_vegetables'));

        return $response;
        }

        return new Response($form->getErrors()); 
    }


    /**
     * Serialize object to json format
     */
    private function serializeVegetable($data) {
        return $this->serializer->serialize($data, 'json');
    }

    /**
     * Deserializing json request
     */
    private function processForm(Request $request, FormInterface $form) {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }
}