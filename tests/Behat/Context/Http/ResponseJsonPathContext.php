<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Http;

use App\Tests\Behat\Context\SymfonyContext;
use Behat\Step\Then;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\GreaterThan;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\IsType;
use PHPUnit\Framework\Constraint\LogicalNot;
use PHPUnit\Framework\Constraint\RegularExpression;
use PHPUnit\Framework\NativeType;
use Symfony\Component\JsonPath\JsonCrawler;
use Symfony\Component\JsonPath\Test\JsonPathContains;
use Symfony\Component\JsonPath\Test\JsonPathCount;
use Symfony\Component\JsonPath\Test\JsonPathEquals;
use Symfony\Component\JsonPath\Test\JsonPathNotContains;
use Symfony\Component\JsonPath\Test\JsonPathNotEquals;
use Symfony\Component\JsonPath\Test\JsonPathNotSame;
use Symfony\Component\JsonPath\Test\JsonPathSame;

/**
 * @api
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class ResponseJsonPathContext extends SymfonyContext
{
    public JsonCrawler $path {
        get {
            $responses = $this->context(ResponseContext::class);

            return new JsonCrawler($responses->content);
        }
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathMatches(string $path, Constraint $constraint, string $message = ''): void
    {
        Assert::assertThat($this->path->find($path), $constraint, $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathEquals(string $path, mixed $value, string $message = ''): void
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($value, new JsonPathEquals($path, $responses->content), $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathNotEquals(string $path, mixed $value, string $message = ''): void
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($value, new JsonPathNotEquals($path, $responses->content), $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathCount(string $path, int $count, string $message = ''): void
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($count, new JsonPathCount($path, $responses->content), $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathSame(string $path, mixed $value, string $message = ''): void
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($value, new JsonPathSame($path, $responses->content), $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathNotSame(string $path, mixed $value, string $message = ''): void
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($value, new JsonPathNotSame($path, $responses->content), $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathContains(string $path, mixed $value, bool $strict = true, string $message = ''): void
    {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($value, new JsonPathContains($path, $responses->content, $strict), $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathNotContains(
        string $path,
        mixed $value,
        bool $strict = true,
        string $message = '',
    ): void {
        $responses = $this->context(ResponseContext::class);

        Assert::assertThat($value, new JsonPathNotContains($path, $responses->content, $strict), $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     * @param non-empty-string $regex
     */
    #[Then('/^json path "(?P<path>.+?)" matches the \/(?P<regex>.+?)\/$/')]
    public function thenPathMatches(string $path, string $regex): void
    {
        $this->assertJsonPathMatches($path, new RegularExpression($regex));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     * @param non-empty-string $regex
     */
    #[Then('/^json path "(?P<path>.+?)" not matches the \/(?P<regex>.+?)\/$/')]
    public function thenPathNotMatches(string $path, string $regex): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new RegularExpression($regex)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is string$/')]
    public function thenPathIsString(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::String));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not string$/')]
    public function thenPathIsNotString(string $path): void
    {
        $this->assertJsonPathMatches(
            $path,
            new LogicalNot(new IsType(NativeType::String)),
        );
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is empty string$/')]
    public function thenPathIsEmptyString(string $path): void
    {
        $this->assertJsonPathSame($path, '');
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not empty string$/')]
    public function thenPathIsNotEmptyString(string $path): void
    {
        $this->assertJsonPathNotSame($path, '');
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is "(?P<expected>.+?)"$/')]
    public function thenPathIs(string $path, string $expected): void
    {
        $this->assertJsonPathEquals($path, $expected);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not "(?P<expected>.+?)"$/')]
    public function thenPathIsNot(string $path, string $expected): void
    {
        $this->assertJsonPathNotEquals($path, $expected);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is (?P<type>bool|int|float|string|array|object|null) "(?P<expected>.+?)"$/')]
    public function thenPathIsOfType(string $path, string $type, string $expected): void
    {
        \settype($expected, $type);

        $this->assertJsonPathMatches($path, new IsEqual($expected));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not (?P<type>bool|int|float|string|array|object|null) "(?P<expected>.+?)"$/')]
    public function thenPathIsNotOfType(string $path, string $type, string $expected): void
    {
        \settype($expected, $type);

        $this->assertJsonPathMatches($path, new LogicalNot(new IsEqual($expected)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" contains "(?P<expected>.+?)"$/')]
    public function thenPathContains(string $path, string $expected): void
    {
        $this->assertJsonPathContains($path, $expected);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" not contains "(?P<expected>.+?)"$/')]
    public function thenPathNotContains(string $path, string $expected): void
    {
        $this->assertJsonPathNotContains($path, $expected);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is array$/')]
    public function thenPathIsArray(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::Array));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is array with (?P<size>\d+) elements$/')]
    public function thenPathIsArrayOfSize(string $path, int $size): void
    {
        $this->assertJsonPathCount($path, $size);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not array$/')]
    public function thenPathIsNotArray(string $path): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new IsType(NativeType::Array)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is bool$/')]
    public function thenPathIsBool(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::Bool));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not bool$/')]
    public function thenPathIsNotBool(string $path): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new IsType(NativeType::Bool)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is true$/')]
    public function thenPathIsTrue(string $path): void
    {
        $this->assertJsonPathSame($path, true);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not true$/')]
    public function thenPathIsNotTrue(string $path): void
    {
        $this->assertJsonPathNotSame($path, true);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is false$/')]
    public function thenPathIsFalse(string $path): void
    {
        $this->assertJsonPathSame($path, false);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not false$/')]
    public function thenPathIsNotFalse(string $path): void
    {
        $this->assertJsonPathNotSame($path, false);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is float$/')]
    public function thenPathIsFloat(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::Float));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not float$/')]
    public function thenPathIsNotFloat(string $path): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new IsType(NativeType::Float)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is int$/')]
    public function thenPathIsInt(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::Int));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not int$/')]
    public function thenPathIsNotInt(string $path): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new IsType(NativeType::Int)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is positive int$/')]
    public function thenPathIsPositiveInt(string $path): void
    {
        $this->thenPathIsInt($path);
        $this->assertJsonPathMatches($path, new GreaterThan(0));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is unsigned int$/')]
    public function thenPathIsUnsignedInt(string $path): void
    {
        $this->thenPathIsInt($path);
        $this->assertJsonPathMatches($path, new GreaterThan(-1));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is null$/')]
    public function thenPathIsNull(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::Null));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not null$/')]
    public function thenPathIsNotNull(string $path): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new IsType(NativeType::Null)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is numeric$/')]
    public function thenPathIsNumeric(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::Numeric));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not numeric$/')]
    public function thenPathIsNotNumeric(string $path): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new IsType(NativeType::Numeric)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is object$/')]
    public function thenPathIsObject(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::Object));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not object$/')]
    public function thenPathIsNotObject(string $path): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new IsType(NativeType::Object)));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is scalar$/')]
    public function thenPathIsScalar(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsType(NativeType::Scalar));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not scalar$/')]
    public function thenPathIsNotScalar(string $path): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot(new IsType(NativeType::Scalar)));
    }
}
