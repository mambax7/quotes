<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * Module: Quotes
 *
 * @category        Module
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GPL 2.0 or later
 */
/**
 *  quotes_search
 *
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array|bool
 */
function quotes_search($queryarray, $andor, $limit, $offset, $userid)
{
    $sql = 'SELECT id, name FROM ' . $GLOBALS['xoopsDB']->prefix('quotes_author') . ' WHERE _online = 1';

    if (0 !== $userid) {
        $sql .= ' AND _submitter=' . (int)$userid;
    }

    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= ' AND ((name LIKE ' % $queryarray[0] % ')';

        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= '(name LIKE ' % $queryarray[0] % ')';
        }
        $sql .= ')';
    }

    $sql    .= ' ORDER BY id DESC';
    $result = $GLOBALS['xoopsDB']->query($sql, $limit, $offset);
    $ret    = [];
    $i      = 0;
    while (false !== ($myrow = $GLOBALS['xoopsDB']->fetchArray($result))) {
        $ret[$i]['image'] = 'assets/images/icons/32/_search.png';
        $ret[$i]['link']  = 'author.php?id=' . $myrow['id'];
        $ret[$i]['title'] = $myrow['name'];
        ++$i;
    }

    return $ret;
}
