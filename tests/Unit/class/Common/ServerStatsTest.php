<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\ServerStats;

/**
 * Class ServerStatsTest.
 *
 * @author XOOPS Development Team <https://xoops.org>
 * @copyright {@link https://xoops.org/ XOOPS Project}
 * @license GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 *
 * @covers \XoopsModules\Quote\Common\ServerStats
 */
final class ServerStatsTest extends TestCase
{
    private ServerStats $serverStats;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->serverStats = $this->getMockBuilder(ServerStats::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->serverStats);
    }

    public function testGetServerStats(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
