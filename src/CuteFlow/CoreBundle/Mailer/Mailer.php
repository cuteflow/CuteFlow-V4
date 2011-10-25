<?php

namespace CuteFlow\CoreBundle\Mailer;

use \Symfony\Component\Templating\EngineInterface;
use CuteFlow\CoreBundle\Model\SettingsManager;
use CuteFlow\CoreBundle\Entity\User;
use Symfony\Component\Routing\RouterInterface;

class Mailer
{
    /**
     * @param use Symfony\Component\Routing\RouterInterface $router
     * @param CuteFlow\CoreBundle\Model\SettingsManager $settingsManager
     * @param Symfony\Component\Templating\EngineInterface $templating
     */
    public function __construct( RouterInterface $router,
                                 SettingsManager $settingsManager,
                                 EngineInterface $templating,
                                 array $parameters)
    {
        $this->mailer = $settingsManager->getConfiguredMailer();
        $this->settingsManager = $settingsManager;
        $this->templating = $templating;
        $this->router = $router;
        $this->parameters = $parameters;
    }

    /**
     * @param CuteFlow\CoreBundle\Entity\User $user
     * @return void
     */
    public function sendResettingEmailMessage(User $user)
    {
        if ($this->settingsManager->getSettings()->getEmailFormat() == 'text/plain') {
            $template = $this->parameters['resetting.template'].".text.twig";
        }
        else {
            $template = $this->parameters['resetting.template'].".html.twig";
        }
        $url = $this->router->generate('cuteflow_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'confirmationUrl' => $url,
            'footer' => $this->settingsManager->getSettings()->getEmailFooter()
        ));
        $this->sendEmailMessage($rendered, $user->getEmail());
    }


    /**
     * @param CuteFlow\CoreBundle\Entity\User $user
     * @return void
     */
    public function sendWelcomeEmailMessage(User $user)
    {
        if ($this->settingsManager->getSettings()->getEmailFormat() == 'text/plain') {
            $template = $this->parameters['welcome.template'].".text.twig";
        }
        else {
            $template = $this->parameters['welcome.template'].".html.twig";
        }
        $url = $this->router->generate('cuteflow_dashboard', array(), true);
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'homepage' => $url,
            'footer' => $this->settingsManager->getSettings()->getEmailFooter()
        ));
        $this->sendEmailMessage($rendered, $user->getEmail());
    }

    /**
     * @param string $renderedTemplate
     * @param string $toEmail
     * @param string $fromEmail
     * @return void
     */
    protected function sendEmailMessage($renderedTemplate, $toEmail, $fromEmail = null)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $format = $this->settingsManager->getSettings()->getEmailFormat();

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setTo($toEmail)
            ->setFrom($this->settingsManager->getSettings()->getEmissionMailAddress())
            ->setBody($body, $format);

        if ($fromEmail != null) {
            $message->setFrom($fromEmail);
        }
        
        $this->mailer->send($message);
    }

    protected $mailer;
    protected $settingsManager;
    protected $templating;
    protected $router;
    protected $parameters;
}
