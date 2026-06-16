<?php

namespace Tests\Unit\XoopsModules\Quotes;

use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use XoopsDatabase;
use XoopsModules\Quotes\AuthorHandler;
use XoopsModules\Quotes\Helper;

/**
 * Class AuthorHandlerTest.
 *
 * @covers \XoopsModules\Quotes\AuthorHandler
 */
final class AuthorHandlerTest extends TestCase
{
    private AuthorHandler $authorHandler;

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
        $this->authorHandler = new AuthorHandler($this->db, $this->helper);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->authorHandler);
        unset($this->db);
        unset($this->helper);
    }

    public function testCreate(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
