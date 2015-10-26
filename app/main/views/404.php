<?php
/**
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

 //we can personalize a title attribute for each single page,
 // else a default, from definitions.php file, will be displayed
 $this->title = 'ERROR Page :: ' . TITLE;

 //we add this css source to our header, showing we can use any resources for individual pages
 $this->headers = '<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">';

 //use PHP to write html dinamically
 //including default header...
 $this->getStartPage();

 //...show default messages outside of div container (should be inside? change the order)
 $this->flashError();
 echo '<div id="container">';

 //just to show how we can dinamically create content
 //shows a modal pop up with this content inside
 $modalContent  = '<h1>Website is under development!</h1>';
 $modalContent .= '<hr/>';
 $modalContent .= '<p>Our apologies for the temporary inconvenience. </p>';
 //setModal params are: content, id attribute, class attribute, autoshow on load?
 //see the method definition for more info
 $this->setModal($modalContent, 'not-ready', 'medium', true);
?>

 <!-- or just write the ´old but gold´ html embeded -->
 <div class="row panel">
   <h1>ERROR 404 Page!</h1>
   <section class="small-10">
     <p>Params:</p>
     <p><?php  echo var_dump($this->params); ?></p>
   </section>
 </div>
 <footer>
   <p>
     <a href="https://github.com/elionaimc/letbit-for-php" target="_blank">
       Powered by LetBit! for PHP Framework
     </a>
   </p>
 </footer>
 </div><!-- end of container div -->

<?php
 $this->js = "$(document).ready(function(){

});";
$this->getEndPage($this->js);
