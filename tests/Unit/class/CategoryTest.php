<?php

namespace Tests\Unit\XoopsModules\Quotes;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quotes\Category;

/**
 * Class CategoryTest.
 *
 * @covers \XoopsModules\Quotes\Category
 */
final class CategoryTest extends TestCase
{
    private Category $category;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->category = new Category();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->category);
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
