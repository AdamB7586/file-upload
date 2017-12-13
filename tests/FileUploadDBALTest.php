<?php
namespace Upload\Tests;

use DBAL\Database;
use Upload\FileUploadDBAL;
use PHPUnit\Framework\TestCase;

class FileUploadDBALTest extends TestCase {
    
    protected $dbc;
    protected $upload;
    
    public function setUp(){
        $this->dbc = new Database('localhost', 'username', 'password', 'test_db', false, false, true, 'sqlite');
        $this->upload = new FileUploadDBAL($this->dbc);
        //$this->upload->databaseConnect();
    }
    
    public function tearDown(){
        unset($this->upload);
    }
    
    public function testExample(){
        $this->markTestIncomplete('This test has not yet been implemented');
    }
}
