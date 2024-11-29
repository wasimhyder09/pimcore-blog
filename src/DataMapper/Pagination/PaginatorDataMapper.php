<?php

namespace App\DataMapper\Pagination;

use App\DataMapper\AbstractDataMapper;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @property PaginationInterface $resource
 */
class PaginatorDataMapper extends AbstractDataMapper {
  public function toArray($request): array {
    return $this->resource->getPaginationData();
  }
}
