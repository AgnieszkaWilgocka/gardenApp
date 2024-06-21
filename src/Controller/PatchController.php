<?php

namespace App\Controller;

use App\Entity\Patch;
use App\Form\Type\PatchType;
use App\Repository\PatchRepository;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

#[Route('/api/patch')]
class PatchController extends AbstractController
{
    public function __construct(private PatchRepository $patchRepository, private EntityManagerInterface $entityManager, private PaginatorInterface $pagination, private SerializerInterface $serializer)
    {
    }

    #[Route('/', methods:'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $paginationItems = $this->pagination->paginate(
            $this->patchRepository->queryAll(),
            $page,
            5
        )->getItems();
        
        $json = $this->serialize(['paginationItems' => $paginationItems]);

        return new Response($json, 200);
    }

    #[Route('/', methods:'POST')]
    public function post(Request $request): Response
    {
        $patch = new Patch;

        $form = $this->createForm(PatchType::class, $patch);
        $this->processForm($request, $form);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($patch);
            $this->entityManager->flush();

            $json = $this->serialize($patch);

            return new Response($json, 201);
        }

        return new Response($form->getErrors());
    }

    #[Route('/{id}', name:'put_patch', requirements:['id' => '[1-9]\d*'], methods:'PUT')]
    public function put(Patch $patch, Request $request): Response
    {
        $form = $this->createForm(PatchType::class, $patch, [
            'method' => 'PUT',
            'action' => $this->generateUrl('put_patch', ['id' => $patch->getId()])
        ]);
        $this->processForm($request, $form);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($patch);
            $this->entityManager->flush();

            $json = $this->serialize($patch);

            return new Response($json, 200);
        }

        return new Response($form->getErrors());
    }

    #[Route('/{id}', requirements:['id' => '[1-9]\d*'], methods:'DELETE')]
    public function delete(Patch $patch): Response
    {
        if(!$patch) {
            return new Response('Element not found!', 404);
        }

        $this->entityManager->remove($patch);
        $this->entityManager->flush();

        return new Response(null, 204);
        
    }

    public function serialize($data) {
        return $this->serializer->serialize($data, 'json');
    }

    public function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }
}