<?php

namespace Statamic\Addons\ThirdParty;

use Exception;
use Statamic\Extend\Tags;

class ThirdPartyTags extends Tags {
  /**
   * Filters through API data and returns an array based on the desired
   * type, removing elements that are disabled.
   */
  private function getData($type, $position = 'bottom') {
    $data = $this->api('ThirdParty')->get($this->context['current_uri'], $type);

    $data = array_filter($data, function ($item) {
      if (array_key_exists('enabled', $item)) {
        return $item['enabled'];
      } else {
        return false;
      }
    });

    // Filter body scripts by position, default to bottom.
    if (!$position) $position = 'bottom';
    if ($type == 'body' && $position) {
      $data = array_filter($data, function ($item) use(&$position) {
        return $item['position'] == $position;
      });
    }

    $data = array_map(function ($item) {
      return $item['content'];
    }, $data);

    return implode('', $data);
  }

  /**
   * The {{ third_party }} tag
   * It renders global scripts and pixels by specifying which type.
   *
   * @return array
   */
  public function index() {
    $type = $this->getParam('type');
    $position = $this->getParam('position');

    // For safety, don't return everything.
    if (!$type) throw new Exception('{{ third_party }} must specify a type.');
    return $this->getData($type, $position);
  }

  /**
   * The {{ third_party:head }} tag
   * It renders global <head> scripts and pixels.
   *
   * @return array
   */
  public function head() {
    return $this->getData('head');
  }

  /**
   * The {{ third_party:body }} tag
   * It renders global <body> scripts and pixels.
   *
   * @return array
   */
  public function body() {
    $position = $this->getParam('position');
    return $this->getData('body', $position);
  }
}
