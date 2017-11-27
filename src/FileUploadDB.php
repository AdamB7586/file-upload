<?php
namespace Upload;

use PDO;

class FileUploadDB extends FileUpload{
    protected $db;
    
    protected $upload_database = 'uploads';
    
    /**
     * Connect to the database
     * @param PDO $dbConnection This should be an instance of the PDO database connection
     */
    public function __construct($dbConnection = NULL) {
        if($dbConnection !== NULL){
            $this->databaseConnect($dbConnection);
        }
    }
    
    /**
     * Gets the database table name
     * @return string This should be the database table name
     */
    public function getTableName() {
        return $this->upload_database;
    }
    
    /**
     * Sets the database table name
     * @param string $table_name This should be the database table name you wist to set as the upload location
     * @return $this
     */
    public function setTableName($table_name) {
        $this->upload_database = $table_name;
        return $this;
    }
    
    /**
     * Adds a database connection to the class (Need to be an instance of a PDO connection)
     * @param PDO $db Add the PDO database connection instance
     * @return $this
     */
    public function databaseConnect(PDO $db) {
        $this->db = $db;
        return $this;
    }
    
    /**
     * Upload an file to the database
     * @param file $file This should be the $_FILES['file']
     * @return boolean Returns true if file uploaded successfully else returns false
     */
    public function uploadFile($file) {
        if($file['name'] && $this->checkMimeTypes($file) && $this->fileExtCheck($file) && $this->fileSizeCheck($file)){
            $query = $this->db->prepare("INSERT INTO `{$this->getTableName()}` (`file`, `type`, `size`, `content`) VALUES (:file, :type, :size, :content);");
            $query->bindParam(':file', $file['name']);
            $query->bindParam(':type', $file['type']);
            $query->bindParam(':size', $file['size']);
            $query->bindParam(':content', file_get_contents($file['tmp_name']));
            return $query->execute();
        }
        return false;
    }
    
    /**
     * Deletes a file from the database that matched the given ID
     * @param int $id This should be the unique ID of the file you wish to delete
     * @return boolean If the file has been deleted will return true else returns false
     */
    public function deleteFileByID($id) {
        if(is_numeric($id)){
            $query = $this->db->prepare("DELETE FROM `{$this->getTableName()}` WHERE `id` = ? LIMIT 1;");
            return $query->execute(array($id));
        }
        return false;
    }
    
    /**
     * Deletes a file from the database that matched the given filename
     * @param string $file This should be the filename of the file you wish to delete
     * @return boolean If the file has been deleted will return true else returns false
     */
    public function deleteFileByName($file) {
        $query = $this->db->prepare("DELETE FROM `{$this->getTableName()}` WHERE `file` = ? LIMIT 1;");
        return $query->execute(array($file));
    }
    
    /**
     * Deletes all files from the database
     * @return boolean If the all records have been removed will return true else return false
     */
    public function deleteAllFiles() {
        $query = $this->db->prepare("TRUNCATE `{$this->getTableName()}`;");
        return $query->execute();
    }
    
    /**
     * List all of the files in the database
     * @return array|false If any records exist will return the array of files else will return false if no records exist
     */
    public function listFiles() {
        $query = $this->db->prepare("SELECT * FROM `{$this->getTableName()}`;");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Returns the file information from the database for a given ID
     * @param int $id This should be the unique ID of the file you want to get the information for
     * @return array|false Will return an array containing the information for the file if the ID exists else will return false if nothing exists
     */
    public function getFileInfoByID($id) {
        if(is_numeric($id)){
            $query = $this->db->prepare("SELECT * FROM `{$this->getTableName()}` WHERE `id` = ? LIMIT 1;");
            $query->execute(array($id));
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    
    /**
     * Returns the file information from the database for a given filename
     * @param string $file This should be the filename of the file you want to get the information for
     * @return array|false Will return an array containing the information for the file if the filename exists else will return false if nothing exists
     */
    public function getFileInfoByName($file) {
        $query = $this->db->prepare("SELECT * FROM `{$this->getTableName()}` WHERE `file` = ? LIMIT 1;");
        $query->execute(array($file));
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Returns the file based on a given ID
     * @param int $id This should be the unique ID of the file you want to get the information for
     * @return file|false If the file exists it will be returned else will return false
     */
    public function viewFileByID($id){
        if(is_numeric($id)){
            $file = $this->getFileInfoByID($id);
            if(!empty($file)){
                $this->setFileContents($file);
            }
        }
        return false;
    }
    
    /**
     * Returns the file based on a given filename
     * @param string $name This should be the filename of the file you want to get the information for
     * @return file|false If the file exists it will be returned else will return false
     */
    public function viewFileByName($name){
        $file = $this->getFileInfoByName($name);
        if($file){
            $this->setFileContents($file);
        }
        return false;
    }
    
    /**
     * Sets all of the headers and returns the content for the file information given
     * @param array $file This should be the file information as an array from the database
     */
    protected function setFileContents($file){
        header("Content-Type: ". $file['type']);
        header("Content-Length: ". $file['size']);
        header("Content-Disposition: attachment; filename=". $file['name']);
        echo($file['content']);
    }
}