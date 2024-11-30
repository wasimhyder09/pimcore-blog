<?php

namespace App\Sitemaps\Processor;

use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\Element\ElementInterface;
use Pimcore\Bundle\SeoBundle\Sitemap\Element\GeneratorContextInterface;
use Pimcore\Bundle\SeoBundle\Sitemap\Element\ProcessorInterface;
use Pimcore\Tool;
use Presta\SitemapBundle\Sitemap\Url\Url;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Presta\SitemapBundle\Sitemap\Url as Sitemap;

class BlogPostImageProcessor implements ProcessorInterface {

  public function __construct(
    private ContainerInterface $container
  ) {
  }

  public function process(Url $url, ElementInterface $element, GeneratorContextInterface $context): Url {
    if(!$element instanceof BlogPost || empty($image = $element->getImage())) {
      return $url;
    }
    $image = $image->getImage();
    $imageUrl = Tool::getHostUrl($this->container->getParameter('site_protocol')) . $image->getRealFullPath();
    $decoratedUrl = new Sitemap\GoogleImageUrlDecorator($url);
    $decoratedUrl->addImage(new Sitemap\GoogleImage($imageUrl));

    return $decoratedUrl;
  }
}
