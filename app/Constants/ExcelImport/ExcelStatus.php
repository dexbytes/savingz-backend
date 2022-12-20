<?php

namespace App\Constants\ExcelImport;

class ExcelStatus
{

   const PENDING = 'pending';
   const ACCEPTED = 'accepted';
   const CANCELLED = 'cancelled';
   const IN_PROGRESS = 'in_progress';
   const WAITING_APPROVEL = 'waiting_approvel';
   const IMPORTING = "importing";
   const FAILED = 'failed';
   const COMPLETED = 'completed';

   public function getConstants()
   {
      $reflectionClass = new \ReflectionClass($this);
      return $reflectionClass->getConstants();
   }

   public function hasConstant($constans)
   {
      $reflectionClass = new \ReflectionClass($this);
      return $reflectionClass->hasConstant($constans);
   }
}
