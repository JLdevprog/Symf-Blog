<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
    	$repo = $this->getDoctrine()->getRepository(Article::class);

    	$articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }
    /**
    * @Route("/",name="home")
    */
    public function home(){
    	return $this->render('blog/home.html.twig');
    }
    /**
    * @Route("/blog/new", name="blog_create")
    */
    public function create(Request $request, ObjectManager $manager){
        // dump($request);

        // if($request->request->count() > 0){
        //     $article = new Article();
        //     $article->setTitle($request->request->get('title'))
        //             ->setContent($request->request->get('content'))
        //             ->setImage($request->request->get('image'))
        //             ->setCreateAt(new \DateTime());

        //     $manager->persist($article);
        //     $manager->flush();
        // }
        $article = new Article();

        $form = $this->createFormBuilder($article)
                    ->add('title', TextType::class,[
                        'attr' => [
                            'placeholder' => "Article Title"
                            // ,
                            // 'class' => 'form-control'
                        ]
                    ])
                    ->add('content')
                    ->add('image')
                    // ->add('save', SubmitType::class,[
                    //     'label' => 'Register'
                    // ])
                    ->getForm();

        // dump($article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $article->setCreateAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' =>$article->getId()]);
        }
        
        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView()
        ]);
    }
    /**
    * @Route("/blog/{id}",name="blog_show")
    */
    public function show(Article $article){

    	// $repo = $this->getDoctrine()->getRepository(Article::class);
    	// $article = $repo->find($id);

    	return $this->render('blog/show.html.twig',[
    		'article' => $article
    	]);
    }
}

