<?php
namespace Upload\Tests;

use Upload\FileUploadDB;
use PDO;
use PHPUnit\Framework\TestCase;

class FileUploadDBTest extends TestCase {
    
    protected $dbc;
    protected $upload;
    
    public function setUp(){
        $this->dbc = new PDO(
            'mysql:host='.$GLOBALS['hostname'].';port=3306;dbname='.$GLOBALS['database'],
            $GLOBALS['username'],
            $GLOBALS['password'],
            array(PDO::ATTR_PERSISTENT => true)
        );
        $this->upload = new FileUploadDB($this->dbc);
    }
    
    public function tearDown(){
        unset($this->upload);
    }
    
    public function testExample(){
        $this->markTestIncomplete('This test has not yet been implemented');
    }
}
