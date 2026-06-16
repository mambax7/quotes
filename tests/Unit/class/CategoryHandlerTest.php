<?php

namespace Tests\Unit\XoopsModules\Quotes;

use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use XoopsDatabase;
use XoopsModules\Quotes\CategoryHandler;
use XoopsModules\Quotes\Helper;

/**
 * Class CategoryHandlerTest.
 *
 * @covers \XoopsModules\Quotes\CategoryHandler
 */
final class CategoryHandlerTest extends TestCase
{
    private CategoryHandler $categoryHandler;

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
        $this->categoryHandler = new CategoryHandler($this->db, $this->helper);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->categoryHandler);
        unset($this->db);
        unset($this->helper);
    }

    public function testCreate(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
