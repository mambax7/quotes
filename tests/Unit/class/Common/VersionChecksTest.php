<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\VersionChecks;

/**
 * Class VersionChecksTest.
 *
 * @author XOOPS Development Team <https://xoops.org>
 * @copyright {@link https://xoops.org/ XOOPS Project}
 * @license GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 *
 * @covers \XoopsModules\Quote\Common\VersionChecks
 */
final class VersionChecksTest extends TestCase
{
    private VersionChecks $versionChecks;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->versionChecks = $this->getMockBuilder(VersionChecks::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->versionChecks);
    }

    public function testCheckVerXoops(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCheckVerPhp(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCheckVerModule(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
