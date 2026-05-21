<?php

namespace Tests\Unit\XoopsModules\Quote\Common;

use CriteriaElement;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use XoopsModules\Quote\Common\LetterChoice;
use XoopsPersistableObjectHandler;

/**
 * Class LetterChoiceTest.
 *
 * @covers \XoopsModules\Quote\Common\LetterChoice
 */
final class LetterChoiceTest extends TestCase
{
    private LetterChoice $letterChoice;

    private XoopsPersistableObjectHandler|Mock $objHandler;

    private CriteriaElement|Mock $criteria;

    private string $field_name;

    private array $alphabet;

    private string $arg_name;

    private string $url;

    private string $extra_arg;

    private bool $caseSensitive;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->objHandler = Mockery::mock(XoopsPersistableObjectHandler::class);
        $this->criteria = Mockery::mock(CriteriaElement::class);
        $this->field_name = '42';
        $this->alphabet = [];
        $this->arg_name = '42';
        $this->url = '42';
        $this->extra_arg = '42';
        $this->caseSensitive = true;
        $this->letterChoice = new LetterChoice($this->objHandler, $this->criteria, $this->field_name, $this->alphabet, $this->arg_name, $this->url, $this->extra_arg, $this->caseSensitive);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->letterChoice);
        unset($this->objHandler);
        unset($this->criteria);
        unset($this->field_name);
        unset($this->alphabet);
        unset($this->arg_name);
        unset($this->url);
        unset($this->extra_arg);
        unset($this->caseSensitive);
    }

    public function testRender(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
