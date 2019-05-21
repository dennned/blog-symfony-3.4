<?php
namespace PageBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function listAction()
    {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $pages = $pageRepo->findAll();

        return $this->render('@Page/Page/list.html.twig', [
            'pages' => $pages
        ]);
    }

    public function viewAction(int $id)
    {
        return new Response("viewAction");
    }

}