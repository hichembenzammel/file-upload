<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConcertHallRepository;
use App\Entity\ConcertHall;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ConcertHallController extends AbstractController
{
     /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ConcertHallRepository $concertHallRepository): JsonResponse
    {
        $concertHalls = $concertHallRepository->findAll();

        return $this->json($concertHalls);
    }


    /**
     * @Route("/new", name="new", methods={"POST"})
     */
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $concertHall = new ConcertHall();
        $concertHall->setName($data['name']);
        $concertHall->setLocation($data['location']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($concertHall);
        $entityManager->flush();

        return $this->json($concertHall, 201);
    }


}
