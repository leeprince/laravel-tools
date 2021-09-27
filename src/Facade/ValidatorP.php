<?php
/**
 * description
 *
 * @Author leeprince:9/17/21 11:08 PM
 */

namespace Leeprince\LaravelTools\Facade;

use Illuminate\Support\Facades\Facade;
use Leeprince\LaravelTools\Support\ValidatorP as ValidatorSupport;

/**
 * Description
 *
 * @Author leeprince:9/17/21 11:11 PM
 *
 * @method static void required(\Illuminate\Http\Request $request, array $fields)
 * @package Leeprince\LaravelTools\Facade
 */
class ValidatorP extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ValidatorSupport::class;
    }
}