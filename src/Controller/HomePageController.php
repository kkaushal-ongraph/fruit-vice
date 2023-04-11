<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\{Favourite, Fruits, Nutritions};
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\FavouriteRepository;

class HomePageController extends AbstractController
{
    /**
     * route to home page 
     * @author Kkaushal
     * @param $entityManager | Instance of EntityManagerInterface
     * @param $req | Instance of Request
     * @param $paginator | Instance of PaginatorInterface
     * @return render(home_page/index.html.twig) 
     */ 
    #[Route('/fruits', name: 'fruits')]
    public function homePage(EntityManagerInterface $entityManager,Request $req, PaginatorInterface $paginator): Response
    {
        $fruits = $entityManager->getRepository(Fruits::class)->findAll();
        $pagination = $paginator->paginate(
            $fruits,
            $req->query->getInt('page',1),
            10  
        );
        $favourite = $entityManager->getRepository(Favourite::class)->findAll();
        $favList = [];
        foreach ($favourite as $value) {
            $favList[$value->getFruitId()] = $value;
        }

        return $this->render('home_page/index.html.twig', [
            'items' =>  $fruits,
            'values' => '',
            'favourite' => array_keys((array)$favList),
            'pagination' => $pagination
        ]);
    }

    /**
     * route to add favourite fruits list
     * @author Kkaushal
     * @param Int | $req  Instance of Request
     * @param $entityManager | Instance of EntityManagerInterface
     * @return String | response 
     */ 
    #[Route('/addFavourite', name: 'addFavourite')]
    public function addFavourite(Request $req, EntityManagerInterface $entityManager,FavouriteRepository $favRepo): Response
    {
        $fruitId = $req->get('fruitId');
        $findFruit = $entityManager->getRepository(Favourite::class)->findBy(['fruit_id'=>$fruitId]);

        if (empty($findFruit)) {
            $favRepo->addInFavourite($entityManager, $fruitId);
            return new Response("ADDED");
        } else {
            $favRepo->removeFromFavourite($entityManager, $fruitId);
            return new Response("REMOVED");
        }
    }

    /**
     * route for filter fruit details by name and family
     * @author Kkaushal
     * @param $req | Instance of Request 
     * @param $entityManager | Instance of EntityManagerInterface
     * @return render(home_page/listing.html.twig) 
     */ 
    #[Route('/listing', name: 'listing')]
    public function listing(Request $req, EntityManagerInterface $entityManager)
    {
        $searchKey = $req->get('findValue');
        // first value find in fruit_name column if not found then find in fruit_family.
        $fruits = $entityManager->getRepository(Fruits::class)->findBy(['fruit_name'=>$searchKey]);
        if(!$fruits){
            $fruits = $entityManager->getRepository(Fruits::class)->findBy(['fruit_family'=>$searchKey]);
        }
        $favourite = $entityManager->getRepository(Favourite::class)->findAll();
        $favList = [];
        foreach ($favourite as $value) {
            $favList[$value->getFruitId()] = $value;
        }
        return $this->render('home_page/listing.html.twig', [
            'items' =>  $fruits,
            'values' => '',
            'favourite' => array_keys((array)$favList)
        ]);
        
    }
    /**
     * route for showing favourite fruits in table
     * @author Kkaushal
     * @param $entityManager | Instance of EntityManagerInterface
     * @return render(home_page/favourite.html.twig) 
     */ 
    #[Route('/favourite', name: 'favourite')]
    public function favouriteTabel(EntityManagerInterface $entityManager): Response
    {
        $favouriteFruits = $entityManager->getRepository(Favourite::class)->findAll();
        $nutritions = $entityManager->getRepository(Nutritions::class)->findAll();
        $totalNutritions = array();
        foreach($favouriteFruits as $fruit){
            $total = 0;
            $nutritions = $entityManager->getRepository(Nutritions::class)->findOneBy(['fruit_id'=>$fruit->getFruitId()]);
            if($nutritions){
               $total += $nutritions->getFruitCarbohydrates() + $nutritions->getFruitProtein() + $nutritions->getFruitFat() +$nutritions->getFruitCalories() + $nutritions->getFruitSugar();
               $tempArr = array(
                'fruit_id' => $nutritions->getFruitId(),
                'total_nutritions' => $total
               );
               array_push($totalNutritions , $tempArr);
            }
        }
        return $this->render('home_page/favourite.html.twig', [
            'items' =>  $favouriteFruits,
            'nutritions' => $totalNutritions
        ]);
    }
}
