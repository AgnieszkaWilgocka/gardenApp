<?php

namespace App\Controller;

use App\Dto\VegetableListInputFiltersDto;
use App\Entity\Vegetable;
use App\Form\Type\VegetableType;
use App\Repository\CategoryRepository;
use App\Repository\VegetableRepository;
use App\Resolver\VegetableListInputFiltersDtoResolver;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/vegetable')]
class VegetableController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer, private VegetableRepository $vegetableRepository, private EntityManagerInterface $entityManager)
    {
    }


    #[Route('/', name:'api_vegetables', methods:'GET')]
    public function index(#[MapQueryString(resolver: VegetableListInputFiltersDtoResolver::class)] VegetableListInputFiltersDto $filters, PaginatorInterface $paginator, #[MapQueryParameter] int $page = 1): Response
    {
        $filters = $this->vegetableRepository->prepareFilters($filters);
        $paginationItems = $paginator->paginate(
            $this->vegetableRepository->queryForAll($filters),
            $page,
            5
        )->getItems();

        $json = $this->serializeVegetable(['paginationItems' => $paginationItems]);

        return new Response($json, 200);
    }


    #[Route('/', methods:'POST')]
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
            // $response->headers->set('Location', $this->generateUrl('api_vegetables'));

            return $response;
        }

        return new Response($form->getErrors()); 
    }

    #[Route('/{id}', name:'vegetable_edit', requirements:['id' => '[1-9]\d*'], methods:'PUT')]
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

    #[Route('/{id}', requirements: ["id" => '[1-9]\d*'], methods:'DELETE')]
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