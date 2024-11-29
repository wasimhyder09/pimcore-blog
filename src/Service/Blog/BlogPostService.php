<?php

namespace App\Service\Blog;

use Pimcore\Model\DataObject\BlogPost;

class BlogPostService {
  public function setSEO(BlogPost $blogPost) {
    if(empty($blogPost->getOgUrl()) || empty($blogPost->getCannocialUrl())) {
      $linkGenerator = $blogPost->getClass()->getLinkGenerator();
      $url = $linkGenerator->generate($blogPost);

      if(empty($blogPost->getOgUrl())) {
        $blogPost->setOgUrl($url);
      }

      if(empty($blogPost->getCannocialUrl())) {
        $blogPost->setCannocialUrl($url);
      }
    }

    if(empty($blogPost->getSeoTitle())) {
      $blogPost->setSeoTitle($blogPost->getTitle());
    }

    if(empty($blogPost->getSeoDescription())) {
      $blogPost->setSeoDescription($blogPost->getShortDescription());
    }

  }
}
