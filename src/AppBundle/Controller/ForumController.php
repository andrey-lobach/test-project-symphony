<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 7.3.19
 * Time: 14.12
 */

namespace AppBundle\Controller;


use AppBundle\Form\Type\MessageType;
use AppBundle\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends Controller
{

    private $messageRepository;

    /**
     * ForumController constructor.
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @Route("/messages", name="messages")
     * @return Response
     */
    public function listAction()
    {

//        $messages = $this->messageRepository->getMessages();
        $messages=[];
        $form = $this->createForm(MessageType::class);
        return $this->render('forum/messages.html.twig', ['messages' => $messages, 'form' => $form->createView()]);
    }

    /**
     * @Route("/messages/add", methods={"POST"})
     * @param Request $request
     * @return void
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();
            $this->messageRepository->addMessage($message);
        }
        $this->redirectToRoute('messages');
    }

    /**
     * @Route("/message/{id}/delete",requirements={"id"="\d+"})
     * @param         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete($id)
    {
        $this->messageRepository->deleteAction($id);
        return $this->redirectToRoute('messages');

    }
}