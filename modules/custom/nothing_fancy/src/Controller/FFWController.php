<?php

namespace Drupal\nothing_fancy\Controller;


use Symfony\Component\HttpFoundation\Request;

class FFWController
{
  public function hello(Request $request)
  {
    \Drupal::service('page_cache_kill_switch')->trigger();

    $count = $this->getCount($request);

    $view = [
      '#theme' => 'hello',
      '#count' => $count,
      '#hello_var' => ''
    ];

    if ($count < 2) {
      $view['#hello_var'] = 'Hello';
    } elseif ($count <= 5) {
      $view['#hello_var'] = 'Hello again';
    }

    return $view;
  }


  public function manage(Request $request)
  {
    $postData = $request->get('pattern');
    \Drupal::service('page_cache_kill_switch')->trigger();

    $count = $this->getCount($request);

    $view = [
      '#theme' => 'hello',
      '#count' => $count,
      '#hello_var' => 'Hello '.$postData
    ];
    return $view;
  }

  /**
   * @param  Request  $request
   * @return int
   */
  protected function getCount(Request $request): int
  {
    $session = $request->getSession();

    if ($request->get('reset') == 1) {
      $session->remove('nothing_fancy.counter');
    }


    $count = $session->get('nothing_fancy.counter', 0) + 1;
    $session->set('nothing_fancy.counter', $count);
    return $count;
  }
}
