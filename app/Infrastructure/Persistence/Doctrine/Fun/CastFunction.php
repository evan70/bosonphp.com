<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fun;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * "CAST" "(" "$fieldIdentifierExpression" "AS" "$castingTypeExpression" ")"
 *
 * @example SELECT CAST(foo.bar AS SIGNED) FROM dual;
 */
final class CastFunction extends FunctionNode
{
    protected Node|string $fieldIdentifierExpression;

    protected string $castingTypeExpression;

    /**
     * @throws QueryException
     */
    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->fieldIdentifierExpression = $parser->SimpleArithmeticExpression();

        $parser->match(TokenType::T_AS);
        $parser->match(TokenType::T_IDENTIFIER);

        $type = $lexer->token->value;

        if ($lexer->isNextToken(TokenType::T_OPEN_PARENTHESIS)) {
            $parser->match(TokenType::T_OPEN_PARENTHESIS);
            $parameter = $parser->Literal();

            assert($parameter instanceof Literal);

            $parameters = [$parameter->value];

            if ($lexer->isNextToken(TokenType::T_COMMA)) {
                while ($lexer->isNextToken(TokenType::T_COMMA)) {
                    $parser->match(TokenType::T_COMMA);
                    $parameter    = $parser->Literal();
                    $parameters[] = $parameter->value;
                }
            }

            $parser->match(TokenType::T_CLOSE_PARENTHESIS);
            $type .= '(' . \implode(', ', $parameters) . ')';
        }

        $this->castingTypeExpression = $type;

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return \vsprintf('CAST(%s AS %s)', [
            $sqlWalker->walkSimpleArithmeticExpression($this->fieldIdentifierExpression),
            $this->castingTypeExpression,
        ]);
    }
}
