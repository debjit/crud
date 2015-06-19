<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace BlackfyreStudio\CRUD\Util;

 class Value {
     /**
      * Encode a value based on the strategy
      *
      * @param  string $strategy
      * @param  string $value
      *
      * @access public
      * @return string
      */
     public static function encode($strategy, $value)
     {
         switch ($strategy) {
             case 'explode':
                 return implode(',', $value);
             case 'json':
                 return json_encode($value);
             case 'serialize':
                 return serialize($value);
         }
         return $value;
     }
     /**
      * Decode a value based on the strategy.
      *
      * @param  string $strategy
      * @param  string $value
      *
      * @access public
      * @return array|mixed
      */
     public static function decode($strategy, $value)
     {
         switch ($strategy) {
             case 'explode':
                 return explode(',', $value);
             case 'json':
                 return json_decode($value);
             case 'serialize':
                 return unserialize($value);
         }
         return $value;
     }
 }