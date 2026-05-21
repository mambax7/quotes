<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\Breadcrumb;

/**
 * Class BreadcrumbTest.
 *
 * @covers \XoopsModules\Quote\Common\Breadcrumb
 */
final class BreadcrumbTest extends TestCase
{
    private Breadcrumb $breadcrumb;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->breadcrumb = new Breadcrumb();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->breadcrumb);
    }

    public function testAddLink(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testRender(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
