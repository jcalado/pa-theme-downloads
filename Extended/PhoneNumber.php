<?php

namespace Extended;

use WordPlate\Acf\Fields\Field;
use WordPlate\Acf\Fields\Attributes\ConditionalLogic;
use WordPlate\Acf\Fields\Attributes\Instructions;
use WordPlate\Acf\Fields\Attributes\Required;
use WordPlate\Acf\Fields\Attributes\Wrapper;

/**
 * Register new Phone Number field
 */
class PhoneNumber extends Field {

    use ConditionalLogic;
    use Instructions;
    use Wrapper;
	use Required;

    protected $type = 'phone_number';

}
