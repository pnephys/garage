<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Form\AnnonceEditType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AdController extends AbstractController
{
     /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo): Response
    {
        //$repo = $this->getDoctrine()->getRepository(Ad::class);

        $ads = $repo->findAll();

        

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

        /**
     * Permet d'afficher une seule annonce
     * @Route("/ads/{slug}", name="ads_show")
     *
     * @param [string] $slug
     * @return Response
     */
    public function show(Ad $ad)
    {
        

        return $this->render('ad/show.html.twig',[
            'ad' => $ad
        ]);

    }

    /**
     * Permet de créer une annonce
     * @Route("/ad/new", name="ads_create")
     *
     * @return Response
     */
    public function create(EntityManagerInterface $manager, Request $request){
        $ad = new Ad();

        $request->request->get('modele');

        $form = $this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()){ //permet de vérifier la validité du formulaire

            foreach($ad->getImages() as $image){ //boucle qui va chercher chaque image ajouté dans le formulaire
                $image->setAd($ad);
                
                $manager->persist($image);
            }
            // on ajoute l'auteur mais attention maintenant il y a un risque de bug si on n'est pas connecté (à corriger)
            

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getModele()}</strong> a bien été enregistrée"
            );

            return $this->redirectToRoute('ads_show',[
                'slug' => $ad->getSlug()
            ]);

        }
        return $this->render('ad/new.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
