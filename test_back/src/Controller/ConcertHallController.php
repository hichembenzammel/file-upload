<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ConcertHallRepository;
use App\Entity\ConcertHall;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ConcertHallController extends AbstractController
{

    private $concertHallRepository;

    public function __construct(ConcertHallRepository $concertHallRepository)
    {
        $this->concertHallRepository = $concertHallRepository;
    }

     /**
     * @Route("/concerts", name="index", methods={"GET"})
     */
    public function getConcerts(ConcertHallRepository $concertHallRepository): JsonResponse
    {
        $concertHalls = $this->getDoctrine()->getRepository(ConcertHall::class)->findAll();  

        if (!$concertHalls) {
            return $this->json(['message' => 'No bands found'], Response::HTTP_NOT_FOUND);
        }

        $data = [];
        foreach ($concertHalls as $concertHall) {
            $data[] = [
                'id' => $concertHall->getId(),
                'name' => $concertHall->getName(),
                'location' => $concertHall->getLocation(),
                'date' => $concertHall->getDate(),
                
            ];
        }

        return $this->json($data);
    }


    /**
 * @Route("/concert-halls/update/{id}", name="concert_hall_update", methods={"PUT"})
 */
    public function update(int $id, Request $request): Response
    {
        $concertHall = $this->concertHallRepository->find($id);

        if (!$concertHall) {
            throw $this->createNotFoundException('Concert Hall not found.');
        }

        $data = json_decode($request->getContent(), true);
        
        if (isset($data['name'])) {
            $concertHall->setName($data['name']);
        }

        if (isset($data['location'])) {
            $concertHall->setLocation($data['location']);
        }

        if (isset($data['date'])) {
            $concertHall->setDate($data['date']);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new Response('Concert Hall updated successfully.');
    }
   



    /**
     * @Route("/new", name="new", methods={"POST"})
     */
    public function newConcert(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $concertHall = new ConcertHall();
        $concertHall->setName($data['name']);
        $concertHall->setLocation($data['location']);
        $concertHall->setDate($data['date']);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($concertHall);
        $entityManager->flush();

        return $this->json($concertHall, 201);
    }


    

     /**
     * @Route("/concert-halls/{id}", name="concert_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $concertHall = $this->concertHallRepository->find($id);

        if (!$concertHall) {
            throw $this->createNotFoundException('No concert hall found for id ' . $id);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($concertHall);
        $entityManager->flush();

        return $this->json(['Concert Hall deleted successfully']);
    }


}
