<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
namespace limb\web_app\src\request;

use limb\web_app\src\request\lmbRequestDispatcherInterface;

/**
 * class lmbCompositeRequestDispatcher.
 *
 * @package web_app
 * @version $Id: lmbCompositeRequestDispatcher.class.php 7486 2009-01-26 19:13:20Z pachanga $
 */
class lmbCompositeRequestDispatcher implements lmbRequestDispatcherInterface
{
  protected $dispatchers;

  function dispatch($request)
  {
    foreach($this->dispatchers as $dispatcher)
    {
      $result = $dispatcher->dispatch($request);
      if(isset($result['controller']))
        return $result;
    }

    return array();
  }

  function addDispatcher($dispatcher)
  {
    $this->dispatchers[] = $dispatcher;
  }
}


