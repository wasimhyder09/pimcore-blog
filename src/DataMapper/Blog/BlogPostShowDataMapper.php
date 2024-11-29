<?php

namespace App\DataMapper\Blog;

use App\DataMapper\AbstractDataMapper;
use Pimcore\Model\DataObject\BlogPost;
use \Pimcore\Model\Asset\Image;
use Pimcore\Model\User;

/**
 * @property BlogPost $resource
 */
class BlogPostShowDataMapper extends AbstractDataMapper {
  public function toArray($request): array {
    // Handle the image field
    $image = $this->resource->getImage();
    $imageUrl = null;
    if ($image instanceof Image) {
      $imageUrl = $image->getFullPath();
    }

    $postedBy = User::getById($this->resource->getPostedBy());

    $seoImage = $this->resource->getSeoImage();
    if ($seoImage instanceof \Pimcore\Model\Asset\Image) {
      $seoImagePath = $seoImage->getThumbnail('blogPostOgImage')->getPath();
    } else {
      $seoImagePath = null;
    }


    return [
      'id' => $this->resource->getId(),
      'image' => $imageUrl,
      'title' => $this->resource->getTitle(),
      'short_description' => $this->resource->getShortDescription(),
      'content' => $this->resource->getContent(),
      'posted' => $this->resource->getDate()->setTimezone('Asia/Karachi')->format('F j, Y'),
      'posted_by' => $postedBy->getFirstname(),
      'about' => $this->resource->getAbout(),
      'ad' => $this->resource->getAd(),
      'canonical_url' => $this->resource->getCannocialUrl(),
      'seo_title' => $this->resource->getSeoTitle(),
      'seo_description' => $this->resource->getSeoDescription(),
      'og_url' => $this->resource->getOgUrl(),
      'og_locale' => $this->resource->getOgLocale(),
      'seo_image' => $seoImagePath,
      'tags' => BlogPostTagDataMapper::list($this->resource->getTags())->all($request),
      'related_blog_posts' => RelatedBlogPostsDataMapper::list($this->resource->getRelatedBlogPosts())->all($request),
    ];
  }
}
