<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\FilesManagement;

/**
 * Class FilesManagementTest.
 *
 * @author XOOPS Development Team <https://xoops.org>
 * @copyright {@link https://xoops.org/ XOOPS Project}
 * @license GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 *
 * @covers \XoopsModules\Quote\Common\FilesManagement
 */
final class FilesManagementTest extends TestCase
{
    private FilesManagement $filesManagement;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->filesManagement = $this->getMockBuilder(FilesManagement::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->filesManagement);
    }

    public function testCreateFolder(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCopyFile(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testRecurseCopy(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testXcopy(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDeleteDirectory(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testRrmdir(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testRmove(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testRcopy(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
