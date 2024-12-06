<?php

namespace BaseEmpds\Model\Validator;

interface RuleProvider
{

    public function hasRule($name): bool;

    public function getRule($name): Rule;

    public function getRules(): array;
}
