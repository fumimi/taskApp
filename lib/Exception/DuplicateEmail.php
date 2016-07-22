<?php

namespace MyApp\Exception;

class DuplicateEmail extends \Exception {
  protected $message = 'Duplicate Email!';
}
