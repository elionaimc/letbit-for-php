<?php
namespace psr\log;

use designetecnologia\main\PDODatabase;

class Logger implements LoggerInterface
{
  private $level;

  public function __construct()
  {
    // Nothing to do here
  }

  public function emergency($message, array $context = array())
  {
    $this->log(LogLevel::EMERGENCY, $message, $context);
  }

  public function alert($message, array $context = array())
  {
    $this->log(LogLevel::ALERT, $message, $context);
  }

  public function critical($message, array $context = array())
  {
    $this->log(LogLevel::CRITICAL, $message, $context);
  }

  public function error($message, array $context = array())
  {
    $this->log(LogLevel::ERROR, $message, $context);
  }

  public static function warning($message, array $context = array())
  {
    $this->log(LogLevel::WARNING, $message, $context);
  }

  public function notice($message, array $context = array())
  {
    $this->log(LogLevel::NOTICE, $message, $context);
  }

  public function info($message, array $context = array())
  {
    $this->log(LogLevel::CRITICAL, $message, $context);
  }

  public function debug($message, array $context = array())
  {
    $this->log(LogLevel::DEBUG, $message, $context);
  }

  public static function log($level, $message, array $context = array())
  {
    $replace = array();
    foreach ($context as $key => $val) {
      $replace['{' . $key . '}'] = $val;
    }
    $msg = strtr($message, $replace);

    switch ($level) {
      case 'emergency':;
      case 'alert':
        echo 'ALERT! Any issue ocurred and may compromise the system, contact the website admin!';
        break;
      case 'critical':
        echo 'Critical situation ocurred, Not the first time you see this message? contact the website admin!';
        break;
      case 'error':
        echo 'Unknow error ocurred, please try again later or contact the website admin!';
        break;
      case 'debug':
        echo 'DEBUG started: see at '.DBNAME.'.log table this status detailed';
        break;
      default:
        $_SESSION['logger'][] = $message;
        break;
    }

    try {
      $db = PDODatabase::getInstance();
      $log = "INSERT INTO log SET message = ?, level = ?, request_ip = ?, request_uri = ?";
      $query = $db->prepare($log);
      $query->bindParam(1, $msg);
      $query->bindParam(2, $level);
      $query->bindParam(3, $_SERVER['REMOTE_ADDR']);
      $query->bindParam(4, $_SERVER['REQUEST_URI']);
      $query->execute();
    } catch (Exception $e) {
      echo 'ERROR occurred when trying write a '.$level.' log.\n';
      echo 'Lost log message was ´'.$msg.'´\n';
      echo 'Contact the website admin or try again later!\n';
    }
  }
}
