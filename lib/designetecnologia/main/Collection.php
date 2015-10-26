<?php
namespace designetecnologia\main;

use designetecnologia\main\exception\KeyUsedException;
use designetecnologia\main\exception\KeyInvalidException;

/**
 * Describes an Collection class for Letbit Framework
 *
 * For PHP versions 5.4+
 *
 * @abstract
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.1
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */
class Collection
{
  private $items = array();

  /**
   * @param object $obj
   * @param string $key
   * @throws KeyUsedException
   */
  public function addItem($obj, $key = null)
  {
    if ($key == null) {
      $this->items[] = $obj;
    } else {
      if (isset($this->items[$key])) {
        throw new KeyUsedException("Key $key already in use.");
      } else {
        $this->items[$key] = $obj;
      }
    }
  }

  /**
   * @param string $key
   * @throws KeyInvalidException
   */
  public function deleteItem($key)
  {
    if (isset($this->items[$key])) {
      unset($this->items[$key]);
    } else {
      throw new KeyInvalidException("Invalid key $key.");
    }
  }

  /**
   * @param string $key
   * @throws KeyInvalidException
   * @return object
   */
  public function getItem($key)
  {
    if (isset($this->items[$key])) {
      return $this->items[$key];
    } else {
      throw new KeyInvalidException("Invalid key $key.");
    }
  }

  /**
   * @return number
   */
  public function length() {
    return count($this->items);
  }

  /**
   * @param string $key
   */
  public function keyExists($key) {
    return isset($this->items[$key]);
  }
}
