<?php

namespace Gulloa\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')) {
            return $this->redirect($this->generateUrl('cai_web_homepage'));
        }
        return $this->redirect($this->generateUrl('cai_frontend_homepage'));
    }
}
