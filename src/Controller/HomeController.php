<?php
namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Affiche une page HTML
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param ObjectManager $manager
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator, ObjectManager $manager): Response
    {
        //$sql="SELECT * FROM product";
        $query = new Query($manager);
        $dql = "SELECT p FROM App\Entity\Product AS p";
        // Creation d'un objet Query à partir du sql
        $query->setDQL($dql);

        //Recuperation de la pagination
        $paginateResults=$paginator->paginate(
            $query,
            $request->query->getInt('page', 1), //$GET('page')
            9
        );

        //return new Response('<html><body>Bonjour ! </body></html>');
        return $this->render('index.html.twig', ['paginateResults'=>$paginateResults]);
    }

    /**
     * @Route("/contact", name="app_contact")
     * @return Response
     */
    public function contact(): Response
    {
        return $this->render('contact.html.twig');
    }
}
