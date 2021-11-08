<?php

namespace App\Controller;

use App\Entity\Certification;
use App\Form\CertificationForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class CertificationController extends AbstractController
{

    /**
     * @Route("/certification", name="certification")
     */
    public function listCertification()
    {

        $em=$this->getDoctrine()->getManager();
        $certification=$em->getRepository("App\Entity\Certification")->findAll();
    return $this->render("Certification/listCertification.html.twig",["listeCertification"=>$certification]);

    }

    /**
     * @Route("/addCertification",name="add_certification")
     */

   public function addCertification(Request  $request)
    {
        $certification=new Certification();
        $form=$this->createForm(CertificationForm::class,$certification);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid())
        {
            // pour afficher contenu die
            //var_dump("contenu"); die;
            $em=$this->getDoctrine()->getManager();

            $em->persist($certification);
            $em->flush();
           return $this->redirectToRoute('certification');
        }

        return $this->render('Certification/addCertification.html.twig',['formCertification'=>$form->createView()]);
    }

    /**
     * @Route ("/deleteCertification/{id}",name="CertificationDelete")
     */
public function deleteCertification($id):Response
{
    $em=$this->getDoctrine()->getManager();
    $certification=$em->getRepository("App\Entity\Certification")->find($id);

    if($certification!==null){
        $em->remove($certification);
        $em->flush();
    }
    else{
        throw new NotFoundHttpException("the certification with ID ".$id."does not exist");
    }
    return $this->redirectToRoute('certification');
}

/**
 * @Route("/UpdateCertification/{id}",name="CertificationUpdate")
 */
public function UpdateCertififcation(Request $request,$id):Response
{
    $em=$this->getDoctrine()->getManager();
    $certification=$em->getRepository("App\Entity\Certification")->find($id);
    $editform=$this->createForm(CertificationForm::class,$certification);

    $editform->handleRequest($request);

    if($editform->isSubmitted() and $editform->isValid()){
        $em->persist($certification);
        $em->flush();
        return $this->redirectToRoute('certification');
    }
    return $this->render('Certification/updateCertification.html.twig',['editformCertification'=>$editform->createView()]);


}


}