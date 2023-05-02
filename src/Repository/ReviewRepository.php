<?php

namespace App\Repository;

use App\DataTransferObject\AddressFilterDto;
use App\Entity\Address;
use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function save(Review $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Review $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByFilter(AddressFilterDto $addressFilterDto, bool $isQuery = false) : mixed
    {
        $qb = $this->createQueryBuilder('review');

        $qb->innerJoin('review.address', 'address');

        if($addressFilterDto->getNameOrNumber())
        {
            $qb->andWhere(
                $qb->expr()->like('address.nameOrNumber', ':nameOrNumber')
            )->setParameter('nameOrNumber', '%'.$addressFilterDto->getNameOrNumber().'%');
        }

        if($addressFilterDto->getFloor())
        {
            $qb->andWhere(
                $qb->expr()->eq('address.floor', ':floor')
            )->setParameter('floor', $addressFilterDto->getFloor());
        }

        if($addressFilterDto->getPostcode())
        {
            $qb->andWhere(
                $qb->expr()->eq('address.postcode', ':postcode')
            )->setParameter('postcode', $addressFilterDto->getPostcode());
        }

        if($addressFilterDto->getLineOne())
        {
            $qb->andWhere(
                $qb->expr()->like('address.lineOne', ':lineOne')
            )->setParameter('lineOne', $addressFilterDto->getLineOne());
        }

        if($addressFilterDto->getLineTwo())
        {
            $qb->andWhere(
                $qb->expr()->like('address.lineTwo', ':lineTwo')
            )->setParameter('lineTwo', $addressFilterDto->getLineTwo());
        }

        if($addressFilterDto->getCity())
        {
            $qb->andWhere(
                $qb->expr()->eq('address.city', ':city')
            )->setParameter('city', $addressFilterDto->getCity());
        }

        if($addressFilterDto->getCounty())
        {
            $qb->andWhere(
                $qb->expr()->eq('address.county', ':county')
            )->setParameter('county', $addressFilterDto->getCounty());
        }

        if($addressFilterDto->getCountry())
        {
            $qb->andWhere(
                $qb->expr()->eq('address.country', ':country')
            )->setParameter('country', $addressFilterDto->getCountry());
        }

        $qb->groupBy('review.address, review.id, review.createdAt');

        if($isQuery){
            return $qb->getQuery();
        }

        return $qb->getQuery()->getResult();
    }


    public function getAveragesByAddress(Address $address) : mixed
    {
        $qb = $this->createQueryBuilder('review');

        $qb->select('AVG(review.generalRating) AS generalRatingAverage')
            ->addSelect('AVG(review.buildingRating) AS buildingRatingAverage')
            ->addSelect('AVG(review.priceRating) AS priceRatingAverage')
            ->addSelect('AVG(review.managementRating) AS managementRatingAverage')
            ->addSelect('AVG(review.locationRating) AS locationRatingAverage')
            ->addSelect('AVG(review.transportRating) AS transportRatingAverage')
            ->addSelect('COUNT(review.id) AS reviewCount')
            ->groupBy('review.address');

        $qb->andWhere(
            $qb->expr()->eq('review.address', ':address')
        )->setParameter('address', $address->getId(), 'uuid');

        return array_merge(...$qb->getQuery()->getResult());
    }
}
