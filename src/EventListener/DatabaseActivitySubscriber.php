<?php

namespace App\EventListener;

use App\Entity\Users;
use App\Entity\UsersActivities;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class DatabaseActivitySubscriber implements EventSubscriber
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(Security $security, EntityManagerInterface $manager)
    {
        $this->security = $security;
        $this->manager = $manager;
    }
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->logActivity('créé', $args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->logActivity('supprimé', $args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->logActivity('modifié', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if($entity instanceof UsersActivities){
            return;
        }

        /** @var Users $user */
        $user=$this->security->getUser();

        $userActivity= new UsersActivities();
        $userActivity->setAction($action);
        $userActivity->setObject(get_class($entity));
        if (method_exists($entity, 'getId')) {
            $userActivity->setObjectID($entity->getId());
        }
        $userActivity->setUser($user);
        $userActivity->setDate(new \Datetime());

        $entitySplit=explode("\\",get_class($entity));
        $class=end($entitySplit);

        $userActivity->setInfo($user->getEmail().' a '.$action.' un(e) '.$class);
        $this->manager->persist($userActivity);
        $this->manager->flush();
    }
}