<?php

namespace Tests\Unit\XoopsModules\Quote;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Authors;

/**
 * Class AuthorsTest.
 *
 * @covers \XoopsModules\Quote\Authors
 */
final class AuthorsTest extends TestCase
{
    private Authors $authors;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->authors = new Authors();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->authors);
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
