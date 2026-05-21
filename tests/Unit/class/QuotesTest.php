<?php

namespace Tests\Unit\XoopsModules\Quote;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Quotes;

/**
 * Class QuotesTest.
 *
 * @covers \XoopsModules\Quote\Quotes
 */
final class QuotesTest extends TestCase
{
    private Quotes $quotes;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->quotes = new Quotes();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->quotes);
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
