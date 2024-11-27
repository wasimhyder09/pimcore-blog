<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UniqueIdExtension extends AbstractExtension {
  public function getFunctions() {
    return [
      new TwigFunction("uniqueid",function (string $prefix = '', bool $moreEntropy = false) {
        return uniqid($prefix, $moreEntropy);
      }),
    ];
  }
}
