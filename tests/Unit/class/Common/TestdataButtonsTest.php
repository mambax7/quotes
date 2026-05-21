<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\TestdataButtons;

/**
 * Class TestdataButtonsTest.
 *
 * @covers \XoopsModules\Quote\Common\TestdataButtons
 */
final class TestdataButtonsTest extends TestCase
{
    private TestdataButtons $testdataButtons;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->testdataButtons = new TestdataButtons();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->testdataButtons);
    }

    public function testLoadButtonConfig(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testHideButtons(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testShowButtons(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
