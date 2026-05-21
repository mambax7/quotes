<?php

namespace Tests\Unit;

use QuoteCorePreload;
use PHPUnit\Framework\TestCase;

/**
 * Class QuoteCorePreloadTest.
 *
 * @covers \QuoteCorePreload
 */
final class QuoteCorePreloadTest extends TestCase
{
    private QuoteCorePreload $quoteCorePreload;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->quoteCorePreload = new QuoteCorePreload();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->quoteCorePreload);
    }

    public function testEventCoreIncludeCommonEnd(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
