<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 11.3.19
 * Time: 15.51
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Message;
use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{

    /**
     * @param int $id
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id)
    {
        $message = $this->_em->getRepository(Message::class)->findOneBy(['id' => $id]);
        $this->_em->remove($message);
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