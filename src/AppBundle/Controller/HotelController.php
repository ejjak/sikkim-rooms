<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hotel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hotel controller.
 *
 * @Route("hotel")
 */
class HotelController extends Controller
{
    /**
     * Lists all hotel entities.
     *
     * @Route("/", name="hotel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hotels = $em->getRepository('AppBundle:Hotel')->findAll();

        return $this->render('hotel/index.html.twig', array(
            'hotels' => $hotels,
        ));
    }

    /**
     * Creates a new hotel entity.
     *
     * @Route("/new", name="hotel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hotel = new Hotel();
        $form = $this->createForm('AppBundle\Form\HotelType', $hotel);
        $hotel->setCreated(new \DateTime());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $hotel->getImageurl();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('directory'),
                $fileName
            );
            $hotel->setImageurl($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'New Hotel has been added successfully !');

            return $this->redirectToRoute('hotel_index', array('id' => $hotel->getId()));
        }

        return $this->render('hotel/new.html.twig', array(
            'hotel' => $hotel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hotel entity.
     *
     * @Route("/{id}", name="hotel_show")
     * @Method("GET")
     */
    public function showAction(Hotel $hotel)
    {
        $deleteForm = $this->createDeleteForm($hotel);

        return $this->render('hotel/show.html.twig', array(
            'hotel' => $hotel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hotel entity.
     *
     * @Route("/{id}/edit", name="hotel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hotel $hotel)
    {
        $fileName=$hotel->getImageurl();
        $deleteForm = $this->createDeleteForm($hotel);
        $hotel->setImageurl(
            new File($this->getParameter('directory').'/'.$hotel->getImageurl())
        );
        $editForm = $this->createForm('AppBundle\Form\HotelType', $hotel);
        $hotel->setModified(new \DateTime());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $hotel->getImageurl();
            if ($file)
            {
                $file_path='uploads/hotels/'.$fileName;
                unlink($file_path);
                $fileName1 = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('directory'),
                    $fileName1
                );
                $hotel->setImageurl($fileName1);

            }
            else
            {
                $hotel->setImageurl($hotel);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Hotel has been successfully updated !');
            return $this->redirectToRoute('hotel_edit', array('id' => $hotel->getId()));
        }

        return $this->render('hotel/edit.html.twig', array(
            'hotel' => $hotel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hotel entity.
     *
     * @Route("/{id}", name="hotel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hotel $hotel)
    {
        $form = $this->createDeleteForm($hotel);
        $form->handleRequest($request);
        $fileName=$hotel->getImageurl();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($fileName)
            {
                $file_path='uploads/hotels/'.$fileName;
                unlink($file_path);
            }
            $em->remove($hotel);
            $em->flush();
        }

        return $this->redirectToRoute('hotel_index');
    }

    /**
     * Creates a form to delete a hotel entity.
     *
     * @param Hotel $hotel The hotel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hotel $hotel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hotel_delete', array('id' => $hotel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
