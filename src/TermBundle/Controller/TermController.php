<?php

namespace TermBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TermBundle\Entity\Term;
use TermBundle\Forms\PageForm;
use TermBundle\Forms\TermDeleteForm;
use TermBundle\Forms\TermForm;

class TermController extends Controller
{
    /**
     * @return Response
     */
    public function listAction()
    {
        $terms = $this->getDoctrine()->getRepository(Term::class)->findAll();

        return $this->render('@Term/Term/list.html.twig', [
            'terms' => $terms
        ]);

    }

    /**
     * @param int $id
     * @return Response
     */
    public function viewAction(int $id)
    {
        $repo = $this->getDoctrine()->getRepository(Term::class);
        $term = $repo->find($id);

        if (!$term) {
            throw $this->createNotFoundException('Term is not found!');
        }

        return $this->render('@Term/Term/view.html.twig', [
           'term' => $term
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $term = new Term();
        $form = $this->createForm(TermForm::class, $term);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($term);
            $em->flush();

            return $this->redirectToRoute('term_list');
        }

        return $this->render('@Term/Term/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Term::class);
        $term = $repo->find($id);

        if (!$term) {
            throw $this->createNotFoundException('Term is not found!');
        }

        $form = $this->createForm(TermForm::class, $term);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $em->persist($term);
            $em->flush();

            return $this->redirectToRoute('term_list');
        }


        return $this->render('@Term/Term/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function removeAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Term::class);
        $term = $repo->find($id);

        if (!$term) {
            throw $this->createNotFoundException('Term is not found!');
        }

        $form = $this->createForm(TermDeleteForm::class, $term);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $em->remove($term);
            $em->flush();

            return $this->redirectToRoute('term_list');
        }

        return $this->render('@Term/Term/delete.html.twig', [
            'form' => $form->createView()
        ]);


    }

}
