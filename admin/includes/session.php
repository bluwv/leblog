<?php
session_start();

/**
 * À adapter lorsque la connexion db sera effective et la page login fonctionnelle
 * Je stock des infos style timestamp, et autre vérification
 *
 */

if ($page == "login") {
    $_SESSION["user"] = 1769717874;
}
