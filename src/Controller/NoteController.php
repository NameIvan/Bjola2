<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Form\NotesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    /**
     * @Route("/notes", name="notes")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $notes = $em->getRepository(Notes::class)->findAll();

        return $this->render('notes/index.html.twig', [
            'notes' => $notes,
        ]);
    }

    /**
     * @Route("/note/create", name="create_note")
     */
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $note =  new Notes();
        $form = $this->createForm(NotesType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($note);
            $em->flush();

            $this->addFlash('success', 'Note Created');

            return $this->redirectToRoute("notes");
        }

        return $this->render('notes/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/note/edit/{note}", name="edit_note")
     */
    public function edit(Notes $note,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(NotesType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($note);
            $em->flush();

            $this->addFlash('success', 'Note Edited');

            return $this->redirectToRoute("notes");
        }

        return $this->render('notes/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/note/remove/{note}", name="remove_note")
     */
    public function remove(Notes $note, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($note);
        $em->flush();

        return $this->redirectToRoute("notes");
    }
}
