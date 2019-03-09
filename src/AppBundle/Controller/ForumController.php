<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 7.3.19
 * Time: 14.12
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends Controller
{
    /**
     * @Route("/forum", name="forum")
     * @param Request $request
     *
     * @return Response
     */
    public function showNotes(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Message::class);
        $messages = $repository->findAll();
        $message = new Message();
        $form = $this->createFormBuilder($message)
            ->add('author', TextType::class)
            ->add('message', TextType::class)
            ->add('send', SubmitType::class, ['label' => 'Send'])
            ->getForm();
        if ($request->getMethod() === Request::METHOD_POST) {
            $entityManager = $this->getDoctrine()->getManager();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $message = $form->getData();
                $entityManager->persist($message);
                $entityManager->flush();
                return $this->redirectToRoute('forum');
            }
        }

        return $this->render('forum/messages.html.twig', ['messages' => $messages, 'form'=>$form->createView()]);
    }

    /**
     * @Route("/forum/{id}/delete",requirements={"id"="\d+"})
     * @param         $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
            ->getRepository(Message::class);
        $message = $repository->findOneBy(['id'=>$id]);
        $entityManager->remove($message);
        $entityManager->flush();

        return $this->redirectToRoute('forum');

    }
}