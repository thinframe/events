<?php

/**
 * /src/Constants/Priority.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Events\Constant;

use ThinFrame\Foundation\DataType\AbstractEnum;

/**
 * Class Priority
 *
 * @package ThinFrame\Events\Constants
 * @since   0.2
 */
final class Priority extends AbstractEnum
{
    const MAX      = 999;
    const CRITICAL = 99;
    const HIGH     = 66;
    const MEDIUM   = 33;
    const LOW      = 0;
    const MIN      = -33;
}