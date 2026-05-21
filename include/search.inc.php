<?php declare(strict_types=1);

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
 * @param mixed $queryarray
 * @param mixed $andor
 * @param mixed $limit
 * @param mixed $offset
 * @param mixed $userid
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @category        Module
 */
/**
 *  quote_search
 *
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array|bool
 */
function quote_search($queryarray, $andor, $limit, $offset, $userid)
{
    $andor = \strtoupper((string)$andor);
    $andor = \in_array($andor, ['AND', 'OR'], true) ? $andor : 'OR';

    $sql = 'SELECT id, name FROM ' . $GLOBALS['xoopsDB']->prefix('quote_author') . ' WHERE online = 1';

    if (0 !== $userid) {
        $sql .= ' AND _submitter=' . (int)$userid;
    }

    if (is_array($queryarray) && $count = count($queryarray)) {
        $term = $GLOBALS['xoopsDB']->quote('%' . (string)$queryarray[0] . '%');
        $sql .= ' AND ((name LIKE ' . $term . ')';

        for ($i = 1; $i < $count; ++$i) {
            $term = $GLOBALS['xoopsDB']->quote('%' . (string)$queryarray[$i] . '%');
            $sql .= " $andor ";
            $sql .= '(name LIKE ' . $term . ')';
        }
        $sql .= ')';
    }

    $sql    .= ' ORDER BY id DESC';
    $result = $GLOBALS['xoopsDB']->query($sql, $limit, $offset);
    $ret    = [];
    $i      = 0;
    if (!$GLOBALS['xoopsDB']->isResultSet($result) || !($result instanceof \mysqli_result)) {
        return $ret;
    }
    while (false !== ($myrow = (($GLOBALS['xoopsDB']->isResultSet($result) && ($result instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchArray($result) : false))) {
        $ret[$i]['image'] = 'assets/images/icons/32/_search.png';
        $ret[$i]['link']  = 'author.php?id=' . $myrow['id'];
        $ret[$i]['title'] = $myrow['name'];
        ++$i;
    }

    return $ret;
}
