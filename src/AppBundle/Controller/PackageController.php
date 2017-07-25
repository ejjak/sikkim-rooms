<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Images;
use AppBundle\Entity\Package;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Package controller.
 *
 * @Route("package")
 */
class PackageController extends Controller
{
    /**
     * Lists all package entities.
     *
     * @Route("/", name="package_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $packages = $em->getRepository('AppBundle:Package')->findAll();
        foreach ($packages as $val)
        {
            $title = $val->getTitle();
            $image = $val->getPackageImage();
            foreach ($image as $pckg){
                if($pckg instanceof Images){
                    $path[]=$pckg->getPath();
                }
            }

        }
        return $this->render('package/index.html.twig', array(
            'packages' => $packages,
            'path' => $path,
            'title'=>$title
        ));
    }

    /**
     * Creates a new package entity.
     *
     * @Route("/new", name="package_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $package = new Package();
        $form = $this->createForm('AppBundle\Form\PackageType', $package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($package);
            $em->flush();

            return $this->redirectToRoute('package_show', array('id' => $package->getId()));
        }

        return $this->render('package/new.html.twig', array(
            'package' => $package,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a package entity.
     *
     * @Route("/{id}", name="package_show")
     * @Method("GET")
     */
    public function showAction(Package $package)
    {
        $deleteForm = $this->createDeleteForm($package);

        return $this->render('package/show.html.twig', array(
            'package' => $package,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing package entity.
     *
     * @Route("/{id}/edit", name="package_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Package $package)
    {
        $deleteForm = $this->createDeleteForm($package);
        $editForm = $this->createForm('AppBundle\Form\PackageType', $package);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Package has been successfully updated !');
            return $this->redirectToRoute('package_edit', array('id' => $package->getId()));
        }

        return $this->render('package/edit.html.twig', array(
            'package' => $package,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a package entity.
     *
     * @Route("/{id}", name="package_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Package $package)
    {
        $form = $this->createDeleteForm($package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($package);
            $em->flush();
        }

        return $this->redirectToRoute('package_index');
    }

    /**
     * Creates a form to delete a package entity.
     *
     * @param Package $package The package entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Package $package)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('package_delete', array('id' => $package->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
