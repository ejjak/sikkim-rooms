<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hotel;
use AppBundle\Entity\Milestone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @Route("/admin", name="administrator")
     */
    public function adminAction()
    {
        return $this->render(':default:admin-welcome.html.twig');
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

    /**
     * Lists all hotel entities.
     *
     * @Route("/hotels", name="hotels")
     * @Method("GET")
     */
    public function DestinationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $destination = $em->getRepository('AppBundle:Hotel')->findDestinationAction();
        return $this->render(':default:search-form.html.twig', array(
            'destination' => $destination
        ));
    }

    /**
     * Lists all hotel entities.
     *
     * @Route("/hotel_listing/{destination}", name="hotel_list")
     * @Method("GET")
     */
    public function HotelListingAction($destination,Request $request)
    {
        $_SESSION = $request->getSession();
        $uid = $_SESSION->getId();
        $conn = $this->get('database_connection');
        $em = $this->getDoctrine()->getManager();
        $hotels = $em->getRepository('AppBundle:Hotel')->findHotelsAction($destination);
//        dump($hotels);die;
        $response = array();
        foreach($hotels as $row)
        {
            if($row instanceof  Hotel){
            $id=$row->getId();
            $query = $conn->fetchAssoc('SELECT sum(`average`) as `average`, sum(`good`) as `good`, sum(`excellent`) as `excellent` FROM Review where hotel_id=?', array($id));
//            dump($query);die;
            if($query['average'] == "")
                $query['average'] = 0;

            if($query['good'] == "")
                $query['good'] = 0;

            if($query['excellent'] == "")
                $query['excellent'] = 0;

            $averageCount = $query['average'];
            $goodCount = $query['good'];
            $excellentCount = $query['excellent'];

            $likeORunlike = $conn->fetchAssoc('SELECT * FROM Review where hotel_id=? and uid=?', array($id,$uid));
            if($likeORunlike > 0)// check if alredy liked or not condition
            {

                $average = '';
                $good = '';
                $excellent = '';
                $disable_average = '';
                $disable_good = '';
                $disable_excellent = '';
                if($likeORunlike['average'] == 1) // if alredy liked then disable like button
                {
                    $average = 'disabled="disabled"';
                    $disable_good = "button_disable";
                    $disable_excellent = "button_disable";
                }
                elseif($likeORunlike['good'] == 1) // if alredy dislike the disable unlike button
                {
                    $good = 'disabled="disabled"';
                    $disable_average = "button_disable";
                    $disable_excellent = "button_disable";
                }
                elseif($likeORunlike['excellent'] == 1) // if alredy dislike the disable unlike button
                {
                    $excellent = 'disabled="disabled"';
                    $disable_average = "button_disable";
                    $disable_good = "button_disable";
                }

                $likeButton = '
            <input '.$average.' type="button" value="'.$averageCount.'" rel="'.$id.'" data-toggle="tooltip"  data-placement="top" title="Average" class="button_like '.$disable_average.'" id="linkeBtn_'.$id.'" />
            <input '.$good.' type="button" value="'.$goodCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Good" class="button_unlike '.$disable_good.'" id="unlinkeBtn_'.$id.'" />
            <input '.$excellent.' type="button" value="'.$excellentCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Excellent" class="button_excellent '.$disable_excellent.'" id="excellentBtn_'.$id.'" />
            ';
            }
            else{ //not liked and disliked product
                $likeButton = '
            <input  type="button" value="'.$averageCount.'" rel="'.$id.'" data-toggle="tooltip"  data-placement="top" title="Average" class="button_like" id="linkeBtn_'.$id.'" />
            <input  type="button" value="'.$goodCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Good" class="button_unlike" id="unlinkeBtn_'.$id.'" />
            <input  type="button" value="'.$excellentCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Excellent" class="button_excellent" id="excellentBtn_'.$id.'" />
            ';
            }

            $milestone = $row->getMilestone();
                $detail = array();
            foreach ($milestone as $val){
                if($val instanceof Milestone){
                    $detail[] = array(
                        'mtitle'=>$val->getTitle(),
                        'path' =>$val->getPath()
                    );
                }
            }

            $response[] = array(
                'title' => $row->getTitle(),
                'address' =>$row->getAddress(),
                'email' =>$row->getEmail(),
                'phone' => $row->getPhone(),
                'amenities'=>$row->getAmenities(),
                'maplink' => $row->getGmap(),
                'website' => $row->getWebsite(),
                'star' => $row->getStar(),
                'image' => $row->getImageurl(),
                'rangeA' => $row->getPriceRangeA(),
                'rangeB' => $row->getPriceRangeB(),
                'detail' => $detail,
                'likebutton' => $likeButton);
            }
        }
        return $this->render(':default:hotel-listing.html.twig', array(
            'res' => $response,
        ));
    }

    /**
     * Lists all hotel entities.
     *
     * @Route("/review", name="hotel_review")
     * @Method({"GET", "POST"})
     */
    public function HotelReviewAction(Request $request)
    {
        if(session_id() == '') {
            session_start();
        }
        $_SESSION = $request->getSession();
        $uid = $_SESSION->getId();
        $conn = $this->get('database_connection');
        if($_POST)  // AJAX request received section
        {
            $pid    = $_POST['pid'];
            $op = $_POST['op'];
            if($op == "average")
            {
                $gofor = "average";
            }
            elseif($op == "good")
            {
                $gofor = "good";
            }
            elseif($op == "excellent")
            {
                $gofor = "excellent";
            }
            else
            {
                exit;
            }
//            $query = mysqli_query($connection,"SELECT a from BBlineHotelBundle:Reviews  a WHERE a.hotel='".$pid."' and a.uid='".$uid."'");
//            $query = $em->createQuery("SELECT a FROM BBlineHotelBundle:Reviews a where a.hotel='" .$pid . "' and a.uid='".$uid."'");
//            $itemArray = $query->getOneOrNullResult();
//            $sql = "SELECT * FROM Reviews where hotel_id= ? and uid= ?";
//            $stmt = $conn->prepare($sql);
//            $stmt->bindValue(1, $pid);
//            $stmt->bindValue(2,$uid);
//            $stmt->execute();
//            $row = $stmt->fetchAll();
            $row = $conn->fetchColumn('SELECT * FROM Review where hotel_id=? and uid=?', array($pid,$uid));
            if($row > 0)// check if alredy liked or not condition
            {
                $likeORunlike = $conn->fetchAll('SELECT * FROM Review where hotel_id=? and uid=?', array($pid,$uid));
                $average='';
                $good='';
                $excellent='';
                foreach($likeORunlike as $val){
                    $average = $val['average'];
                    $good= $val['good'];
                    $excellent= $val['excellent'];
                }
                if($_POST)
                {
                    if($op == 'average')  // if alredy liked set unlike for alredy liked product
                    {

                        $conn->executeUpdate('update `Review` set `average` = ?, `good` = ?, `excellent` = ? where id = ? and uid = ?', array(1,0,0,$val['id'], $uid));
                        echo 2;

                    }
                    elseif($op == 'good') // if alredy unliked set like for alredy unliked product
                    {

                        $conn->executeUpdate('update `Review` set `good` = ?, `average`= ?, `excellent` = ? where id = ? and uid = ?', array(1,0,0,$val['id'], $uid));
                        echo 2;
//                    $conn->update('Reviews', array('unlike'=>'0', 'like'=>'1'), array('id'=>$likeORunlike[0]['id']), array('uid'=>$uid));
                    }
                    elseif($op == 'excellent')
                    {
                        $conn->executeUpdate('update `Review` set `excellent` = ?, `good` = ?, `average` =? where id = ? and uid = ?', array(1,0,0,$val['id'], $uid));
                        echo 2;
                    }
                }
//                dump($unlike);die;
//                if($average == 0)  // if alredy liked set unlike for alredy liked product
//                {
//
//                    $conn->executeUpdate('update `Review` set `average` = ? where id = ? and uid = ?', array(1,$val['id'], $uid));
//                    echo 2;
//
//                }
//                elseif($good == 0) // if alredy unliked set like for alredy unliked product
//                {
//
//                    $conn->executeUpdate('update `Review` set `good` = ? where id = ? and uid = ?', array(1,$val['id'], $uid));
//                    echo 2;
////                    $conn->update('Reviews', array('unlike'=>'0', 'like'=>'1'), array('id'=>$likeORunlike[0]['id']), array('uid'=>$uid));
//                }
//                elseif($excellent == 0)
//                {
//                    $conn->executeUpdate('update `Review` set `excellent` = ? where id = ? and uid = ?', array(1,$val['id'], $uid));
//                    echo 2;
//                }
            }
            else  // New Like
            {
                $conn->insert('Review', array('hotel_id' => $pid, 'uid' => $uid, $gofor => '1'));
                echo 1;
            }
            exit;
        }
        return $this->render(':default:review.html.twig', array(

        ));
    }

}
