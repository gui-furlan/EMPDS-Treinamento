<?php

namespace BaseEmpds\Model\Validator;

use BaseEmpds\Model\Validator\AbstractRuleProvider;
use BaseEmpds\Model\Validator\ContextRuleValidator;
use BaseEmpds\Model\Validator\RuleProvider;

final class RuleValidator
{

    /**
     * @var AbstractRuleProvider[]
     */
    private $ruleProviders;

    /**
     * @var ContextRuleValidator
     */
    private $context;

    public function __construct(ContextRuleValidator $context = null, $ruleProviders = [])
    {
        $this->context       = $context;
        $this->ruleProviders = $ruleProviders;
    }

    /**
     * Adiciona RuleProvider
     */
    public function addRuleProvider(RuleProvider $ruleProvider)
    {
        $this->ruleProviders = $ruleProvider;
    }

    /**
     * Define o contexto
     */
    public function setContext(ContextRuleValidator $context)
    {
        $this->context = $context;
    }

    /**
     * Aplica as validações
     */
    public function validate()
    {
        foreach ($this->ruleProviders as $ruleProvider) {
            $rules = $ruleProvider->getRules();
            foreach ($rules as /* @var Rule $rule */ $rule) {
                if (!is_object($rule)) {
                    $rule = new $rule();
                }

                if (!$rule->check($this->context)) {
                    return false;
                }
            }
        }
        return true;
    }
}
