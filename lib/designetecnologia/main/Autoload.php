<?php

use designetecnologia\main\exception\LoggedException;
/**
 * Describes an Autoload class for Letbit Framework
 *
 * For PHP versions 5.4+
 *
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.1
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */
class Autoload
{
  protected $ext;
  protected $prefix;
  protected $sufix;

  /**
   * Defines the path for file
   * @param string $path
   */
  public function setPath($path)
  {
    set_include_path($path);
  }

  /**
   * Defines extension of file
   * @param string $ext
   */
  public function setExt($ext)
  {
    $this->ext = '.'.$ext;
  }

  /**
   * Defines a prefix for filename
   * @param string $prefix
   */
  public function setPrefix($prefix)
  {
    $this->prefix = $prefix;
  }

  /**
   * Defines a sufix for filename
   * @param string $sufix
   */
  public function setSufix($sufix)
  {
    $this->sufix = $sufix;
  }

  /**
   * Build the path for file required with path\to\[prefix]filename[sufix].extension
   * @param string $className Class to load
   * @return string the path to the file
   */
  protected function setFilename($className)
  {
    $className = ltrim($className, "\\");
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, "\\")) {
      $namespace = substr($className, 0, $lastNsPos);
      $className = substr($className, $lastNsPos + 1);
      $className = $this->prefix.$className.$this->sufix;
      $fileName  = str_replace("\\", DS, $namespace).DS;
    }
    $fileName .= str_replace('_', DS, $className).$this->ext;
    return $fileName;
  }

  /**
   * Loads files from Library folder
   * @param string $className class to load
   */
  public function loadCore($className)
  {
    $fileName = $this->setFilename($className);
    $fileName = get_include_path().DS.'lib'.DS.$fileName;

    if (is_readable($fileName)) {
      include $fileName;
    }
  }

  /**
   * Loads files from App folder
   * @param string $className class to load
   */
  public function loadApp($className)
  {
    $fileName = $this->setFilename($className);
    $fileName = get_include_path().DS.'app'.DS.$fileName;

    if (is_readable($fileName)) {
      include $fileName;
    }

  }

  /**
   * Load files from Modules folder
   * @param string $className class to load
   */
  public function loadModules($className)
  {
    $fileName = $this->setFilename($className);
    $fileName = get_include_path().DS.'app'.DS.'modules'.DS.$fileName;

    if (is_readable($fileName)) {
      include $fileName;
    }
  }

  /**
   * Loads others files for general purposes
   * @param string $className class to load
   */
  public function load($className)
  {
    $fileName = $this->setFilename($className);
    $fileName = get_include_path().DS.$fileName;

    if (is_readable($fileName)) {
      include $fileName;
    } else {
      $msg = 'Sorry, the requested file '.$fileName.' could not be found!';
      throw new LoggedException($msg);
      echo $msg;
      exit;
    }
  }
}
