<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\{Favourite, Fruits, Nutritions};

/**
 * @extends ServiceEntityRepository<Fruits>
 *
 * @method Fruits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruits[]    findAll()
 * @method Fruits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruits::class);
    }

    public function save(Fruits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fruits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function insertFruit(EntityManagerInterface $entityManager, $value)
    {
        // insert data in fruit table
        $fruit = new Fruits();
        $fruit->setFruitGenus($value->genus);
        $fruit->setFruitName($value->name);
        $fruit->setFruitFamily($value->family);
        $fruit->setFruitId(intval($value->id));
        $fruit->setFruitOrder($value->order);
        $entityManager->persist($fruit);
        $entityManager->flush();

        // insert data in nutritions table
        $fruitId = $value->id; // create forign key in another table.
        $nutritions = new Nutritions();
        $nutritions->setFruitId($fruitId);
        $nutritions->setFruitCarbohydrates($value->nutritions->carbohydrates);
        $nutritions->setFruitProtein($value->nutritions->protein);
        $nutritions->setFruitFat($value->nutritions->fat);
        $nutritions->setFruitCalories($value->nutritions->calories);
        $nutritions->setFruitSugar($value->nutritions->sugar);
        $entityManager->persist($nutritions);
        $entityManager->flush();
    }
}
