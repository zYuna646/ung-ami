<?php

namespace App\Constants;

use ReflectionClass;
use Illuminate\Support\Collection;

class AuditStatus
{
  public const PENDING = 'Pending'; 
  public const PROCESS = 'Proses';  
  public const COMPLETE = 'Selesai';
  public const REJECTED = 'Ditolak';

  public static function all(): Collection
  {
    $class = new ReflectionClass(__CLASS__);
    return collect($class->getConstants());
  }
}
