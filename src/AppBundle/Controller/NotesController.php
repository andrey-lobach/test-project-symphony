<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 7.3.19
 * Time: 14.12
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotesController extends Controller
{
    /**
     * @Route("/notes")
     */

    public function showNotes()
    {
        $str = 'Hello world';
        return $this->render('notes.html.twig', ['str' => $str]);
    }

}