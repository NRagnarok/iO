<?php

echo("<body>");

menu(siteURL(), $mysql['prefixe']);

echo($pre_contenu);

contenu();

boite();

echo($post_contenu);

echo($footer_infos);

echo("</body>");
?>