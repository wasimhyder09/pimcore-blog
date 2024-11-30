<?php

namespace App\Controller;


use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends FrontendController {

  /**
   * @param Request $request
   * @return array
   */
  public function indexAction(Request $request) {
    return $this->render("contact/index.html.twig", [

    ]);
  }
}
