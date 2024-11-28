<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\BlogPost;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends FrontendController {
  /**
   * @param Request $request
   * @return array
   */
  public function indexAction(Request $request): Response {
    return $this->render('blog/index.html.twig');
  }

  /**
   * @route ("/blog/{slug}-{blogPostId}", name="blog_post_show", requirements={"slug"="[\w-]+", "blogPostId"="\d+"})
   * @param Request $request
   * @param int $blogPostId
   * @return Response
   * @throws \Exception
   */
  public function showAction(
    Request $request,
    int $blogPostId
  ) {
    $blogPost = BlogPost::getById($blogPostId);
    if(empty($blogPost)) {
      throw new \Exception("Blog post not found");
    }
    return $this->render('blog/show.html.twig', [
      'blog_post' => [],
    ]);
  }
}
