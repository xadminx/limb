<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
use limb\view\src\wact\lmbWactTemplateConfig;
use limb\wact\src\WactTemplate;

/**
 * class lmbWactTemplate.
 *
 * @package view
 * @version $Id$
 */
class lmbWactTemplate extends WactTemplate
{
  function __construct($template_path, $cache_dir = '')
  {
    if(!$cache_dir && defined('LIMB_VAR_DIR'))
      $cache_dir = LIMB_VAR_DIR . '/compiled/';

    $config = new lmbWactTemplateConfig($cache_dir);
    $locator = lmbToolkit :: instance()->getWactLocator();
    parent :: __construct($template_path, $config, $locator);
  }
}

