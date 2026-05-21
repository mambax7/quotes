<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\ModuleStats;

/**
 * Class ModuleStatsTest.
 *
 * @author XOOPS Development Team <https://xoops.org>
 * @copyright {@link https://xoops.org/ XOOPS Project}
 * @license GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 *
 * @covers \XoopsModules\Quote\Common\ModuleStats
 */
final class ModuleStatsTest extends TestCase
{
    private ModuleStats $moduleStats;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->moduleStats = $this->getMockBuilder(ModuleStats::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->moduleStats);
    }

    public function testGetModuleStats(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
