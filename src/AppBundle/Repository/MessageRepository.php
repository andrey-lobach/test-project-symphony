<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.3.19
 * Time: 15.51
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Message;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

class MessageRepository extends EntityRepository
{

    /**
     * @param int $id
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(int $id)
    {
        $message = $this->_em->getRepository(Message::class)->findOneBy(['id' => $id]);
        $this->_em->clear($message);
        $this->_em->flush();
    }

    /**
     * @return Message[]|array
     */
    public function getMessages()
    {
        return $this->_em->getRepository(Message::class)->findAll();
    }

    /**
     * @param Message $message
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addMessage(Message $message)
    {
        $this->_em->persist($message);
        $this->_em->flush();
    }

}