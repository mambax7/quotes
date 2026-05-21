<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\ModuleFeedback;

/**
 * Class ModuleFeedbackTest.
 *
 * @covers \XoopsModules\Quote\Common\ModuleFeedback
 */
final class ModuleFeedbackTest extends TestCase
{
    private ModuleFeedback $moduleFeedback;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->moduleFeedback = new ModuleFeedback();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->moduleFeedback);
    }

    public function testGetInstance(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetFormFeedback(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
