<?php

/**
 * Artax Config Class File
 * 
 * PHP version 5.4
 * 
 * @category Artax
 * @package  core
 * @author   Daniel Lowrey <rdlowrey@gmail.com>
 */

namespace Artax {

  /**
   * Artax Configuration class
   * 
   * Class uses BucketSettersTrait to enable setter methods for bucket
   * parameters.
   * 
   * @category Artax
   * @package  core
   * @author   Daniel Lowrey <rdlowrey@gmail.com>
   */
  class Config extends Bucket
  {
    use BucketSettersTrait;
    
    /**
     * Initializes default configuration directive values
     * 
     * @return void
     */
    public function __construct()
    {
      $this->defaults = [
        'debug'       => FALSE,
        'classLoader' => 'standard',
        'deps'        => [],
        'listeners'   => [],
        'routes'      => []
      ];
      $this->load();
    }
    
    /**
     * Filters boolean values
     * 
     * @param bool $val         Boolean value flag
     * 
     * @return bool Returns filtered boolean value
     */
    protected function filterBool($val)
    {
      $var = filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
      return (bool) $var;
    }
    
    /**
     * Setter function for debug directive
     * 
     * The bootstrapper will set PHP's error reporting level based on the
     * debug value.
     * 
     * @param bool $val         A boolean debug flag
     * 
     * @return void
     */
    protected function setDebug($val)
    {
      $this->params['debug'] = $this->filterBool($val);
    }
  }
}