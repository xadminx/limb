<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
lmb_require('limb/imagekit/src/gd/filters/lmbGdCropImageFilter.class.php');
lmb_require('limb/imagekit/tests/cases/filters/lmbBaseCropImageFilterTest.class.php');

/**
 * @package imagekit
 * @version $Id: lmbGdCropImageFilterTest.class.php 8065 2010-01-20 04:18:19Z korchasa $
 */
class lmbGdCropImageFilterTest extends lmbBaseCropImageFilterTest
{
  protected $driver = 'gd';
}