<?php

namespace Statamic\Addons\ThirdParty;

use Statamic\Extend\API;

class ThirdPartyAPI extends API {
  /**
   * Filters out configurations by their type.
   */
  private function filterType($data, $type) {
    return array_filter($data, function ($item) use(&$type) {
      return $item['type'] == $type;
    });
  }

  /**
   * Filters out configurations by their matching route.
   */
  private function filterRoute($data, $route) {
    $filtered = array_filter($data, function ($item) use(&$route) {
      // First determine if this is a blanket route or an exact...
      $blanket = substr($item['route'], -1) === '*';

      if ($blanket) {
        // Remove the * character.
        $comparison = substr($item['route'], 0, -1);

        // Get the length of the route.
        $length = strlen($comparison);

        // Compare the beginning.
        return substr($route, 0, $length) === $comparison;
      } else {
        // Exact match...
        return $item['route'] == $route;
      }
    });

    $mapped = array();
    foreach ($filtered as $item) {
      $mapped = array_merge($mapped, $item['scripts_pixels']);
    }

    return $mapped;
  }

  /**
   * Used for retrieving global pixels & scripts as an array.
   * Accessed by $this->api('ThirdParty')->getGlobals() from other addons.
   */
  public function getGlobals($type = false) {
    $data = $this->getConfig('scripts_pixels');
    if (!$data) $data = array();
    if ($type) $data = $this->filterType($data, $type);
    return $data;
  }

  /**
   * Used for retrieving route specific pixels & scripts as an array.
   * Accessed by $this->api('ThirdParty')->getRoute() from other addons.
   */
  public function getRoute($route, $type = false) {
    $data = $this->getConfig('routes');
    if (!$data) $data = array();
    if ($route) $data = $this->filterRoute($data, $route);
    if ($type) $data = $this->filterType($data, $type);
    return $data;
  }

  /**
   * Used for retrieving all pixels & scripts as an array.
   * Accessed by $this->api('ThirdParty')->get() from other addons.
   */
  public function get($route, $type) {
    $globals = $this->getGlobals($type);
    $routes = $this->getRoute($route, $type);
    return array_merge($globals, $routes);
  }
}
