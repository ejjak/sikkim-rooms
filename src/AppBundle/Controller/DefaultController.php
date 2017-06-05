<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/page", name="hotel-listing")
     */
    public function pageAction(Request $request)
    {
        return $this->render('default/hotel-listing.html.twig');
    }

    /**
     * @Route("/pelling", name="pelling-hotel")
     */
    public function hotel1Action(Request $request)
    {
        return $this->render(':default:pelling-hotel.html.twig');
    }

    /**
     * @Route("/lachung", name="lachung-hotel")
     */
    public function hotel2Action(Request $request)
    {
        return $this->render(':default:lachung-hotel.html.twig');
    }

    /**
     * @Route("/namchi", name="namchi-hotel")
     */
    public function hotel3Action(Request $request)
    {
        return $this->render(':default:namchi-hotel.html.twig');
    }

    /**
     * @Route("/form", name="package_form")
     */

    public function packageFormAction(Request $request)
    {
        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm('AppBundle\Form\PackageForm',null,array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('package_form'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->sendEmail($form->getData())){

                    $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'Message has been sent successfully, we will get back to you as soon as possible. Thank you!');
                    // Everything OK, redirect to wherever you want ! :

//                    return $this->redirectToRoute('redirect_to_somewhere_now');
                }else{
                    // An error ocurred, handle
                    var_dump("Errooooor :(");
                }
            }
        }

        return $this->render('AppBundle::packageForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function sendEmail($data){
        $myappContactMail = 'sikkimrooms@gmail.com';
        $myappContactPassword = 'sikkimrooms.com7';

        // In this case we'll use the ZOHO mail services.
        // If your service is another, then read the following article to know which smpt code to use and which port
        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Sikkim Rooms ". $data["name"])
            ->setFrom(array($myappContactMail => "Message by ".$data["name"]))
            ->setTo(array(
                $myappContactMail => $myappContactMail
            ))
            ->setBody(
                "Name: ".$data["name"].
                "<br><b>Email id.: </b>".$data["email"].
                "<br><b>Phone no.: </b>".$data["phone"].
                "<br><b>Traveller: </b>"."Adult: ".$data["adult"]." Minor :".$data["minor"].
                "<br><b>No.of Nights: </b>".$data["nights"].
                "<br><b>Message: </b>".$data["details"]
                ,'text/html');


        return $mailer->send($message);
    }

}
