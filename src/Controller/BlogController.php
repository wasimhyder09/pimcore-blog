<?php

namespace App\Controller;

use App\DataMapper\Blog\BlogPostCategoryDataMapper;
use App\DataMapper\Blog\BlogPostListingDataMapper;
use App\DataMapper\Pagination\PaginatorDataMapper;
use App\Repository\BlogPostCategoryRepository;
use App\Repository\BlogPostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\BlogPost;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends FrontendController {

  public function __construct(
    private BlogPostRepository $blogPostRepository,
    private BlogPostCategoryRepository $blogPostCategoryRepository
  ) {
  }

  /**
   * @param Request $request
   * @return array
   */
  public function indexAction(Request $request, PaginatorInterface $paginator): Response {
    $paginator = $this->blogPostRepository->paginate($request, $paginator);
    $blogPostCategories = $this->blogPostCategoryRepository->all();
    return $this->render('blog/index.html.twig', [
      'paginator' => (new PaginatorDataMapper($paginator))->toArray($request),
      'blog_posts' => BlogPostListingDataMapper::list([...$paginator->getItems()])->all($request),
      'blog_post_categories' => BlogPostCategoryDataMapper::list($blogPostCategories)->all($request),
    ]);
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

    $blogPost = $this->blogPostRepository->find($blogPostId);

    if(empty($blogPost)) {
      throw new \Exception("Blog post not found");
    }
    return $this->render('blog/show.html.twig', [
      'blog_post' => [],
    ]);
  }
}
