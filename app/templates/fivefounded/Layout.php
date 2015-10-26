<?php
namespace app\templates\fivefounded;

use designetecnologia\main\inception\Model;

/**
 * Describes the main model for views manning objects of FiveFounded template for Letbit Framework
 *
 * For PHP versions 5.4+
 *
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.2
 * @link       https://github.com/elionaimc/letbit-for-php
 * @uses Foundation Framework v5 (http://foundation.zurb.com/)
 *
 */
class Layout extends Model
{
  public $author;
  public $category;
  public $description;
  public $keywords;
  public $lang;
  public $dir;

  public function __construct()
  {
    $this->dir = URL_BASE."/app/templates/fivefounded";
    $this->description = DESCRIPTION;
    $this->keywords = KEYWORDS;
    $this->category = CATEGORY;
    $this->lang = LANGUAGE;
    $this->author = AUTHOR;
    parent::__construct();
  }

  /**
   * Prints a default alert message (colored div)
   * @param string $message content for alert div
   * @param string $type content for the 'class' atribute, can be blank (default),  or
   * 'info', 'success', 'warning', 'alert', 'round', 'radius'
   * or any combo of these, e.g. 'success radius'
   */
  public function flash($message, $type = null)
  {
    $class = ($type) ? $type : '';
    echo '<div data-alert class="alert-box '.$class.'"> ';
    echo $message.' <a href="#" class="close">&times;</a></div>';
  }

  /**
   * @param unknown $name the group name for the radio
   * @param unknown $label a label for the radio
   * @param string $value content for the 'value' attribute
   * @param string $type content for the 'class' atribute
   * @param string $identity content for the 'id' atribute
   */
  public function radio($name, $label, $value = null, $type = null, $identity = null)
  {
    $class = ($type) ? $type : '';
    $id = ($identity) ? $identity : 'radio';
    $vle = ($value) ? 'value="'.$value.'"' : '';
    $nme = ($name) ? 'name="'.$name.'"' : '';
    echo '<input type="radio"
      '.$nme.' '.$vle.' id="'.$id.'" class="'.$class.'"><label
      for="'.$name.'">'.$label.'</label>';
  }

  /**
   * Prints all errors stored at this session and cleans $_SESSION['error'] variable
   * @param string $type content for the 'class' atribute of alert div, can be blank (default),
   * 'info', 'success', 'warning', 'alert', 'round', 'radius'
   * or any combo of these, e.g. 'warning radius'
   */
  public function flashError($type = null)
  {
     $class = ($type) ? $type : 'alert';
     if(isset($_SESSION['error'])){
       if (is_array($_SESSION['error'])) {
         foreach ($_SESSION['error'] as $error) {
           $this->flash($error, $class);
           $error = null;
         }
       } else {
         $this->flash($_SESSION['error'], $class);
       }
       unset($_SESSION['error']);
    }
  }

  /**
   * Defines a Reveal object, the modal plugin written with jQuery of Foundation Framework
   * @param string $content the content of modal div
   * @param string $identity content for the 'id' atribute
   * @param string $type content for the 'class' atribute, can be blank,
   * 'tiny', 'small', 'medium', 'large', 'xlarge'
   * these values changes the width to 30%, 40%, 60%, 70% e 95% respectively
   */
  public function setModal($content, $identity = null, $type = null, $autoload = false)
  {
    $class = ($type) ? $type : '';
    $id = ($identity) ? $identity : 'modal';
    if ($autoload) {
      $_SESSION['ff_modal'] = $id;
    }
    echo '<div class="reveal-modal '
      .$class.'" data-reveal id="'
      . $id.'"> '
      .$content.' <a href="#" class="close-reveal-modal">&times;</a></div>';
  }

  /**
   * Writes a link to call a related modal
   * @param string $content text who will inside <a> here </a>
   * @param string $identity content for the 'id' atribute, needs be equal of modal id
   * @param string $type content for the 'class' atribute, can be blank,
   * 'button', 'alert-box', 'info',
   * 'success', 'warning', 'round', 'radius'
   * or any combo of these, e.g. 'button info radius'
   */
  public function getModal($content, $identity = null, $type = null, $ajax = null)
  {
    $url = ($ajax) ? ' href="'.$ajax.'" data-reveal-ajax="true"' : ' href="#" data-reveal';
    $id = ($identity) ? $identity : "modal";
    $class = ($type) ? $type : '';
    return '<a class="'.$class.'" data-reveal-id="'.$id.'" '.$url.'>'.$content.'</a>';
  }

  /**
   * Includes the file with a common top of page
   * @param string $headers aditional headers for especific page, like scripts urls, css files etc
   */
  public function getStartPage()
  {
    if (!isset($this->title) || $this->title == '') {
      $this->title = TITLE;
    }
    $this->startPage =
<<<HTML
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="{$this->lang}" > <![endif]-->
<!--[if IE 10]><html class="ie10" lang="{$this->lang}" > <![endif]-->
<html lang="{$this->lang}" class="no-js">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{$this->description}">
    <meta name="keywords" content="{$this->keywords}">
    <meta name="category" content="{$this->category}">
    <meta name="author" content="{$this->author}">
    <title>{$this->title}</title>
    <link rel="author" type="text/plain" href="/humans.txt" />
    <link href="{$this->dir}/public/css/foundation.min.css" rel="stylesheet" />
    {$this->headers}
    <link href="/app/public/css/app.css" rel="stylesheet" />
    <script src="{$this->dir}/public/js/vendor/modernizr.js"></script>
  </head>
HTML;
    echo $this->startPage;
    include dirname(__FILE__).DS.'views'.DS.'startPage.php';
  }

  /**
   * * Includes the file with a common bottom of page
   * @param string $script aditional script for especific page,
   * can be scripts urls or plain with <script> tags
   * e.g., if you want to use Google Charts Api
   * '<script src="https://www.google.com/jsapi"></script>'
   */
  public function getEndPage($script = null)
  {
    $this->js = ($script != null)? $script."\n" : '';
    if(isset($_SESSION['ff_modal'])){
      if (!is_array($_SESSION['ff_modal'])){
        $this->js .= '$("#'.$_SESSION['ff_modal'].'").foundation(\'reveal\', \'open\');';
        $_SESSION['ff_modal'] = null;
      }
      unset($_SESSION['ff_modal']);
    }
    $this->endPage =
<<<HTML
  <!-- Fim container -->
  <script src="{$this->dir}/public/js/vendor/jquery.js"></script>
  <script src="{$this->dir}/public/js/foundation.min.js"></script>
  <script>
  $(document).foundation();
  {$this->js}
  </script>
  <script src="/app/public/js/app.js"></script>
  </body>
</html>
HTML;
     echo $this->endPage;
  }

  /**
   * Loads the view file informed at param $file
   *
   * @param string $file relative URI of file will be loaded, e.g. 'views/index.php'
   * @param array $params associative array of URL parameters
   * @return string
   */
  public function render($file, $params = null)
  {
    $this->params = $params;
    ob_start();
    include $file;
    return ob_get_flush();
  }
}
