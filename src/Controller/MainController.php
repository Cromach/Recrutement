<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('App:Image');
        $images = $repository->findAll();
        return $this->render('main/index.html.twig', ['images' => $images,]);
    }

    /**
    * @Route("/upload", name="upload")
    */
    public function upload(Request $request)
    {
        $file = $request->files->get('file');
        $status = array('status' => "success","fileUploaded" => false);
        // $file is an UploadedFile - https://github.com/symfony/symfony/blob/2.8/src/Symfony/Component/HttpFoundation/File/UploadedFile.php
        if(!is_null($file)){
            $filename = uniqid().".".$file->getClientOriginalExtension();
            $path = __DIR__.'/../../public/images';
            $file->move($path,$filename); // move the file to a path
            $image = new Image();
            $image->setName($request->request->get('titre'));
            $image->setPath("./images/".$filename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            $status = array('status' => "success","fileUploaded" => true, "path" => "./images/".$filename, "id" => $image->getId());
        }
        return new JsonResponse($status);
    }
    /**
    * @Route("/delete", name="delete")
    */
    public function delete(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('App:Image');
        $image = $repository->find($id);

        $filename = $image->getPath();
        $filesystem = new Filesystem();
        $filesystem->remove($filename);

        $status = array('status' => "success", 'id' => $image->getId());

        $em->remove($image);
        $em->flush();

        return new JsonResponse($status);
    }

}
