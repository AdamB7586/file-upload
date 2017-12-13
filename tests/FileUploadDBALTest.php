<?php
namespace Upload\Tests;

use DBAL\Database;
use Upload\FileUploadDB;
use PHPUnit\Framework\TestCase;

class FileUploadDBALTest extends TestCase {
    
    protected $upload;
    
    public function setUp(){
        $this->dbc = new Database('localhost', 'username', 'password', 'test_db', false, false, true, 'sqlite');
        $this->upload = new FileUploadDB();
        $this->upload->databaseConnect($this->dbc);
    }
    
    public function tearDown(){
        unset($this->upload);
    }
    
    public function testExample(){
        $this->markTestIncomplete('This test has not yet been implemented');
    }
}
