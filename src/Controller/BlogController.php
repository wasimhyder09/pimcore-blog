<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends FrontendController {
  /**
   * @param Request $request
   * @return array
   */
  public function indexAction(Request $request): Response
  {
    return $this->render('blog/index.html.twig');
  }

}
