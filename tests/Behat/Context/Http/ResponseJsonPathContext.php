<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Http;

use App\Tests\Behat\Context\SymfonyContext;
use Behat\Step\Then;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\Count;
use PHPUnit\Framework\Constraint\GreaterThan;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\IsIdentical;
use PHPUnit\Framework\Constraint\IsList;
use PHPUnit\Framework\Constraint\IsType;
use PHPUnit\Framework\Constraint\LogicalAnd;
use PHPUnit\Framework\Constraint\LogicalNot;
use PHPUnit\Framework\Constraint\LogicalOr;
use PHPUnit\Framework\Constraint\RegularExpression;
use PHPUnit\Framework\Constraint\StringContains;
use PHPUnit\Framework\NativeType;
use Symfony\Component\JsonPath\JsonCrawler;

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
    public function assertJsonPathMatches(string $path, Constraint $constraint): void
    {
        $responses = $this->context(ResponseContext::class);

        $message = \vsprintf('in JSON path "%s" %s', [
            $path,
            $responses->assertResponseMessage,
        ]);

        foreach ($this->path->find($path) as $index => $item) {
            Assert::assertThat($item, $constraint, 'Failure ' . $message);
        }

        if (isset($index)) {
            return;
        }

        Assert::fail('Undefined value ' . $message);
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    public function assertJsonPathNotMatches(string $path, Constraint $constraint): void
    {
        $this->assertJsonPathMatches($path, new LogicalNot($constraint));
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
        $this->assertJsonPathNotMatches($path, new RegularExpression($regex));
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
        $this->assertJsonPathNotMatches($path, new IsType(NativeType::String));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is empty string$/')]
    public function thenPathIsEmptyString(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsIdentical(''));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not empty string$/')]
    public function thenPathIsNotEmptyString(string $path): void
    {
        $this->assertJsonPathNotMatches($path, new IsIdentical(''));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is "(?P<expected>.+?)"$/')]
    public function thenPathIs(string $path, string $expected): void
    {
        $this->assertJsonPathMatches($path, new IsEqual($expected));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not "(?P<expected>.+?)"$/')]
    public function thenPathIsNot(string $path, string $expected): void
    {
        $this->assertJsonPathNotMatches($path, new IsEqual($expected));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" contains "(?P<expected>.+?)"$/')]
    public function thenPathContains(string $path, string $expected): void
    {
        $this->assertJsonPathMatches($path, new StringContains($expected));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" not contains "(?P<expected>.+?)"$/')]
    public function thenPathNotContains(string $path, string $expected): void
    {
        $this->assertJsonPathNotMatches($path, new StringContains($expected));
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
    #[Then('/^json path "(?P<path>.+?)" is not array$/')]
    public function thenPathIsNotArray(string $path): void
    {
        $this->assertJsonPathNotMatches($path, new IsType(NativeType::Array));
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

        $this->assertJsonPathNotMatches($path, new IsEqual($expected));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is array with (?P<size>\d+) elements?$/')]
    public function thenPathIsArrayOfSize(string $path, int $size): void
    {
        $this->assertJsonPathMatches($path, new Count($size));
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
        $this->assertJsonPathNotMatches($path, new IsType(NativeType::Bool));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is true$/')]
    public function thenPathIsTrue(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsIdentical(true));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not true$/')]
    public function thenPathIsNotTrue(string $path): void
    {
        $this->assertJsonPathNotMatches($path, new IsIdentical(true));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is false$/')]
    public function thenPathIsFalse(string $path): void
    {
        $this->assertJsonPathMatches($path, new IsIdentical(false));
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not false$/')]
    public function thenPathIsNotFalse(string $path): void
    {
        $this->assertJsonPathNotMatches($path, new IsIdentical(false));
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
        $this->assertJsonPathNotMatches($path, new IsType(NativeType::Float));
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
        $this->assertJsonPathNotMatches($path, new IsType(NativeType::Int));
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
        $this->assertJsonPathNotMatches($path, new IsType(NativeType::Null));
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
        $this->assertJsonPathNotMatches($path, new IsType(NativeType::Numeric));
    }

    private function isObjectTypeConstraint(): Constraint
    {
        return LogicalOr::fromConstraints(
            new IsType(NativeType::Object),
            LogicalAnd::fromConstraints(
                new IsType(NativeType::Array),
                new LogicalNot(new IsList()),
            ),
        );
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is object$/')]
    public function thenPathIsObject(string $path): void
    {
        $this->assertJsonPathMatches($path, $this->isObjectTypeConstraint());
    }

    /**
     * @api
     *
     * @param non-empty-string $path
     */
    #[Then('/^json path "(?P<path>.+?)" is not object$/')]
    public function thenPathIsNotObject(string $path): void
    {
        $this->assertJsonPathNotMatches($path, $this->isObjectTypeConstraint());
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
        $this->assertJsonPathNotMatches($path, new IsType(NativeType::Scalar));
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
}
