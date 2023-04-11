<?php

namespace App\Repository;

use App\Entity\Favourite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Favourite>
 *
 * @method Favourite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favourite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favourite[]    findAll()
 * @method Favourite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favourite::class);
    }

    public function save(Favourite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Favourite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function removeFromFavourite(EntityManagerInterface $entityManager, $id)
    {
        $fruitId = $entityManager->getRepository(Favourite::class)->findOneBy(['fruit_id'=>$id]);
        $entityManager->remove($fruitId);
        $entityManager->flush();
    }

    public function addInFavourite(EntityManagerInterface $entityManager, $id)
    {
        $favourite = new Favourite();
        $favourite->setUserId(1);
        $favourite->setFruitId($id);
        $entityManager->persist($favourite);
        $entityManager->flush();
    }
}
