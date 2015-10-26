<?php
namespace designetecnologia\main\inception;

/**
 * Describes an basic View for Letbit Framework
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
class View
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
