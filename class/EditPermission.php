<?php declare(strict_types=1);

namespace XoopsModules\Quotes;

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
 * @copyright       2000-2026 XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

/**
 * Pure ownership/permission decision for front-end editing.
 *
 * No XOOPS dependencies so it is unit-testable. Admins edit everything; everyone else may edit
 * only a row they own (uid > 0 and matches) and only when granted the "edit own" right.
 */
final class EditPermission
{
    public static function canEdit(bool $isAdmin, int $currentUid, int $rowUid, bool $hasEditOwnRight): bool
    {
        if ($isAdmin) {
            return true;
        }

        return $currentUid > 0 && $currentUid === $rowUid && $hasEditOwnRight;
    }
}
