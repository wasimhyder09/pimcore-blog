<?php
namespace App\Controller;

use App\Form\ContactFormType;
use Pimcore\Controller\FrontendController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends FrontendController
{
  private $formFactory;

  public function __construct(FormFactoryInterface $formFactory)
  {
    $this->formFactory = $formFactory;
  }

  public function indexAction(Request $request): Response
  {
    $form = $this->formFactory->create(ContactFormType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $formData = $form->getData();

      try {
        $mail = \Pimcore\Mail();
        $mail->from($formData['email']);
        $mail->to('wasimhyder09@gmail.com'); // Fixed recipient
        $mail->setDocument('/emails/contact-us');
        $mail->setParams($formData);
        $mail->send();
      } catch (\Throwable $exception) {
        return $this->redirect('/contact');
      }

      return $this->redirect('/contact');
    }

    return $this->render("contact/index.html.twig", [
      'form' => $form->createView(),
    ]);
  }

  public function contactMailAction(Request $request): Response
  {
    $attributes = $request->attributes->all();
    return $this->render("emails/contact.html.twig", $attributes);
  }
}
