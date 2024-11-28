<?php

namespace App\Website\LinkGenerator;

use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Tool;
use Pimcore\Twig\Extension\Templating\PimcoreUrl;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class BlogPostLinkGenerator implements LinkGeneratorInterface {

  public function __construct(
    private SluggerInterface $slugger,
    private PimcoreUrl $pimcoreUrl,
    private ContainerInterface $container
  ) {
  }

  public function generate(object $object, array $params = []): string {
    if(!$object instanceof BlogPost) {
      throw new \InvalidArgumentException("Object must be instance of BlogPost");
    }

    $slug = $this->slugger->slug($object->getTitle());

    $link = $this->pimcoreUrl->__invoke(
      [
        'slug' => $slug,
        'blogPostId' => $object->getId(),
      ],
      'blog_post_show',
      true
    );

    if(!str_contains($link, "https://") && !str_contains($link, "http://")) {
      $protocol = $this->container->getParameter('site_protocol');
      $link = Tool::getHostUrl($protocol).$link;
    }
    return $link;
  }
}
