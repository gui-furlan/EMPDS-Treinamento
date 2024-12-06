<?php
 
namespace BaseEmpds\Model\Validator;

use BaseEmpds\Model\Validator\Rule;
use BaseEmpds\Model\Validator\RuleProvider;

abstract class AbstractRuleProvider implements RuleProvider, Rule
{

    /**
     * @var Rule[]
     */
    private $rules;

    /**
     * Adiciona uma regra
     * @param string $name
     * @param Rule $rule
     */
    public function addRule(string $name, Rule $rule)
    {
        $this->rules[$name] = $rule;
    }

    /**
     * Adiciona uma regra pela definição
     */
    public function addRuleDefinition($clazz)
    {
        $this->rules[$clazz::NAME] = $clazz;
    }

    /**
     * Remove uma regra
     * @param string $name
     */
    public function removeRule(string $name)
    {
        if ($this->hasRule($name)) {
            unset($this->rules[$name]);
        }
    }

    /**
     * Verifica se uma regra existe
     * @param string $name
     * @return bool
     */
    public function hasRule($name): bool
    {
        return (bool) isset($this->rules[$name]);
    }

    /**
     * Retorna uma regra
     * @param string $name
     * @return Rule
     */
    public function getRule($name): Rule
    {
        if ($this->hasRule($name)) {
            return $this->rules[$name];
        }
        return null;
    }

    /**
     * Retorna todas as regras
     * @return Rule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }
    
    public function check(ContextRuleValidator $context) {}
}
