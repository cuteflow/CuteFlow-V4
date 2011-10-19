<?php
namespace CuteFlow\CoreBundle\Controller;

use CuteFlow\CoreBundle\Form\SettingsGeneralType;
use CuteFlow\CoreBundle\Form\SettingsEmailType;
use CuteFlow\CoreBundle\Model\UserManager;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CuteFlow\CoreBundle\Entity\User;
use CuteFlow\CoreBundle\Form\UserType;

class ResettingController extends Controller
{
    /**
     * @Route("/user/resetting/request", name="cuteflow_user_resetting_request")
     * @Template()
     *
     * @return array
     */
    public function requestAction()
    {
       return $this->container->get('templating')->renderResponse('CuteFlowCoreBundle:Resetting:request.html.twig');
    }

    /**
     * @Route("/user/resetting/sendemail", name="cuteflow_user_resetting_send_email")
     * @Template()
     *
     * @return array
     */
    public function sendEmailAction()
    {
        $username = $this->container->get('request')->request->get('username');
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('CuteFlowCoreBundle:User')->findOneBy(array('username'=> $username));
        //$user = $em->getRepository('CuteFlowCoreBundle:User')->findOneByUsername($username));
        if ($user){
           if (!$user->getConfirmationToken())
           {
              //$user[0]->setConfirmationToken($user[0]->generateToken());
              $user_manager = $this->get('cuteflow.user_manager');
              $user_manager->generateConfirmationToken($user);
              $em->persist($user);
              $em->flush(); 
           }
           $this->get('cuteflow.mailer')->sendResettingEmailMessage($user);
           return new RedirectResponse($this->container->get('router')->generate('cuteflow_user_resetting_checkemail'));
        }
        return $this->container->get('templating')->renderResponse('CuteFlowCoreBundle:Resetting:request.html.twig',array('invalid_username' => 1));
    }

    /**
     * @Route("/user/resetting/checkemail", name="cuteflow_user_resetting_checkemail")
     * @Template()
     *
     * @return array
     */

    public function checkEmailAction()
    {
          return $this->container->get('templating')->renderResponse('CuteFlowCoreBundle:Resetting:checkEmail.html.twig');
    }
    /**
     * @Route("/user/resetting/reset", name="cuteflow_user_resetting_reset")
     * @Template()
     *
     * @return array
     */
    public function resetAction()
    {
       return $this->container->get('templating')->renderResponse('CuteFlowCoreBundle:Resetting:request.html.twig');
    }
}
