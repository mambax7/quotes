<?php

namespace Tests\Unit\XoopsModules\Quote;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Author;

/**
 * Class AuthorTest.
 *
 * @covers \XoopsModules\Quote\Author
 */
final class AuthorTest extends TestCase
{
    private Author $author;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->author = new Author();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->author);
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
