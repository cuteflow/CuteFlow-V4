<?php

namespace CuteFlow\CoreBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use CuteFlow\CoreBundle\Model\SettingsManager;
use Doctrine\ORM\EntityManager;

class LoginHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(EntityManager $entityManager, SettingsManager $settingsManager)
    {
        $this->em = $entityManager;
        $this->sm = $settingsManager;
    }

    public function onAuthenticationSuccess(Request $request,
                                            TokenInterface $token)
    {
        $user = $token->getUser();
        $session = $request->getSession();

        if ($user->getLocale()) {
            $session->setLocale($user->getLocale());
        }
        else {
            $session->setLocale($this->sm->getSettings()->getDefaultLocale());
        }

        if ($user->getTheme()) {
            $session->set('cuteflow_theme', $user->getTheme());
        }

        $user->setLastLogin(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();
        
        if ($targetUrl = $session->get('_security.target_path')) {
            $session->remove('_security.target_path');
        }
        else {
            $targetUrl = '/';
        }
        
        return new RedirectResponse(0 !== strpos($targetUrl, 'http') ? $request->getUriForPath($targetUrl) : $targetUrl);
    }

    protected $em;
    protected $sm;
}
