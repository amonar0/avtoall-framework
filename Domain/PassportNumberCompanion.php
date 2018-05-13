<?php

namespace AutoAlliance\Domain;

use AutoAlliance\Technology\Common\ScalarValueObjectCompanionInterface;

final class PassportNumberCompanion implements ScalarValueObjectCompanionInterface
{

    public function validate(/*string|int*/
        $scalar
    ): array {
        assert(is_string($scalar) || is_int($scalar), $scalar);

        return [true, ''];
    }

    public function createFromScalar(/*string|int*/
        $passportNumber
    ) {
        return new PassportNumber($passportNumber);
    }
}