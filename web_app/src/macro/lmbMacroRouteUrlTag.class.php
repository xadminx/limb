<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
namespace limb\web_app\src\macro;

use limb\macro\src\compiler\lmbMacroTag;

/**
 * @tag route_url
 * @forbid_end_tag
 * @package web_app
 * @version $Id$
 */
class lmbMacroRouteUrlTag extends lmbMacroTag
{
  protected function _generateContent($code)
  {
    $fake_params = $code->generateVar();
    $params = $code->generateVar();
    $code->writePhp("{$params} = array();\n");
    
    if(!$this->has('route'))
      $this->set('route', "");

    if($this->has('params'))
    {
      $code->writePhp("{$fake_params} = limb\core\src\lmbArrayHelper::explode(',',':', {$this->getEscaped('params')});\n");
      $code->writePhp("foreach({$fake_params} as \$key => \$value) {$params}[trim(\$key)] = trim(\$value);\n");
    }

    $skip_controller = $code->generateVar();

    if($this->getBool('skip_controller'))
      $code->writePhp("{$skip_controller} = true;\n");
    else
      $code->writePhp("{$skip_controller} = false;\n");

    $code->writePhp("echo limb\\toolkit\\src\\lmbToolkit::instance()->getRoutesUrl({$params}, {$this->getEscaped('route')}, {$skip_controller});\n");
  }
}


