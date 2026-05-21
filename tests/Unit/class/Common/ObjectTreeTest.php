<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\ObjectTree;

/**
 * Class ObjectTreeTest.
 *
 * @covers \XoopsModules\Quote\Common\ObjectTree
 */
final class ObjectTreeTest extends TestCase
{
    private ObjectTree $objectTree;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->objectTree = new ObjectTree();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->objectTree);
    }

    public function testMakeSelBoxOptionsArray(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testMakeSelBox(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
