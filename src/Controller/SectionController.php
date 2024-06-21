<?php

namespace App\Controller;

use App\Entity\Section;
use App\Entity\Species;
use App\Form\Type\SectionType;
use App\Form\Type\SpeciesType;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    public function __construct(private SectionRepository $sectionRepository, private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
    }

    #[Route("/api_section", methods:'POST')]
    public function post(Request $request): Response
    {
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);

        $this->processForm($request, $form);
        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($section);
            $this->entityManager->flush();

            $json = $this->serialize($section);

            return new Response($json, 201);
        }

        return new Response($form->getErrors());
    }

        //******************* */ ilosc kwadratow **********************//
        // $amountPatch = $this->sectionRepository->totalPatchAmount($section);
        // return new Response($amountPatch);

    public function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }

    public function serialize($data)
    {
        return $this->serializer->serialize($data, 'json');
    }

}