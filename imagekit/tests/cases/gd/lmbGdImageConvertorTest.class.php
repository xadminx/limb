<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
lmb_require('limb/imagekit/tests/cases/lmbBaseImageConvertorTest.class.php');

class lmbGdBaseImageConvertorTest extends lmbBaseImageConvertorTest
{
  protected $driver = 'gd';
}