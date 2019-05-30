<?php
namespace PageBundle\Controller;

use PageBundle\Entity\Page;
use PageBundle\Forms\PageForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function addAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(PageForm::class, $page);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            dump($page->getCategory());
            die;
        }

        return $this->render('@Page/Page/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
