<?php
/**
 * Created by PhpStorm.
 * User: iuriguntchnigg
 * Date: 12/07/16
 * Time: 23:05
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{

  protected $rules = [
            "name"        => 'required|max:255',
            "responsible" => 'required|max:255',
            "email"       => 'required|email',
            "phone"       => 'required',
            "address"     => 'required'
  ];
}