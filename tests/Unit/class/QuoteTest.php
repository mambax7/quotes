<?php

namespace Tests\Unit\XoopsModules\Quote;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Quote;

/**
 * Class QuoteTest.
 *
 * @covers \XoopsModules\Quote\Quote
 */
final class QuoteTest extends TestCase
{
    private Quote $quote;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->quote = new Quote();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->quote);
    }

    public function testGetForm(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetGroupsRead(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetGroupsSubmit(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGetGroupsModeration(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
