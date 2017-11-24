<?php
namespace Upload\Tests;

use Upload\FileUpload;
use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase {
    
    protected $upload;
    
    public function setUp(){
        $this->upload = new FileUpload();
    }
    
    public function tearDown(){
        unset($this->upload);
    }
    
    public function testExample(){
        $this->markTestIncomplete('This test has not yet been implemented');
    }
    
}
