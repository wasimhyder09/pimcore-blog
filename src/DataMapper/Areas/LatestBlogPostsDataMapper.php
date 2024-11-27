<?php

namespace App\DataMapper\Areas;

use App\DataMapper\AbstractDataMapper;
use Pimcore\Model\DataObject\BlogPost;

/**
 * @property BlogPost $resource
 */
class LatestBlogPostsDataMapper extends AbstractDataMapper {
  public function toArray($request): array {
    return [
      'id' => $this->resource->getId(),
      'image' => $this->resource->getImage() ?->getImage(),
      'title' => $this->resource->getTitle(),
      'shortDescription' => $this->resource->getShortDescription(),
      'posted' => $this->resource->getDate()->setTimezone('Asia/Karachi')->format('F j, Y'),
      'slug' => '',
      'tags' => []
    ];
  }
}
