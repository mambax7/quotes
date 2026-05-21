<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\DirectoryChecker;

/**
 * Class DirectoryCheckerTest.
 *
 * @covers \XoopsModules\Quote\Common\DirectoryChecker
 */
final class DirectoryCheckerTest extends TestCase
{
    private DirectoryChecker $directoryChecker;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->directoryChecker = new DirectoryChecker();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->directoryChecker);
    }

    public function testGetDirectoryStatus(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCreateDirectory(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSetDirectoryPermissions(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDirExists(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
