<?php

namespace Tests\Unit;

use QuotesCorePreload;
use PHPUnit\Framework\TestCase;

/**
 * Class QuotesCorePreloadTest.
 *
 * @covers \QuotesCorePreload
 */
final class QuotesCorePreloadTest extends TestCase
{
    private QuotesCorePreload $quotesCorePreload;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->quotesCorePreload = new QuotesCorePreload();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->quotesCorePreload);
    }

    public function testEventCoreIncludeCommonEnd(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
