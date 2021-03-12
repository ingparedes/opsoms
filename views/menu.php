<?php

namespace PHPMaker2021\simexamerica;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(53, "mi_archivos_doc", $MenuLanguage->MenuPhrase("53", "MenuText"), $MenuRelativePath . "ArchivosDocList", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}archivos_doc'), false, false, "", "", false);
$sideMenu->addMenuItem(54, "mi_permisos_doc", $MenuLanguage->MenuPhrase("54", "MenuText"), $MenuRelativePath . "PermisosDocList?cmd=resetall", -1, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}permisos_doc'), false, false, "", "", false);
$sideMenu->addMenuItem(18, "mi_tipo", $MenuLanguage->MenuPhrase("18", "MenuText"), $MenuRelativePath . "TipoList", 36, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}tipo'), false, false, "cil-bug", "", false);
$sideMenu->addMenuItem(17, "mi_incidente", $MenuLanguage->MenuPhrase("17", "MenuText"), $MenuRelativePath . "IncidenteList", 36, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}incidente'), false, false, "cil-rain", "", false);
$sideMenu->addMenuItem(10, "mi_paisgmt", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "PaisgmtList", 36, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}paisgmt'), false, false, "cil-globe-alt", "", false);
$sideMenu->addMenuItem(12, "mi_email2", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "Email2List", 11, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}email'), false, false, "cil-envelope-open", "", false);
$sideMenu->addMenuItem(14, "mi_mensagens", $MenuLanguage->MenuPhrase("14", "MenuText"), $MenuRelativePath . "MensagensList", 11, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}mensagens'), false, false, "cil-eyedropper", "", false);
$sideMenu->addMenuItem(33, "mci_usuarios", $MenuLanguage->MenuPhrase("33", "MenuText"), "", -1, "", true, false, true, "cil-user", "", false);
$sideMenu->addMenuItem(13, "mi_users", $MenuLanguage->MenuPhrase("13", "MenuText"), $MenuRelativePath . "UsersList", 33, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}users'), false, false, "cil-people", "", false);
$sideMenu->addMenuItem(48, "mi_grupos", $MenuLanguage->MenuPhrase("48", "MenuText"), $MenuRelativePath . "Grupos", 33, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}grupos.php'), false, false, "", "", false);
$sideMenu->addMenuItem(20, "mi_userlevels", $MenuLanguage->MenuPhrase("20", "MenuText"), $MenuRelativePath . "UserlevelsList", 33, "", AllowListMenu('{E72B71B0-0142-48A2-8D2C-143364E37B13}userlevels'), false, false, "cil-layers", "", false);
echo $sideMenu->toScript();
