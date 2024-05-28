<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/api/restaurants', name: 'restaurant.getAll')]
    public function getAllRestaurants(RestaurantRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $restaurants = $repository->findAll();
        $jsonRestaurants = $serializer->serialize($restaurants, 'json');
        return new JsonResponse($jsonRestaurants, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/api/restaurant/{idRestaurant}', name: 'restaurant.get')]
    public function getRestaurant(int $idRestaurant, RestaurantRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $restaurants = $repository->find($idRestaurant);
        $jsonRestaurants = $serializer->serialize($restaurants, 'json');
        return new JsonResponse($jsonRestaurants, JsonResponse::HTTP_OK, [], true);
    }
}
