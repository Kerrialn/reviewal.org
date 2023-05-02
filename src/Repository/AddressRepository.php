<?php

namespace App\Repository;

use App\DataTransferObject\AddressFilterDto;
use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Address>
 *
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function save(Address $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Address $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByFilter(AddressFilterDto $addressFilterDto, bool $isQuery = false) : mixed
    {
        $qb = $this->createQueryBuilder('address');

        $qb->innerJoin('address.reviews', 'review');

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

        if($isQuery){
            return $qb->getQuery();
        }

        return $qb->getQuery()->getResult();
    }
}
