<?php

namespace App\Constants;

class UserStatus
{

   const PENDING = 'pending';
   const ACCEPTED = 'accepted';
   const CANCELLED = 'cancelled';
   const DECLINED = 'declined';
   const COMPLETED = 'completed';
   const SUSPENDED = 'suspended';


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
