<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LearningController extends AbstractController {
    private $requestStack;

    public function __construct(RequestStack $requestStack) {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/learning", name="learning")
     */
    public function index(): Response {
        return $this->render('learning/index.html.twig', [
            'controller_name' => 'LearningController',
        ]);
    }

    /**
     * @Route("/about-me", name="AABOUT")
     */
    public function aboutMe(): Response {
        return $this->render('learning/about.html.twig', [
            'zemmer' => 'homows!!',
        ]);
    }

    /**
    * @Route("/", name="showMyName")
    */
    public function showMyName(Request $request): Response {
        $form = $this->createFormBuilder()
        ->add('name', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Change Name'])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $name = $task['name'];
            $session = $this->requestStack->getSession();
            $session->set('name', $name);

            return $this->redirect('showMyName');
        }

        return $this->render('learning/show.html.twig', [
            'form' => $form->createView(),
            'name' => 'unkown'
        ]);
    }
}