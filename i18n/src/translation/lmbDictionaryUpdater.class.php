<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
namespace limb\i18n\src\translation;

use limb\i18n\src\translation\lmbPHPDictionaryExtractor;
use limb\i18n\src\translation\lmbFsDictionaryExtractor;
use limb\i18n\src\translation\lmbI18NDictionary;
use limb\i18n\src\translation\lmbQtDictionaryBackend;
use limb\cli\src\lmbCliResponse;
use limb\fs\src\lmbFsRecursiveIterator;
use limb\fs\src\lmbFs;

/**
 * class lmbDictionaryUpdater.
 *
 * @package i18n
 * @version $Id: lmbDictionaryUpdater.class.php 7686 2009-03-04 19:57:12Z korchasa $
 */
class lmbDictionaryUpdater
{
  protected $response;

  function __construct($backend, $response = null)
  {
    $this->backend = $backend;
    $this->response = $response ? $response : new lmbCliResponse();
  }

  function dryrun($source_dir)
  {
    $this->response->write("Dry-running in '$source_dir'...\n");

    $this->updateTranslations($source_dir, true);
  }

  function updateTranslations($source_dir, $dry_run = false)
  {
    $loader = new lmbFsDictionaryExtractor();
    $loader->registerFileParser('.php', new lmbPHPDictionaryExtractor());
    $loader->registerFileParser('.phtml', new lmbPHPDictionaryExtractor());

    $dicts = array();
    $iterator = new lmbFsRecursiveIterator($source_dir);

    $this->response->write("======== Extracting translations from source ========\n");
    $loader->traverse($iterator, $dicts, $this->response);

    if(!$translations = $this->backend->loadAll())
    {
      $this->response->write("======== No existing translations found!(create them first) ========\n");
      return;
    }

    $this->response->write("======== Updating translations ========\n");

    foreach($translations as $locale => $domains)
    {
      foreach($domains as $domain => $old_dict)
      {
        if(isset($dicts[$domain]))
        {
          $this->response->write($this->backend->info($locale, $domain) . "...");

          $new_dict = $dicts[$domain]->merge($old_dict);
          if(!$dry_run)
          {
            $this->backend->save($locale, $domain, $new_dict);
            $this->response->write("updated\n");
          }
          else
            $this->response->write("skipped(dry-run)\n");
        }
      }
    }
  }
}

