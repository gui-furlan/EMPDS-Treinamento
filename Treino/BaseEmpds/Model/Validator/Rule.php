<?php

namespace BaseEmpds\Model\Validator;

interface Rule
{
    public function check(ContextRuleValidator $context);
}
