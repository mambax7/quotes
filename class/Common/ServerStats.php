<?php declare(strict_types=1);

namespace XoopsModules\Quote\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Module: Quote
 *
 * @category        Module
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */
trait ServerStats
{
    /**
     * serverStats()
     *
     * @return string
     */
    public static function getServerStats()
    {
        $moduleDirName      = \basename(\dirname(__DIR__, 2));
        $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
        \xoops_loadLanguage('common', $moduleDirName);
        $html = '';
        //        $sql   = 'SELECT metavalue';
        //        $sql   .= ' FROM ' . $GLOBALS['xoopsDB']->prefix('wfdownloads_meta');
        //        $sql   .= " WHERE metakey='version' LIMIT 1";
        //        $query = $GLOBALS['xoopsDB']->query($sql);
        //        list($meta) = (($GLOBALS['xoopsDB']->isResultSet($query) && ($query instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchRow($query) : false);

        $html .= '<fieldset>';
        $html .= "<legend style='font-weight: bold; color: #900;'>" . \constant('CO_' . $moduleDirNameUpper . '_' . 'IMAGEINFO') . '</legend>';

        $html .= "<div style='padding: 8px;'>";

        //        $html .= '<div>' . constant('CO_' . $moduleDirNameUpper . '_' . 'METAVERSION') . $meta . '</div>';
        //        $html .= "<br>";
        //        $html .= "<br>";

        $html .= '<div>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'SPHPINI') . '</div>';
        $html .= '<ul>';

        if (\function_exists('gd_info')) {
            $html  .= '<li>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'GDLIBSTATUS') . '<span style="color: #008000;">' . \constant('CO_' . $moduleDirNameUpper . '_' . 'GDON') . '</span>';
            $gdlib = \gd_info();
            if (!empty(($gdlib))) {
                $html .= '<li>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'GDLIBVERSION') . '<b>' . $gdlib['GD Version'] . '</b>';
            }
        } else {
            $html .= '<li>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'GDLIBSTATUS') . '<span style="color: #ff0000;">' . \constant('CO_' . $moduleDirNameUpper . '_' . 'GDOFF') . '</span>';
        }

        //    $safemode = ini_get('safe_mode') ? constant('CO_' . $moduleDirNameUpper . '_' . 'ON') . constant('CO_' . $moduleDirNameUpper . '_SAFEMODEPROBLEMS : constant('CO_' . $moduleDirNameUpper . '_' . 'OFF');
        //    $html .= '<li>' . constant('CO_' . $moduleDirNameUpper . '_SAFEMODESTATUS . $safemode;

        //    $registerglobals = (!ini_get('register_globals')) ? "<span style=\"color: #008000;\">" . constant('CO_' . $moduleDirNameUpper . '_' . 'OFF') . '</span>' : "<span style=\"color: #ff0000;\">" . constant('CO_' . $moduleDirNameUpper . '_' . 'ON') . '</span>';
        //    $html .= '<li>' . constant('CO_' . $moduleDirNameUpper . '_REGISTERGLOBALS . $registerglobals;

        $downloads = \ini_get('file_uploads') ? '<span style="color: #008000;">' . \constant('CO_' . $moduleDirNameUpper . '_' . 'ON') . '</span>' : '<span style="color: #ff0000;">' . \constant('CO_' . $moduleDirNameUpper . '_' . 'OFF') . '</span>';
        $html      .= '<li>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'SERVERUPLOADSTATUS') . $downloads;

        $html .= '<li>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'MAXUPLOADSIZE') . ' <b><span style="color: #0000ff;">' . \ini_get('upload_max_filesize') . '</span></b>';
        $html .= '<li>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'MAXPOSTSIZE') . ' <b><span style="color: #0000ff;">' . \ini_get('post_max_size') . '</span></b>';
        $html .= '<li>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'MEMORYLIMIT') . ' <b><span style="color: #0000ff;">' . \ini_get('memory_limit') . '</span></b>';
        $html .= '</ul>';
        $html .= '<ul>';
        $html .= '<li>' . \constant('CO_' . $moduleDirNameUpper . '_' . 'SERVERPATH') . ' <b>' . XOOPS_ROOT_PATH . '</b>';
        $html .= '</ul>';
        $html .= '<br>';
        $html .= \constant('CO_' . $moduleDirNameUpper . '_' . 'UPLOADPATHDSC') . '';
        $html .= '</div>';
        $html .= '</fieldset><br>';

        return $html;
    }
}
