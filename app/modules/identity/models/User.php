<?php
namespace app\modules\identity\models;

use embits\main\inception\Model;

/**
 * Describes User model for Identity module
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
class User extends Model
{
	const TABLENAME = "user";

	public $id;
	public $username;
	public $password;
	public $last_login;
	public $status;
}
