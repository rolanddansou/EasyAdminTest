<?php

namespace App\Repository;

use App\Entity\UsersActivities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UsersActivities|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersActivities|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersActivities[]    findAll()
 * @method UsersActivities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersActivitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersActivities::class);
    }
    
	private $count;
	
	public function getCount(){
		return $this->count ?: 0;
	}
	
	public function getAll($limit = 0, $offset = 0, $userID = null, $keywords = null, $beginDate = null, $endDate = null){			
		$qb = $this->createQueryBuilder('ua')
            ->join('ua.user','u')
			->orderBy('ua.date','DESC');
		
		if($userID !== null) $qb->andWhere('u.id = '.$userID);
		
		if($keywords)
			$qb->andWhere('(u.lName like :k or u.fName like :k or ua.object like :k or ua.action like :k or ua.info like :k)')
				-> setParameter('k','%'.$keywords.'%');
				
		if($beginDate && $beginDate instanceof \DateTime) $qb->andWhere("ua.date >= '".$date->format('Y-m-d H:i:s')."'");
				
		if($endDate && $endDate instanceof \DateTime) $qb->andWhere("ua.date <= '".$date->format('Y-m-d H:i:s')."'");
		
		$this->count = $qb->select('count(distinct(ua.id))')->getQuery()->getResult()[0][1];
		
		if($limit) $qb->setMaxResults($limit);
		
		if($offset) $qb->setFirstResult($offset);

        $qb = $qb->select('ua')->addSelect('u');
				
		return $qb = $qb->getQuery()->getResult();
	}
}
