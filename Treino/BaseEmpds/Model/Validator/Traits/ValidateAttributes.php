<?php

namespace BaseEmpds\Model\Validator\Traits;

use BaseEmpds\Model\BaseFactory;
use DateTime;
use Exception;

/**
 * Classe para aplicar as validações básicas
 */
trait ValidateAttributes{

    /**
     * Validate that an attribute is an array.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateArray($attribute, $value, $parameters = [])
    {
        if (! is_array($value)) {
            return false;
        }

        if (empty($parameters)) {
            return true;
        }

        return empty(array_diff_key($value, array_fill_keys($parameters, '')));
    }

    /**
     * Validate the size of an attribute is between a set of values.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateBetween($attribute, $value, $parameters)
    {
        if(count($parameters) == 2){
            $size = $this->getSize($attribute, $value);
            return $size >= $parameters[0] && $size <= $parameters[1];
        }
        return false;
        
    }

    /**
     * Validate that an attribute matches a date format.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateDateFormat($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'date_format');

        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }

        foreach ($parameters as $format) {
            $date = DateTime::createFromFormat('!'.$format, $value);
            if ($date && $date->format($format) == $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate that an attribute has a given number of digits.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateDigits($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'digits');
        return ! preg_match('/[^0-9]/', $value) && strlen((string) $value) == $parameters[0];
    }

    /**
     * Validate that an attribute is between a given number of digits.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateDigitsBetween($attribute, $value, $parameters)
    {
        $this->requireParameterCount(2, $parameters, 'digits_between');
        $length = strlen((string) $value);

        return ! preg_match('/[^0-9]/', $value) && $length >= $parameters[0] && $length <= $parameters[1];
    }

    /**
     * Validate that an attribute is an integer.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateInteger($attribute, $value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Validate the size of an attribute is greater than a minimum value.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateMin($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'min');

        return $this->getSize($attribute, $value) >= $parameters[0];
    }

    /**
     * Validate that an attribute has a minimum number of digits.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateMinDigits($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'min');

        $length = strlen((string) $value);

        return ! preg_match('/[^0-9]/', $value) && $length >= $parameters[0];
    }

    /**
     * Validate the size of an attribute is less than a maximum value.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateMax($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'max');
        return $this->getSize($attribute, $value) <= $parameters[0];
    }

    /**
     * Validate that an attribute has a maximum number of digits.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateMaxDigits($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'max');
        $length = strlen((string) $value);
        return ! preg_match('/[^0-9]/', $value) && $length <= $parameters[0];
    }

    /**
     * Validate that an attribute is numeric.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function validateNumeric($attribute, $value)
    {
        return is_numeric($value);
    }
    
    /**
     * Validate the size of an attribute.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array<int, int|string>  $parameters
     * @return bool
     */
    public function validateSize($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'size');

        $size = $this->getSize($attribute, $value);
        return $size == $parameters[0];
    }

    /**
     * Retorna se um atributo existe
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateRequired($attribute, $value){
        if(is_null($value)){
            return false;
        }
        if(is_string($value) && trim($value) === ''){
            return false;
        }
        if(is_countable($value) && count($value) < 1){
            return false;
        }
        return true;
    }

    public function validateUniqueEntity($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'unique');

        /** @var \BaseEmpds\Model\Repository\BaseRepository */
        $repository = BaseFactory::getRepository($parameters[0]);
        $count      = $repository->getCountByColumn($parameters[1], $value);
        return $count == 0;
    }

    public function validateExistsEntity($attribute, $value, $parameters)
    {   
        $this->requireParameterCount(1, $parameters, 'exists');
        /** @var \BaseEmpds\Model\Repository\BaseRepository */
        $repository = BaseFactory::getRepository($parameters[0]);
        $count      = $repository->getCountByColumn(isset($parameters[1]) ? $parameters[1] : 'id', $value);

        $expected = is_array($value) ? count(array_unique($value)) : 1;

        return $count >= $expected;
    }

    /**
     * Require a certain number of parameters to be present.
     *
     * @param  int  $count
     * @param  array<int, int|string>  $parameters
     * @param  string  $rule
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function requireParameterCount($count, $parameters, $rule)
    {
        if (count($parameters) < $count) {
            throw new Exception("A regra ($rule) validada requer pelo menos $count parâmetros.");
        }
    }

    /**
     * Get the size of an attribute.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return mixed
     */
    protected function getSize($attribute, $value)
    {
        $hasNumeric = $this->hasRule($attribute, ['Numeric', 'Integer']);

        if (is_numeric($value) && $hasNumeric) {
            return $value;
        } 
        elseif (is_array($value)) {
            return count($value);
        }

        return mb_strlen($value ?? '');
    }
}
