<?php

namespace App\Controller;

use App\Entity\Vegetable;
use App\Form\Type\VegetableType;
use App\Repository\VegetableRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VegetableController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer, private VegetableRepository $vegetableRepository)
    {
    }


    #[Route('/api/vegetables', name:'api_index_vegetables')]
    public function index(Request $request, VegetableRepository $vegetableRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $this->vegetableRepository->queryForAll(),
            $request->query->getInt('page', 1),
            5
        );

        $json = $this->serializeVegetable(['pagination' => $pagination]);

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

    #[Route('/api/putVegetable/{id}', requirements:['id' => '[1-9]\d*'], methods:'GET|PUT', name:'vegetable_edit')]
    public function putVegetable(Request $request, Vegetable $vegetable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VegetableType::class, $vegetable, 
        [
            'method' => 'PUT',
            'action' => $this->generateUrl('vegetable_edit', ['id' => $vegetable->getId()]),
        ]);
        $this->processForm($request, $form);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vegetable);
            $entityManager->flush();
            $json = $this->serializeVegetable($vegetable);
            $response = new Response($json, 200);
            return $response;
        }

        return new Response($form->getErrors());
    }

    #[Route('/api/deleteVegetable/{id}', methods:'GET|DELETE', name:'delete_vegetable')]
    public function deleteVegetable(Request $request, Vegetable $vegetable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormType::class, $vegetable,
    [
        'method' => 'DELETE',
        'action' => $this->generateUrl('delete_vegetable', ['id' => $vegetable->getId()]),
        'csrf_protection' => false
    ]);
        $this->processForm($request, $form);


        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($vegetable);
            $entityManager->flush();

            return new Response(null, 204);
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