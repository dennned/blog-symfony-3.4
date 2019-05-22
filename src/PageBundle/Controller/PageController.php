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

    /**
     * @param int $id
     * @return Response
     */
    public function viewAction(int $id)
    {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $page = $pageRepo->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Page is not found!');
        }

        return $this->render('@Page/Page/view.html.twig', [
            'page' => $page
        ]);
    }

}