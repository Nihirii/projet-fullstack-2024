<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RestaurantController extends AbstractController
{
    #[Route('/restaurant', name: 'app_restaurant')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RestaurantController.php',
        ]);
    }

    #[Route('/api/restaurants', name: 'restaurant.getAll', methods: ["GET"])]
    public function getAllRestaurants(RestaurantRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $restaurants = $repository->findAll();
        $jsonRestaurants = $serializer->serialize($restaurants, 'json');
        return new JsonResponse($jsonRestaurants, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/api/restaurants/{idRestaurant}', name: 'restaurant.get', methods: ["GET"])]
    public function getRestaurant(int $idRestaurant, RestaurantRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $restaurant = $repository->find($idRestaurant);
        $jsonRestaurant = $serializer->serialize($restaurant, 'json');
        return new JsonResponse($jsonRestaurant, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/api/restaurants/', name: 'restaurant.create', methods: ["POST"])]
    public function createRestaurant(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrGeneratorInterface $urlGenerator){
        $restaurant = $serializer->deserialize($request->getContent(), Restaurant::class, 'json');
        $restaurant->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setStatus("on");
        $entityManager->persist($restaurant);
        $entityManager->flush();

        $jsonRestaurant = $serializer->serialize($restaurant, "json");
        $location = $urlGenerator->generate("song.get", ["song" => $restaurant->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonRestaurant, JsonResponse::HTTP_CREATED, ["Location" => $location], true);
    }
}
