<?php
namespace PageBundle\Controller;

use PageBundle\Entity\Page;
use PageBundle\Forms\PageDeleteForm;
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('page_list');
        }

        return $this->render('@Page/Page/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Page::class);
        $page = $repo->find($id);

        if (!$page) {
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(PageForm::class, $page);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('page_view', [
                'id' => $page->getId()
            ]);
        }

        return $this->render('@Page/Page/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function removeAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Page::class);
        $page = $repo->find($id);

        if (!$page) {
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(PageDeleteForm::class, $page);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $em->remove($page);
            $em->flush();

            return $this->redirectToRoute('page_list');
        }

        return $this->render('@Page/Page/delete.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
