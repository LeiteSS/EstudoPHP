<ifModule mod_rewrite.c>
    
    Options +FollowSymLinks

    RewriteEngine on

    <!--Envia um request via index.php-->
    RewriteCond %{REQUEST_FILENAME} !-f

    RewriteCond %{REQUEST_FILENAME} !-d

    RewriteRule ^(.*)$ index.php/$1 [L]

</ifModule>

<?php
    require "framework/core/Framework.class.php";
    Framework::run();
?>