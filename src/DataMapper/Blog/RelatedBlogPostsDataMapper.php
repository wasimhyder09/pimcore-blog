<?php

namespace App\DataMapper\Blog;

use App\DataMapper\AbstractDataMapper;
use Pimcore\Model\DataObject\BlogPost;

/**
 * @property BlogPost $resource
 */
class RelatedBlogPostsDataMapper extends AbstractDataMapper {
  public function toArray($request): array {

    $linkGenerator = $this->resource->getClass()->getLinkGenerator();

    $image = $this->resource->getImage();
    $imageUrl = null;

    if ($image instanceof \Pimcore\Model\Asset\Image) {
      $imageUrl = $image->getFullPath(); // Or use getThumbnail('thumbnail_name')->getPath()
    }

    return [
      'id' => $this->resource->getId(),
      'image' => $imageUrl,
      'title' => $this->resource->getTitle(),
      'shortDescription' => $this->resource->getShortDescription(),
      'posted' => $this->resource->getDate()->setTimezone('Asia/Karachi')->format('F j, Y'),
      'slug' => $linkGenerator->generate($this->resource),
      'tags' => BlogPostTagDataMapper::list($this->resource->getTags())->all($request)
    ];
  }
}
