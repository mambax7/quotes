<?php declare(strict_types=1);

namespace Tests\Unit\XoopsModules\Quotes;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use XoopsModules\Quotes\EditPermission;

#[CoversClass(EditPermission::class)]
final class EditPermissionTest extends TestCase
{
    public function testAdminCanEditAnything(): void
    {
        // admin, not owner, no right -> still true
        self::assertTrue(EditPermission::canEdit(true, 5, 9, false));
    }

    public function testOwnerWithRightCanEdit(): void
    {
        self::assertTrue(EditPermission::canEdit(false, 5, 5, true));
    }

    public function testOwnerWithoutRightDenied(): void
    {
        self::assertFalse(EditPermission::canEdit(false, 5, 5, false));
    }

    public function testNonOwnerWithRightDenied(): void
    {
        self::assertFalse(EditPermission::canEdit(false, 5, 9, true));
    }

    public function testAnonymousDenied(): void
    {
        // uid 0 never owns, even a legacy row whose uid is also 0
        self::assertFalse(EditPermission::canEdit(false, 0, 0, true));
    }

    public function testLegacyRowOnlyAdmin(): void
    {
        self::assertFalse(EditPermission::canEdit(false, 5, 0, true)); // user vs legacy uid 0
        self::assertTrue(EditPermission::canEdit(true, 5, 0, true));   // admin ok
    }
}
