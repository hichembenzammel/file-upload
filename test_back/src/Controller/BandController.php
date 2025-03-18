<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Band;
use App\Entity\ConcertHall;
use Psr\Log\LoggerInterface;
use App\Repository\BandRepository;
use App\Repository\ConcertHallRepository;


class BandController extends AbstractController
{
    private $entityManager;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * @Route("/upload", name="upload_band_data", methods={"POST"})
     */
    public function upload(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!$data || !isset($data['bands'])) {
                return new JsonResponse(['status' => 'error', 'message' => 'Invalid data format'], 400);
            }

            $bands = $data['bands'];
            $bandEntities = [];

            foreach ($bands as $bandData) {
                if (!isset($bandData['name'], $bandData['origin'], $bandData['year'])) {
                    $this->logger->error('Missing required fields in band data');
                    return new JsonResponse(['status' => 'error', 'message' => 'Missing required fields'], 400);
                }
                $band = new Band();
                $band->setName($bandData['name']);
                $band->setOrigin($bandData['origin']);
                $band->setYear($bandData['year']);
                $band->setVille($bandData['ville']);
                $band->setSeparation($bandData['separation'] ?? 0);
                $band->setFondateur($bandData['fondateur'] ?? '');
                $band->setMembre($bandData['membre'] ?? '');
                $band->setMusic($bandData['music'] ?? null);
                $band->setPresentation($bandData['presentation'] ?? null);

                $bandEntities[] = $band;
            }

            foreach ($bandEntities as $bandEntity) {
                $this->entityManager->persist($bandEntity);
            }

            $this->entityManager->flush();

            return new JsonResponse(['status' => 'success', 'message' => 'Bands data saved successfully']);
        } catch (\Exception $e) {
            $this->logger->error('Error saving bands: ' . $e->getMessage());
            return new JsonResponse(['status' => 'error', 'message' => 'Error saving band'], 500);
        }
    }


    /**
     * @Route("/", name="getbands", methods={"GET"})
     */
    public function bansd(BandRepository $bandRepository): JsonResponse
    {
        $bands = $this->getDoctrine()->getRepository(Band::class)->findAll(); 

        if (!$bands) {
            return $this->json(['message' => 'No bands found'], Response::HTTP_NOT_FOUND);
        }

        $data = [];
        foreach ($bands as $band) {
            $data[] = [
                'id' => $band->getId(),
                'name' => $band->getName(),
                'origin' => $band->getOrigin(),
                'ville' => $band->getVille(),
                'year' => $band->getYear(),
                'separation' => $band->getSeparation(),
                'fondateur' => $band->getFondateur(),
                'membre' => $band->getMembre(),
                'music' => $band->getMusic(),
                'presentation' => $band->getPresentation()
            ];
        }

        return $this->json($data);
    }
    /**
     * @Route("/assign-concerthall/{bandId}/{concertHallId}", name="assign_concerthall", methods={"PUT"})
     */
    public function assignConcertHall(Request $request, $bandId, $concertHallId, ConcertHallRepository $concertHallRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $band = $this->getDoctrine()->getRepository(Band::class)->find($bandId);
        // $concertHall = $this->getDoctrine()->getRepository(ConcertHall::class)->find($concertHallId);

        $concertHall = $concertHallRepository->find($concertHallId);

        if (!$band || !$concertHall) {
            return $this->json(['error' => 'Band or Concert Hall not found'], 404);
        }

        $band->addConcertHall($concertHall);

        $this->getDoctrine()->getManager()->flush();

        return $this->json(['success' => 'Concert Hall assigned to Band']);
    }
}