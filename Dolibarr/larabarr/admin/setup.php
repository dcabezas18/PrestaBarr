<?php
/* Copyright (C) 20018-2018 Daniel Cabezas <dcabezas@madvape.es>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    htdocs/Larabarr/admin/setup.php
 * \ingroup Larabarr
 * \brief   Larabarr setup page.
 */

set_time_limit(0);
// Load Dolibarr environment
$res=0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (! $res && ! empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res=@include($_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php");
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp=empty($_SERVER['SCRIPT_FILENAME'])?'':$_SERVER['SCRIPT_FILENAME'];$tmp2=realpath(__FILE__); $i=strlen($tmp)-1; $j=strlen($tmp2)-1;
while($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i]==$tmp2[$j]) { $i--; $j--; }
if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/main.inc.php")) $res=@include(substr($tmp, 0, ($i+1))."/main.inc.php");
if (! $res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php")) $res=@include(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php");
// Try main.inc.php using relative path
if (! $res && file_exists("../../main.inc.php")) $res=@include("../../main.inc.php");
if (! $res && file_exists("../../../main.inc.php")) $res=@include("../../../main.inc.php");
if (! $res) die("Include of main fails");

global $langs, $user;

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";

// Translations
$langs->loadLangs(array("admin", "Larabarr@Larabarr"));

// Access control
if (! $user->admin) accessforbidden();

// Parameters
$action = GETPOST('action', 'alpha');
$backtopage = GETPOST('backtopage', 'alpha');

/*
 * View
 */

$page_name = "LarabarrSetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="'.($backtopage?$backtopage:DOL_URL_ROOT.'/admin/modules.php?restore_lastsearch_values=1').'">'.$langs->trans("BackToModuleList").'</a>';

print load_fiche_titre($langs->trans($page_name));

echo 'Módulo para conectar Dolibarr con Prestashop mediante Laravel.<br>';

print '<table class="noborder" width="100%">';
print '<tr class="liste_titre"><td class="titlefield">Acción</td><td></td></tr>';

print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
print '<input type="hidden" name="action" value="update">';

print '<td> Laravel URL </td>';
print '<td><input type="text" name="larabarr_url" class="input-large" value="'.(! empty($conf->global->LARABARR_URL)?$conf->global->LARABARR_URL:'').'" >';
print '</tr><tr>';
print '<td> Laravel KEY </td>';
print '<td><input type="text" name="larabarr_key" class="input-large" value="'.(! empty($conf->global->LARABARR_KEY)?$conf->global->LARABARR_KEY:'').'" >';
print '</tr><tr>';
print '<td><input class="button" type="submit" value="'.$langs->trans("Save").'"></td></tr>';
print '</form>';
print '</table>';

if ($action == 'update') {
    dolibarr_set_const($db, 'LARABARR_URL', GETPOST('larabarr_url', 'alpha'), 'chaine', 1,'Laravel url', 1);
    dolibarr_set_const($db, 'LARABARR_KEY', GETPOST('larabarr_key', 'alpha'), 'chaine', 1,'Laravel api key', 1);

}

// Page end
dol_fiche_end();

llxFooter();
$db->close();