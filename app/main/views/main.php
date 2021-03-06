<?php
/**
 * For PHP versions 5.4+
 *
 * Every single page is a instance of the Layout object, so you can access
 * all properties of layout model with $this-> clause
 *
 * @category   Framework
 * @author     Elionai Moura <eli.embits@gmail.com>
 * @copyright  2015 Design e Tecnologia by Elionai Moura <http://designetecnologia.com.br>
 * @license    The MIT license <https://opensource.org/licenses/MIT>
 * @version    0.2
 * @link       https://github.com/elionaimc/letbit-for-php
 *
 */

 //we can personalize a title attribute for each single page,
 // else a default, from definitions.php file, will be displayed
 $this->title = 'Initial Page :: ' . TITLE;

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

 //include layout partials as simple
 include_once 'footer.html';
?>

 <!-- or just write the ´old but gold´ html embeded -->
 </div><!-- end of container div -->

<?php
 $this->js = "$(document).ready(function(){

});";
$this->getEndPage($this->js);
