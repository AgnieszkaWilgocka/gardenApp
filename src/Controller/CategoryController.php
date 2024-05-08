<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\VegetableRepository;
use JMS\Serializer\SerializerInterface;
use App\Dto\CategoryListInputFiltersDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Resolver\CategoryListInputFiltersDtoResolver;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

#[Route('api/category')]
class CategoryController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository, private VegetableRepository $vegetableRepository, private EntityManagerInterface $entityMenager, private PaginatorInterface $paginator, private SerializerInterface $serializer)
    {}

    #[Route('/', name:'app_index_category', methods:'GET')]
    public function index(#[MapQueryString(resolver: CategoryListInputFiltersDtoResolver::class)] CategoryListInputFiltersDto $filters, #[MapQueryParameter] $page = 1): Response
    {
        $filters = $this->categoryRepository->prepareFilters($filters);

        $paginationItems = $this->paginator->paginate(
            $this->categoryRepository->queryAll($filters),
            $page,
            5
        )->getItems();
        $json = $this->serializeCategory(['paginationItems' => $paginationItems]);

        return new Response($json, 200);
    }

    #[Route('/', methods:'POST')]
    public function postCategory(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $this->processForm($request, $form);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityMenager->persist($category);
            $this->entityMenager->flush();

            $json = $this->serializeCategory($category);
            return new Response($json, 201);
        }

        return new Response($form->getErrors());
    }

    #[Route('/{id}', name:'category_put', requirements:['id' => '[1-9]\d*'], methods:'PUT')]
    public function putCategory(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category,
        [
            'method' => 'PUT',
            'action' => $this->generateUrl('category_put', ['id' => $category->getId()])
        ]);
        
        $this->processForm($request, $form);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityMenager->persist($category);
            $this->entityMenager->flush();

            $json = $this->serializeCategory($category);

            return new Response($json, 200);
        }

        return new Response($form->getErrors());
    }

    #[Route('/{id}', requirements:['id' => '[1-9]\d*'], methods:'DELETE')]
    public function deleteCategory(Category $category): Response
    {
        if($this->vegetableRepository->canDelete($category)) {
            
            $this->entityMenager->remove($category);
            $this->entityMenager->flush();

            return new Response(null, 204);
        } else {
            throw new HttpException(409, 'Category contains vegetables!');
        }
    }

    public function serializeCategory($data)
    {
        return $this->serializer->serialize($data, 'json');
    }

    public function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }
}