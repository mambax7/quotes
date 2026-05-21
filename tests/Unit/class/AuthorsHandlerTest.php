<?php

namespace Tests\Unit\XoopsModules\Quote;

use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use XoopsDatabase;
use XoopsModules\Quote\AuthorsHandler;
use XoopsModules\Quote\Helper;

/**
 * Class AuthorsHandlerTest.
 *
 * @covers \XoopsModules\Quote\AuthorsHandler
 */
final class AuthorsHandlerTest extends TestCase
{
    private AuthorsHandler $authorsHandler;

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
        $this->authorsHandler = new AuthorsHandler($this->db, $this->helper);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->authorsHandler);
        unset($this->db);
        unset($this->helper);
    }

    public function testCreate(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
