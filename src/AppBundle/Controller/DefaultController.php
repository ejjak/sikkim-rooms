<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Banner;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Images;
use AppBundle\Entity\Milestone;
use Doctrine\ORM\Query;
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
     * @Route("bannerImage", name="banner_image")
     */
    public function bannerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $banner = $em->getRepository('AppBundle:Banner')->findAll();
        foreach ($banner as $val)
        {
            if($val instanceof Banner){
                $image=$val->getImageurl();
            }
        }
        return $this->render(':banner:banner.html.twig', array(
            'image' => $image,
        ));
    }

    /**
     * @Route("advertise", name="advertisement")
     */
    public function advertAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Advert')->findAll();
        $adverts= array();
        foreach ($query as $val)
        {
            $advert=$val->getAdvertImage();
            foreach ($advert as $value){
               if ($value instanceof Images){
                   $adverts[]= $value->getPath();
               }
            }
        }
        return $this->render(':default:advert.html.twig', array(
            'adverts' => $adverts,
        ));
    }

    /**
     * @Route("deals", name="best_deals")
     */
    public function packageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:Package')->findAll();
        $deals= array();
        foreach ($query as $val)
        {
            $title=$val->getTitle();
            $image=$val->getPackageImage();
            foreach ($image as $value){
                if ($value instanceof Images){
                    $deals[]= $value->getPath();
                }
            }
        }
//        dump($deals);die;
        return $this->render(':package:deals.html.twig', array(
            'deals' => $deals,
            'title' => $title
        ));
    }

    /**
     * @Route("/admin", name="administrator")
     */
    public function adminAction()
    {
        return $this->render(':default:admin-welcome.html.twig');
    }

    /**
     * @Route("/data", name="hotel-data")
     */
    public function pageAction(Request $request)
    {
        return $this->render('default/hotel-data.html.twig');
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
     * @Route("/listing/{destination}", name="hotel_list")
     * @Method("GET")
     */
    public function HotelListingAction($destination,Request $request)
    {
        $_SESSION = $request->getSession();
        $uid = $_SESSION->getId();
        $conn = $this->get('database_connection');
        $em = $this->getDoctrine()->getManager();
        $hotels = $em->getRepository('AppBundle:Hotel')->findHotelsAction($destination);
        shuffle($hotels);
        $response = array();
        foreach($hotels as $row)
        {
            if($row instanceof  Hotel){
            $id=$row->getId();
            $query = $conn->fetchAssoc('SELECT sum(`average`) as `average`, sum(`good`) as `good`, sum(`excellent`) as `excellent` FROM review where hotel_id=?', array($id));
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

            $likeORunlike = $conn->fetchAssoc('SELECT * FROM review where hotel_id=? and uid=?', array($id,$uid));
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
            <input '.$average.' type="button" value="'.$averageCount.'" rel="'.$id.'" data-toggle="tooltip"  data-placement="top" title="Average" class="button_like '.$disable_average.'" id="likeBtn_'.$id.'" />
            <input '.$good.' type="button" value="'.$goodCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Good" class="button_unlike '.$disable_good.'" id="unlikeBtn_'.$id.'" />
            <input '.$excellent.' type="button" value="'.$excellentCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Excellent" class="button_excellent '.$disable_excellent.'" id="excellentBtn_'.$id.'" />
            ';
            }
            else{ //not liked and disliked product
                $likeButton = '
            <input  type="button" value="'.$averageCount.'" rel="'.$id.'" data-toggle="tooltip"  data-placement="top" title="Average" class="button_like" id="likeBtn_'.$id.'" />
            <input  type="button" value="'.$goodCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Good" class="button_unlike" id="unlikeBtn_'.$id.'" />
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
            $row = $conn->fetchColumn('SELECT * FROM review where hotel_id=? and uid=?', array($pid,$uid));
            if($row > 0)// check if alredy liked or not condition
            {
                $likeORunlike = $conn->fetchAll('SELECT * FROM review where hotel_id=? and uid=?', array($pid,$uid));
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

                        $conn->executeUpdate('update `review` set `average` = ?, `good` = ?, `excellent` = ? where id = ? and uid = ?', array(1,0,0,$val['id'], $uid));
                        echo 2;

                    }
                    elseif($op == 'good') // if alredy unliked set like for alredy unliked product
                    {

                        $conn->executeUpdate('update `review` set `good` = ?, `average`= ?, `excellent` = ? where id = ? and uid = ?', array(1,0,0,$val['id'], $uid));
                        echo 2;
//                    $conn->update('Reviews', array('unlike'=>'0', 'like'=>'1'), array('id'=>$likeORunlike[0]['id']), array('uid'=>$uid));
                    }
                    elseif($op == 'excellent')
                    {
                        $conn->executeUpdate('update `review` set `excellent` = ?, `good` = ?, `average` =? where id = ? and uid = ?', array(1,0,0,$val['id'], $uid));
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
                $conn->insert('review', array('hotel_id' => $pid, 'uid' => $uid, $gofor => '1'));
                echo 1;
            }
            exit;
        }
        return $this->render(':default:review.html.twig', array(

        ));
    }


    /**
     * @Route("/sikkim-tour", name="sikkim-tour")
     */
    public function sikkimTourAction(Request $request)
    {

        return $this->render(':default:sikkim-tour.html.twig');
    }


    /**
     * Lists all hotel entities.
     *
     * @Route("/listing", name="filter_hotels")
     */
    public function AllHotelListingAction(Request $request)
    {
        $locaton = $request->request->get('destination');
        $_SESSION = $request->getSession();
        $uid = $_SESSION->getId();
        $conn = $this->get('database_connection');
        $em = $this->getDoctrine()->getManager();
        $hotels = $em->getRepository('AppBundle:Hotel')->filterHotelAction();
        shuffle($hotels);
        $count = count($hotels);
        $response = array();
        foreach($hotels as $row)
        {
            if($row instanceof  Hotel){
                $id=$row->getId();
                $query = $conn->fetchAssoc('SELECT sum(`average`) as `average`, sum(`good`) as `good`, sum(`excellent`) as `excellent` FROM review where hotel_id=?', array($id));
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

                $likeORunlike = $conn->fetchAssoc('SELECT * FROM review where hotel_id=? and uid=?', array($id,$uid));
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
            <input '.$average.' type="button" value="'.$averageCount.'" rel="'.$id.'" data-toggle="tooltip"  data-placement="top" title="Average" class="button_like '.$disable_average.'" id="likeBtn_'.$id.'" />
            <input '.$good.' type="button" value="'.$goodCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Good" class="button_unlike '.$disable_good.'" id="unlikeBtn_'.$id.'" />
            <input '.$excellent.' type="button" value="'.$excellentCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Excellent" class="button_excellent '.$disable_excellent.'" id="excellentBtn_'.$id.'" />
            ';
                }
                else{ //not liked and disliked product
                    $likeButton = '
            <input  type="button" value="'.$averageCount.'" rel="'.$id.'" data-toggle="tooltip"  data-placement="top" title="Average" class="button_like" id="likeBtn_'.$id.'" />
            <input  type="button" value="'.$goodCount.'" rel="'.$id.'" data-toggle="tooltip" data-placement="top" title="Good" class="button_unlike" id="unlikeBtn_'.$id.'" />
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
            'count'=>$count,
            'location'=>$locaton
        ));
    }

}
