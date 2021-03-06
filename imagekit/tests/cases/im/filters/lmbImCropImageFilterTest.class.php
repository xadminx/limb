<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
lmb_require('limb/imagekit/src/im/filters/lmbImCropImageFilter.class.php');
lmb_require('limb/imagekit/tests/cases/filters/lmbBaseCropImageFilterTest.class.php');

/**
 * @package imagekit
 * @version $Id: lmbImCropImageFilterTest.class.php 7486 2009-01-26 19:13:20Z pachanga $
 */
class lmbImCropImageFilterTest extends lmbBaseCropImageFilterTest
{
  protected $driver = 'im';
}