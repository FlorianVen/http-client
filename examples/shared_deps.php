#!/usr/bin/php
<?php

/*
 * --------------------------------------------------------------------
 * Specify debug mode; boot Artax.
 * --------------------------------------------------------------------
 */

define('ATREYU_DEBUG_LEVEL', 1);
require dirname(__DIR__) . '/Artax.php';


// Share this PDO instance so all objects created by the injection container will reuse it
$pdo = new PDO('sqlite::memory:');
$injectionContainer->share('PDO', $pdo);

// Use the provider to provision a new instance
$controller1 = $injectionContainer->make('ControllerThatNeedsDbConn');

// A custom definition to use only for this instantiation ...
$controller2 = $injectionContainer->make('ControllerThatNeedsDbConn',
    array('pdo'=>new PDO('sqlite::memory:'), 'dep'=>new Dependency)
);

// And another using our original share ...
$controller3 = $injectionContainer->make('ControllerThatNeedsDbConn');

/**
 * Notice how all the PDO references point to the same memory location except
 * $controller2. This is because $controller2 specified a custom injection
 * definition with its own PDO instance.
 */
var_dump($pdo);
var_dump($controller1->getPdo());
var_dump($controller2->getPdo()); // <--- a different PDO instance from the others
var_dump($controller3->getPdo());



/**
 * An example dependency class
 */
class Dependency {}

/**
 * An example controller class that needs a PDO instance at instantiation
 */
class ControllerThatNeedsDbConn {

    protected $pdo;
    protected $dep;
    
    public function __construct(PDO $pdo, Dependency $dep) {
        $this->pdo = $pdo;
        $this->dep = $dep;
    }
    
    public function getPdo() {
        return $this->pdo;
    }
}