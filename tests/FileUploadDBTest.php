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
            'sqlite::memory:',
            null,
            null,
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
