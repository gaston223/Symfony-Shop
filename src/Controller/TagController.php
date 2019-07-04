<?php
/**
 * Created by PhpStorm.
 * User: Gaoussou
 * Date: 01/07/2019
 * Time: 11:55
 */

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tag")
 */
class TagController extends AbstractController
{

    /**
     * @Route("/")
     * @param TagRepository $repository
     * @return Response
     */
    public function index(TagRepository $repository):Response
    {
    // Récupération de tous les tags publiés
        return $this->render('tag/index.html.twig', [
            'tags' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new")
     * @param Request $request
     * @param ObjectManager $manager
     * @return RedirectResponse|Response
     */
    public function new(Request $request, ObjectManager $manager):Response
    {
        $tag =new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tag);
            $manager->flush();
            $this->addFlash('success', 'Votre tag a bien été ajouté, félicitations !');

            return $this->redirectToRoute('app_tag_index');
        }

        return $this->render('tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     * @param Tag $tag
     * @return Response
     */
    public function show(Tag $tag): Response
    {
        return $this->render('tag/show.html.twig', [
            'tag' => $tag,
        ]);
    }

    /**
     * @Route("/{id}/edit")
     * @param Request $request
     * @param Tag $tag
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Request $request, Tag $tag, ObjectManager $manager):Response
    {
        $form =$this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash('warning', 'Tag bien modifié !');

            return $this->redirectToRoute('app_tag_index', [
                'id' => $tag->getId(),
            ]);
        }

        return $this->render('tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tag/delete/{id<[0-9]+>}")
     * @param ObjectManager $manager
     * @param Tag $tag
     * @return Response
     */
    public function delete(ObjectManager $manager, Tag $tag): Response
    {
        $manager->remove($tag);
        $manager->flush();
        $this->addFlash('danger', 'Tag supprimé à jamais.... =/');
        return $this->redirectToRoute('app_tag_index');
    }
}
