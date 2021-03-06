<?php
namespace limb\validation\src\rule;

use limb\validation\src\rule\lmbSingleFieldRule;
use limb\core\src\exception\lmbInvalidArgumentException;

class lmbTypeRule extends lmbSingleFieldRule
{
  protected $type;

  function __construct($field_name, $type, $custom_error = '{Field} must contain only integer values')
  {
    $this->type = $type;
    parent::__construct($field_name, $custom_error);
  }

  function check($value)
  {
    try
    {
      lmb_assert_type($value, $this->type);
    }
    catch (lmbInvalidArgumentException $e)
    {
      $this->error($this->custom_error);
    }
  }
}
?>