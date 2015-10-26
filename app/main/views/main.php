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

 $this->headers = '<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">';
$this->getStartPage();
$this->flashError();
echo '<div id="container">';

$modalContent  = '<h1>Website is under development!</h1>';
$modalContent .= '<hr/>';
$modalContent .= '<p>Our apologies for the temporary inconvenience. </p>';
$this->setModal($modalContent, 'not-ready', 'medium', true);

echo '  <footer>';
echo '    <p><a href="https://github.com/elionaimc/letbit-for-php" target="_blank">';
echo '    Powered by letbit-for-php Framework!</a></p>';
echo '  </footer>';
echo '</div>';
$this->js = "$(document).ready(function(){

});";
$this->getEndPage($this->js);
