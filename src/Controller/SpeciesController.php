<?php

namespace App\Controller;

use App\Entity\Species;
use App\Form\Type\SpeciesType;
use App\Repository\SpeciesRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/species')]
class SpeciesController extends AbstractController
{

    public function __construct(private SpeciesRepository $speciesRepository, private EntityManagerInterface $entityManager, private SerializerInterface $serializer, private PaginatorInterface $paginator)
    {
    }

    #[Route('/', name:'api_species', methods:'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $paginationItems = $this->paginator->paginate(
            $this->speciesRepository->queryAll(),
            $page,
            5
        )->getItems();

        $json = $this->serialize(['paginationItems' => $paginationItems]);

        return new Response($json, 200);
    }

    #[Route('/', methods:'POST')]
    public function postSpecies(Request $request): Response
    {
        $species = new Species();

        $form = $this->createForm(SpeciesType::class, $species);
        $this->processForm($request, $form);
        // $species->getCategory()->getVegetables();

        if($form->isValid() && $form->isSubmitted()) {
            $this->entityManager->persist($species);
            $this->entityManager->flush();

            $json = $this->serialize($species);

            $response = new Response($json, 201);
            // $response->headers->set('Location', $this->generateUrl('api_species'));

            return $response;
        } else {
            return new Response("", 400);
        }

        

        return new Response($form->getErrors());
    }

    #[Route('/{id}', name:'api_put_species', requirements:['id' => '[1-9]\d*'], methods:'PUT')]
    public function put(Request $request, Species $species): Response
    {
        $form = $this->createForm(SpeciesType::class, $species,
        [
            'method' => 'PUT',
            'action' => $this->generateUrl('api_put_species', ['id' => $species->getId()])
        ]
    );
        $this->processForm($request, $form);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($species);
            $this->entityManager->flush();

            $json = $this->serialize($species);

            return new Response($json, 200);
        }

        return new Response($form->getErrors());
    }

    #[Route('/{id}', requirements:['id' => '[1-9]\d*'], methods:'DELETE')]
    public function delete(Species $species): Response
    {
        $this->entityManager->remove($species);
        $this->entityManager->flush();

        return new Response(null, 204);
    }

    private function serialize($data)
    {
        return $this->serializer->serialize($data, 'json');
    }

    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }
}