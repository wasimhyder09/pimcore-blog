<?php

namespace App\Document\Areabrick;

use App\DataMapper\Areas\LatestBlogPostsDataMapper;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\Document\Editable\Area\Info;
use Symfony\Component\HttpFoundation\Request;

class LatestBlogPosts extends AbstractAreabrick {
  public function getName(): string {
    return 'Latest Blog Post';
  }

  public function action(Info $info): ?\Symfony\Component\HttpFoundation\Response
  {
    $blogPosts = new BlogPost\Listing();

    $blogPosts->setOrderKey('date');
    $blogPosts->setOrder('DESC');
    $blogPosts->setLimit(3);

    $info->setParams([
      'blog_posts' => LatestBlogPostsDataMapper::list($blogPosts->load())->all(new Request())
    ]);
  }
}
