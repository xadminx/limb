<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
namespace limb\validation\src\rule;

use limb\i18n\src\datetime\lmbLocaleDateTime;
use limb\toolkit\src\lmbToolkit;

/**
 * class lmbLocaleDateRule.
 *
 * @package validation
 * @version $Id$
 */
class lmbLocaleDateRule extends lmbSingleFieldRule
{
  protected $locale;

  function __construct($field_name, $locale = null)
  {
    $this->locale = $locale;
    parent::__construct($field_name);
  }

  function check($value)
  {
    $toolkit = lmbToolkit::instance();

    if(!$this->locale)
      $this->locale = $toolkit->getLocaleObject();

    if(!lmbLocaleDateTime::isLocalStringValid($this->locale, $value))
      $this->error(lmb_i18n('{Field} must have a valid date format', 'validation'));
  }
}


