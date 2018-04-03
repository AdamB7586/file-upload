<?php
namespace Upload\Tests;

use Upload\FileUpload;
use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase {
    
    protected $upload;
    
    protected function setUp() {
        $this->upload = new FileUpload();
    }
    
    protected function tearDown() {
        unset($this->upload);
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::__get
     * @covers Upload\FileUpload::__set
     */
    public function testGettersAndSetters() {
        $this->markTestIncomplete();
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::getMaxFileSize
     * @covers Upload\FileUpload::setMaxFileSize
     */
    public function testMaxFileSize() {
        $this->assertEquals(9000000, $this->upload->getMaxFileSize());
        $this->assertObjectHasAttribute('maxFileSize', $this->upload->setMaxFileSize('rfhjjdf'));
        $this->assertEquals(9000000, $this->upload->getMaxFileSize());
        $this->assertObjectHasAttribute('maxFileSize', $this->upload->setMaxFileSize(false));
        $this->assertEquals(9000000, $this->upload->getMaxFileSize());
        $this->assertObjectHasAttribute('maxFileSize', $this->upload->setMaxFileSize(10000000));
        $this->assertEquals(10000000, $this->upload->getMaxFileSize());
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::setRootFolder
     * @covers Upload\FileUpload::getRootFolder
     */
    public function testSetRootFolder() {
        $this->markTestIncomplete();
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::setFileFolder
     * @covers Upload\FileUpload::getFileFolder
     */
    public function testSetFileFolder() {
        $this->markTestIncomplete();
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::setAllowedExtensions
     * @covers Upload\FileUpload::getAllowedExtensions
     */
    public function testSetAllowedExtensions() {
        $this->markTestIncomplete();
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::addAllowedExtensions
     * @covers Upload\FileUpload::getAllowedExtensions
     */
    public function testAddAllowedExtension() {
        $this->markTestIncomplete();
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::checkFileName
     * @covers Upload\FileUpload::checkDirectoryExists
     * @covers Upload\FileUpload::getRootFolder
     * @covers Upload\FileUpload::getFileFolder
     * @covers Upload\FileUpload::checkMimeTypes
     * @covers Upload\FileUpload::fileExtCheck
     * @covers Upload\FileUpload::fileSizeCheck
     * @covers Upload\FileUpload::fileExist
     * @covers Upload\FileUpload::getErrorMsg
     */
    public function testUploadFile() {
        $this->markTestIncomplete();
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::listFiles
     * @covers Upload\FileUpload::getRootFolder
     * @covers Upload\FileUpload::getFileFolder
     */
    public function testListFiles() {
        $this->markTestIncomplete();
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::deleteFile
     * @covers Upload\FileUpload::getRootFolder
     * @covers Upload\FileUpload::getFileFolder
     */
    public function testDeleteFile() {
        $this->markTestIncomplete();
    }
    
    /**
     * @covers Upload\FileUpload::__construct
     * @covers Upload\FileUpload::deleteAllFiles
     * @covers Upload\FileUpload::listFiles
     * @covers Upload\FileUpload::getRootFolder
     * @covers Upload\FileUpload::getFileFolder
     */
    public function testDeleteAllFiles() {
        $this->markTestIncomplete();
    }
}
