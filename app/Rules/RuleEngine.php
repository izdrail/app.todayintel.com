<?php

namespace App\Rules;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class RuleEngine
{
    private ExpressionLanguage $expressionLanguage;

    public function __construct()
    {
        $this->expressionLanguage = new ExpressionLanguage();
    }

    final function evaluateRule(ExpressionLanguage $rule, array $data = []):mixed
    {
        // Evaluate the rule using Symfony Expression Language
        return $this->expressionLanguage->evaluate($rule, $data);
    }
}
