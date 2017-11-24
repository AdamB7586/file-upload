<?php
namespace Upload\Tests;

use Upload\FileUploadDB;
use PHPUnit\Framework\TestCase;

class FileUploadDBTest extends TestCase {
    
    protected $upload;
    
    public function setUp(){
        $this->upload = new FileUploadDB();
    }
    
    public function tearDown(){
        unset($this->upload);
    }
    
    public function testExample(){
        $this->markTestIncomplete('This test has not yet been implemented');
    }
}
