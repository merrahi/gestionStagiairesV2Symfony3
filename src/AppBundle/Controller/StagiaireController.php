<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Stagiaire;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class StagiaireController extends Controller
{
    /**
     * @Route("/", name="listpage")
     */
    public function listAction()
    {
        $stgs=$this->getDoctrine()
            ->getRepository("AppBundle:Stagiaire")
            ->findAll();
        
        // replace this example code with whatever you need
        return $this->render('stagiaire/index.html.twig',array("stgs"=>$stgs));
    }
    /**
     * @Route("/stagiaire/create", name="createpage")
     */
    public function createAction(Request $request)
    {
      
        $stg=new Stagiaire;
        $form=$this->createFormBuilder($stg)
            ->add("firstname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("lastname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("username",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
             ->add("save",SubmitType::class,array("label"=>"Create Stagiaire","attr"=>array("class"=>"btn btn-primary","style"=>"margin-bottom:15px")))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //die("submited");
            //get data
            $fn=$form["firstname"]->getData();
            $ln=$form["lastname"]->getData();
            $un=$form["username"]->getData();
            
            $stg->setFirstName($fn);
            $stg->setLastName($ln);
            $stg->setUserName($un);
            $em=$this->getDoctrine()->getManager();
            
            $em->persist($stg);
            $em->flush();
            
            $this->addFlash(
                "notice",
                'Stagiaire ADDED'
            );
            return $this->redirectToRoute("listpage");
        }
        // replace this example code with whatever you need
        return $this->render('stagiaire/create.html.twig', array(
        "form" => $form->createView()
        ));
    }
    /**
     * @Route("/stagiaire/edit/{id}", name="editpage")
     */
    public function editAction($id,Request $request)
    {
          $stg=$this->getDoctrine()
            ->getRepository("AppBundle:Stagiaire")
            ->find($id);
        
        $form=$this->createFormBuilder($stg)
            ->add("firstname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("lastname",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
            ->add("username",TextType::class,array("attr"=>array("class"=>"form-control","style"=>"margin-bottom:15px")))
             ->add("save",SubmitType::class,array("label"=>"EDIT Stagiaire","attr"=>array("class"=>"btn btn-primary","style"=>"margin-bottom:15px")))
            ->getForm();
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //die("submited");
            //get data
            $fn=$form["firstname"]->getData();
            $ln=$form["lastname"]->getData();
            $un=$form["username"]->getData();
            
            $em=$this->getDoctrine()->getManager();
            $stg=$em->getRepository("AppBundle:Stagiaire")->find($id);
            $stg->setFirstName($fn);
            $stg->setLastName($ln);
            $stg->setUserName($un);
            
            $em->flush();
            
            $this->addFlash(
                "notice",
                'Stagiaire UPDATED'
            );
            return $this->redirectToRoute("listpage");
        }
        // replace this example code with whatever you need
        return $this->render('stagiaire/edite.html.twig', array(
        "form" => $form->createView()
        ));
        
        
    }
    /**
     * @Route("/stagiaire/details/{id}", name="detailspage")
     */
    public function detailsAction($id)
    {
        
         $stg=$this->getDoctrine()
            ->getRepository("AppBundle:Stagiaire")
            ->find($id);
        
        
        
        // replace this example code with whatever you need
        return $this->render('stagiaire/details.html.twig', array("stg"=>$stg)
        
        );
    }
     /**
     * @Route("/stagiaire/delete/{id}", name="deletepage")
     */
    public function deleteAction($id)
    { 
        $em=$this->getDoctrine()->getManager();
        $stg=$em->getRepository("AppBundle:Stagiaire")->find($id);        
          
        $em->remove($stg);
        $em->flush();  
        $this->addFlash(
                "notice",
                'Stagiaire REMOVED'
        );
        return $this->redirectToRoute("listpage");
    }
}
