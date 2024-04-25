<?php

namespace App\Controller;

use App\Entity\Vegetable;
use App\Form\Type\VegetableType;
use App\Repository\VegetableRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/vegetable')]
class VegetableController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer, private VegetableRepository $vegetableRepository, private EntityManagerInterface $entityManager)
    {
    }


    #[Route('/', name:'api_vegetables')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $this->vegetableRepository->queryForAll(),
            $request->query->getInt('page', 1),
            5
        );

        $json = $this->serializeVegetable(['pagination' => $pagination]);

        return new Response($json, 200);
    }


    #[Route('/post', methods:'POST')]
    public function create(Request $request): Response
    {
        $vegetable = new Vegetable();
        $form = $this->createForm(VegetableType::class, $vegetable);
        $this->processForm($request, $form);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($vegetable);
            $this->entityManager->flush();

            $json = $this->serializeVegetable($vegetable);
            $response = new Response($json, 201);
            $response->headers->set('Location', $this->generateUrl('api_vegetables'));

            return $response;
        }

        return new Response($form->getErrors()); 
    }

    #[Route('/put/{id}', name:'vegetable_edit', requirements:['id' => '[1-9]\d*'], methods:'PUT')]
    public function putVegetable(Request $request, Vegetable $vegetable): Response
    {
        $form = $this->createForm(VegetableType::class, $vegetable,
        [
            'method' => 'PUT',
            'action' => $this->generateUrl('vegetable_edit', ['id' => $vegetable->getId()]),
        ]);
        $this->processForm($request, $form);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($vegetable);
            $this->entityManager->flush();

            $json = $this->serializeVegetable($vegetable);
            $response = new Response($json, 200);
            return $response;
        }

        return new Response($form->getErrors());
    }

    #[Route('/delete/{id}', requirements: ["id" => '[1-9]\d*'], methods:'DELETE')]
    public function deleteVegetable(Vegetable $vegetable): Response
    {
        $this->entityManager->remove($vegetable);
        $this->entityManager->flush();
        
        return new Response(null, 204);
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