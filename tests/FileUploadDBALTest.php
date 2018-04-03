<?php
namespace Upload\Tests;

use DBAL\Database;
use Upload\FileUploadDBAL;
use PHPUnit\Framework\TestCase;

class FileUploadDBALTest extends TestCase {
    
    protected $dbc;
    protected $upload;
    
    public function setUp(){
        $this->dbc = new Database($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
        $this->upload = new FileUploadDBAL($this->dbc);
        //$this->upload->databaseConnect();
    }
    
    public function tearDown(){
        unset($this->dbc);
        unset($this->upload);
    }
    
    public function testExample(){
        $this->markTestIncomplete('This test has not yet been implemented');
    }
}
