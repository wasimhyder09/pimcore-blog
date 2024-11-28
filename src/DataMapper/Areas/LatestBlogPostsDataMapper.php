<?php

namespace App\DataMapper\Areas;

use App\DataMapper\AbstractDataMapper;
use App\DataMapper\Blog\BlogPostTagDataMapper;
use Pimcore\Model\DataObject\BlogPost;

/**
 * @property BlogPost $resource
 */
class LatestBlogPostsDataMapper extends AbstractDataMapper {
  public function toArray($request): array {

    $linkGenerator = $this->resource->getClass()->getLinkGenerator();

    return [
      'id' => $this->resource->getId(),
      'image' => $this->resource->getImage() ?->getImage(),
      'title' => $this->resource->getTitle(),
      'shortDescription' => $this->resource->getShortDescription(),
      'posted' => $this->resource->getDate()->setTimezone('Asia/Karachi')->format('F j, Y'),
      'slug' => $linkGenerator->generate($this->resource),
      'tags' => BlogPostTagDataMapper::list($this->resource->getTags())->all($request);
    ];
  }
}
