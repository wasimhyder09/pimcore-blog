<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Pimcore\Model\DataObject\BlogPost\Listing as BlogPostListing;

class BlogPostListingQueryBuilder extends AbstractListingQueryBuilder {
  public function __construct(
    BlogPostListing $listing,
    Request $request
  ) {
    parent::__construct($listing, $request);
  }

  protected function addQueryBefore() {
    $this->query->distinct();

    $this->query->innerJoin(
      'object_BlogPost',
      'object_relations_BlogPost',
      'BlogPostRelations',
      'object_BlogPost.oo_id = BlogPostRelations.src_id'
    );

    $this->query->orderBy('object_BlogPost.date', 'DESC');
  }

  public function query(string $term) {
    $term = trim( $term );
    if(empty($term)) {
      return;
    }
    $this->query->innerJoin(
      'BlogPostRelations',
      'object_BlogPostTag',
      'BlogPostTag',
      'BlogPostRelations.dest_id = BlogPostTag.oo_id AND
        BlogPostRelations.type="object" AND
        BlogPostRelations.field_name = "tags"
      '
    );
    $this->query->where("object_BlogPostTag.title LIKE '%{$term}%'");

    $this->query->orWhere($this->query->expr()->or(
      $this->query->expr()->like("BlogPostTag.name", "'%{$term}%'")
    ));
  }

  public function categories(array $categories = []) {
    if(!count($categories)) {
      return;
    }

    $db = \Pimcore\Db::get();
    $categoryConditions = [];
    foreach ($categories as $category) {
      $categoryConditions[] = "CONCAT(',', object_BlogPost.categories, ',' LIKE ".$db->quote("%,{$category},%");
    }

    $categoryCondition = sprintf('%s', implode(' AND ', $categoryConditions));

    $this->query->andWhere($categoryCondition);
  }

  public function sortByDate(string $order) {
    $this->query->orderBy('object_BlogPost.date', $order);
  }
}
