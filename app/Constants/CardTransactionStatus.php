<?php

namespace App\Constants;

class CardTransactionStatus
{

   
   const DECLINED = 'Decline';
   const APPROVED = 'Approved';
   

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
