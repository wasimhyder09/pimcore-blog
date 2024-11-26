<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends FrontendController {
  /**
   * @param Request $request
   * @return array
   */
  #[Template('home/index.html.twig')]
  public function indexAction(Request $request): array {
    return [];
  }

}
