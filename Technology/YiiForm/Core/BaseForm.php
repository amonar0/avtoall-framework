<?php

namespace AutoAlliance\Technology\YiiForm\Core;

use AutoAlliance\Technology\YiiForm\Core\FormInterface;
use CFormModel; //@uses Yii

abstract class BaseForm extends CFormModel implements FormInterface
{
    final public function ifValid(array $attributeMap, callable $onValidCallback)//: void
    {
        $this->setAttributes($attributeMap);

        if (!$this->hasAttributes($attributeMap)) {
            return;
        }

        if ($this->validate()) {
            $onValidCallback($this);
        }
    }

    //@todo сделать нормальный метод
    private function hasAttributes(array $attributeMap): bool {
        return (bool)$attributeMap;
    }

    final public function hasErrors(/*string*/
        $attribute = null
    ): bool {
        return parent::hasErrors($attribute);
    }

    final public function validate(/*array*/
        $attributeMap = null, /*bool*/
        $clearErrors = true
    ): bool {
        $this->validateValueObjects();

        return parent::validate($attributeMap, $clearErrors);
    }

    protected function attributeValueObjectMap(): array
    {
        return [];
    }

    final protected function attribute(string $attributeName)
    {
        $attribute = $this->$attributeName;

        $valueObjectCompanion = $this->attributeValueObjectMap()[$attributeName] ?? null;
        if ($valueObjectCompanion) {
            $attribute = $valueObjectCompanion->createFromScalar($attribute);
        }

        return $attribute;
    }

    private function validateValueObjects()//: void
    {
        foreach ($this->attributeValueObjectMap() as $attributeName => $valueObjectCompanion) {
            list($isValid, $errorMessage) = $valueObjectCompanion->validate($attributeName);

            if (!$isValid) {
                $this->addError($errorMessage);
            }
        }
    }
}