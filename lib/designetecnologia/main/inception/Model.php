<?php
namespace designetecnologia\main\inception;

use \ArrayObject;
use designetecnologia\main\PDODatabase;

/**
 * *****************************************************************************
 ** Usage examples
 * *****************************************************************************
 *
 * //*****New one*****
 * $newModel = new Model();
 * $newModel->text = "New Model Example";
 * //Persists the new one in database
 * $newModel->save();
 * //Update
 * $newModel->text = "Another Model";
 * //Persist all changes at $newModel in database
 * $newModel->update();

 * //*****Retrieve from database*****
 * //New one from database
 * $newModel = (new Model())->find(array("id" => 35));
 * $newModel->text = "Models for EVERYONEEEEEEEE!!!!!!!";
 * //Update with criteria
 * $newModel->update(array('column', 'LIKE', 'value'));
 * //Delete from database
 * $newModel->delete();

 * //New one from extended model
 * $newExtendedModel = new MyModel();
 * //Delete from database with criteria
 * $newExtendedModel->delete(array("text", "LIKE", "Another Model"));

********************************************************************************
 *
 * Describes an basic Model for Letbit Framework
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
class Model extends ArrayObject
{
	/**
	 * Connects to database and defines some things
	 * @throws NoLoggedException
	 */
  public function __construct($id = null)
  {
    parent::__construct(array(), ArrayObject::ARRAY_AS_PROPS);
    if ($id) {
    	try {
    		$command = "SELECT * FROM ".constant(get_class($this)."::TABLENAME")." WHERE id = ?";
    		PDODatabase::getInstance()->beginTransaction();
    		$query = PDODatabase::getInstance()->prepare($command);
    		$query->bindValue(1, $id, PDODatabase::PARAM_INT);
    		$query->execute();
    		$columns = $query->fetch(PDODatabase::FETCH_ASSOC);
    		PDODatabase::getInstance()->commit();
    		if ($columns)
    			foreach ($columns as $key => $val)
    				$this->$key = $val;
    	} catch (Exception $e) {
    		PDODatabase::getInstance()->rollback();
    		$msg = 'Sorry, an error occurred. '.get_class($this).' not found!';
    		throw new NoLoggedException($msg);
    	}
    }
  }

  /**
   * Returns the matched items from the database by @data matchs terms
   *
   * @param array $data
   * @throws NoLoggedException
   * @return array
   */
  public function save()
  {
  	try {
    	$command = "INSERT INTO ".constant(get_class($this)."::TABLENAME")." (";
    	$data = get_class_vars(get_class($this));// total of values for binding
    	$columns = $values = "";
    	PDODatabase::getInstance()->beginTransaction();
    	foreach ($data as $key => $val) {
    		$columns .= $key.", ";
    		$values .= "?, ";
    	}

    	$command .= rtrim($columns, ", ").") values(".rtrim($values, ", ").")";
    	$query = PDODatabase::getInstance()->prepare($command);

    	$i = 1;
	    foreach ($data as $key => $val) {
	    	$query->bindValue($i, $this->$key, PDODatabase::PARAM_STR);
	    	$i++;
	    }
	    PDODatabase::getInstance()->commit();
    	return $query->execute();
  	} catch (Exception $e) {
  		PDODatabase::getInstance()->rollback();
  		throw new NoLoggedException('Sorry, an error occurred. Couldn\'t save this!');
  	}
  }

  /**
   * Returns one matched item from the database by @data matchs terms
   *
   * @param array $data
   * @throws NoLoggedException
   * @return array
   */
  public function find($data = null)
  {
  	return self::search($data)[0];
  }

  /**
   * Returns all matched items from the database by @data matchs terms
   *
   * @param array $data
   * @throws NoLoggedException
   * @return array
   */
  public function findAll($data = null)
  {
  	return self::search($data, true);
  }

  /**
   * Returns the matched items from the database by @data matchs terms
   *
   * @param array $data
   * @throws NoLoggedException
   * @return array
   */
  public function search($data = null, $all = null)
  {
  	try {
  		$command = "SELECT * FROM ".constant(get_class($this)."::TABLENAME")." ";
  		$i = 0;// total of values for binding
  		if ($data != null){
  		$command .= 'WHERE ';
    		foreach ($data as $key => $value) {
    			if (array_key_exists($key, get_class_vars(get_class($this)))) {
    				if ($key != "id") $command .= $key." LIKE CONCAT('%', ?, '%') AND ";
    				else  $command .= $key." = ? AND ";
    				$i++;
    			}
    			else unset($data[$key]);
    		}
  		}
  		$command = rtrim($command, "AND ");
  		$command .= ($all)? "" : " LIMIT 1";
  		$query = PDODatabase::getInstance()->prepare($command);
  		if ($i > 0) {
  			$i = 1;
  			foreach ($data as $value) {
  				$query->bindValue($i, $value, PDODatabase::PARAM_STR);
  				$i++;
  			}
  		}
  		$query->execute();
  		return $query->fetchAll(PDODatabase::FETCH_CLASS, get_class($this));
  	} catch (Exception $e) {
  		throw new NoLoggedException('Sorry, an error occurred. '.get_class($this).' not found!');
  	}
  }

  /**
   * Update at the database by the items where matchs @id
   *
   * @param array $data
   * @throws NoLoggedException
   * @return array
   */
  public function update($params = array(null,null,null))
  {
    try {
    	$command = "UPDATE ".constant(get_class($this)."::TABLENAME")." SET ";
    	$data = get_class_vars(get_class($this));// total of values for binding
    	$key_ = $values = "";

    	foreach ($data as $key => $val) {
    		$values .= $key." = ?, ";
    	}
    	$command .= rtrim($values, ", ")." WHERE ";
    	//checks the criteria for matching
    	if (is_null($params[0]) || strtolower($params[0]) == "id") {
    		$criteria = "id";
    	} else $criteria = "{$params[0]} ";

    	$operation = (!is_null($params[1])) ? $params[1] : "=";// match operation
    	// matching param
    	if (!is_null($params[2])) {
    		$key_ = (is_numeric($params[2])) ? $params[2] : "'".$params[2]."'";
    	} else $key_ = $this->id;
    	PDODatabase::getInstance()->beginTransaction();
    	$command .= $criteria." ".$operation." ".$key_;// joins all
    	$query = PDODatabase::getInstance()->prepare($command);
    	$i = 1;
	    foreach ($data as $key => $val) {
	    	$query->bindValue($i, $this->$key, PDODatabase::PARAM_STR);
	    	$i++;
	    }
	    PDODatabase::getInstance()->commit();
    	return $query->execute();
  	} catch (Exception $e) {
  		PDODatabase::getInstance()->rollback();
  		throw new NoLoggedException('Sorry, an error occurred. Couldn\'t save this!');
  	}
  }

  /**
   * Drop from the database by the items where matchs @id
   *
   * @param array $data
   * @throws NoLoggedException
   * @return array
   */
  public function delete($params = array(null,null,null))
  {
    try {
    	$command = "DELETE FROM ".constant(get_class($this)."::TABLENAME");
    	$data = get_class_vars(get_class($this));// total of values for binding
    	$key_ = $values = "";
    	$command .= rtrim($values, ", ")." WHERE ";
    	//checks the criteria for matching
    	if (is_null($params[0]) || strtolower($params[0]) == "id") {
    		$criteria = "id";
    	} else $criteria = "{$params[0]} ";
    	$operation = (!is_null($params[1])) ? $params[1] : "=";// match operation
    	// matching param
    	if (!is_null($params[2])) {
    		$key_ = (is_numeric($params[2])) ? $params[2] : "'".$params[2]."'";
    	} else $key_ = $this->id;
    	PDODatabase::getInstance()->beginTransaction();
    	$command .= $criteria." ".$operation." ".$key_;// joins all
    	$query = PDODatabase::getInstance()->prepare($command);
    	$i = 1;
	    foreach ($data as $key => $val) {
	    	$query->bindValue($i, $this->$key, PDODatabase::PARAM_STR);
	    	$i++;
	    }
	    PDODatabase::getInstance();
    	return $query->execute();
  	} catch (Exception $e) {
  		PDODatabase::getInstance()->rollback();
  		throw new NoLoggedException('Sorry, an error occurred. Couldn\'t save this!');
  	}
  }
}
