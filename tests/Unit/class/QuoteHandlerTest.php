<?php

namespace Tests\Unit\XoopsModules\Quote;

use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use XoopsDatabase;
use XoopsModules\Quote\Helper;
use XoopsModules\Quote\QuoteHandler;

/**
 * Class QuoteHandlerTest.
 *
 * @covers \XoopsModules\Quote\QuoteHandler
 */
final class QuoteHandlerTest extends TestCase
{
    private QuoteHandler $quoteHandler;

    private XoopsDatabase|Mock $db;

    private Helper|Mock $helper;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->db = Mockery::mock(XoopsDatabase::class);
        $this->helper = Mockery::mock(Helper::class);
        $this->quoteHandler = new QuoteHandler($this->db, $this->helper);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->quoteHandler);
        unset($this->db);
        unset($this->helper);
    }

    public function testCreate(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
