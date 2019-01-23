<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class HTML_Footer
{
    public static function htmlFOOTER()
    {
        echo '
            </body>
            <footer class="container-fluid text-center">
                <div class="row">
                    <div class="col-sm-4">
                        <h3>Contact Us</h3>
                        <br>
                        <h4>7 Bananas Way, Melon Bread Park, BC M30 W3H</h4>
                    </div>
                    <div class="col-sm-4">
                        <h3>Connect</h3>
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-google"></a>
                        <a href="#" class="fa fa-linkedin"></a>
                        <a href="#" class="fa fa-youtube"></a>
                    </div>
                    <div class="col-sm-4">
                        <img src="images/bc-gm.png" class="icon">
                    </div>
                </div>
            </footer>
            </html>';
    }
}

?>