<?php
/**
 * Created by PhpStorm.
 * User: ejjak
 * Date: 26/10/17
 * Time: 7:11 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class FormController extends Controller
{

    /**
     * @Route("/taxi", name="taxi_form")
     */

    public function taxiFormAction(Request $request)
    {
        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm('AppBundle\Form\TaxiForm',null,array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('taxi_form'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);
            if($form->isValid()){
                // Send mail
                if($this->sendTaxiEmail($form->getData())){

                    $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'Message has been sent successfully, we will get back to you as soon as possible. Thank you!');
                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirectToRoute('taxi_form');
                }else{
                    // An error ocurred, handle
                    var_dump("Errooooor :(");
                }
            }
        }

        return $this->render('AppBundle::taxiForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    private function sendTaxiEmail($data){
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
                "<b>Name:</b> ".$data["name"].
                "<br><b>Phone no.: </b>".$data["phone"].
                "<br><b>Travel Date.: </b>".$data["travelDate"].
                "<br><b>From: </b>".$data["from"]." <b>To: </b> :".$data["to"].
                "<br><b>Trip: </b>".$data["trip"].
                "<br><b>Car Type: </b>".$data["carType"]
                ,'text/html');


        return $mailer->send($message);
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