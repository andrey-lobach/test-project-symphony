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
        $messages = $this->messageRepository->findAll();
        $form = $this->createForm(MessageType::class);
        return $this->render('forum/messages.html.twig', ['messages' => $messages, 'form' => $form->createView()]);
    }

    /**
     * @Route("/messages/add", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Request $request)
    {
        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->messageRepository->addMessage($form->getData());
        }
        return $this->redirectToRoute('messages');
    }

    /**
     * @Route("/messages/{id}/delete",requirements={"id"="\d+"})
     * @param         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id)
    {
        $this->messageRepository->delete($id);
        return $this->redirectToRoute('messages');

    }
}