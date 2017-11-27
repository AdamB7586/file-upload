<?php
namespace Upload;

use DBAL\Database;

class FileUploadDBAL extends FileUpload{
    protected $db;
    
    protected $upload_database = 'uploads';
    
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
    public function databaseConnect(Database $db) {
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
            return $this->db->insert($this->getTableName(), array('file' => $file['name'], 'type' => $file['type'], 'size' => $file['size'], 'content' => file_get_contents($file['tmp_name'])));
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
            return $this->db->delete($this->getTableName(), array('id' => $id));
        }
        return false;
    }
    
    /**
     * Deletes a file from the database that matched the given filename
     * @param string $file This should be the filename of the file you wish to delete
     * @return boolean If the file has been deleted will return true else returns false
     */
    public function deleteFileByName($file) {
        return $this->db->delete($this->getTableName(), array('file' => $file));
    }
    
    /**
     * Deletes all files from the database
     * @return boolean If the all records have been removed will return true else return false
     */
    public function deleteAllFiles() {
        return $this->db->truncate($this->getTableName());
    }
    
    /**
     * List all of the files in the database
     * @return array|false If any records exist will return the array of files else will return false if no records exist
     */
    public function listFiles() {
        return $this->db->selectAll($this->getTableName());
    }
    
    /**
     * Returns the file information from the database for a given ID
     * @param int $id This should be the unique ID of the file you want to get the information for
     * @return array|false Will return an array containing the information for the file if the ID exists else will return false if nothing exists
     */
    public function getFileInfoByID($id) {
        if(is_numeric($id)){
            return $this->db->select($this->getTableName(), array('id' => $id));
        }
        return false;
    }
    
    /**
     * Returns the file information from the database for a given filename
     * @param string $file This should be the filename of the file you want to get the information for
     * @return array|false Will return an array containing the information for the file if the filename exists else will return false if nothing exists
     */
    public function getFileInfoByName($file) {
        return $this->db->select($this->getTableName(), array('file' => $file));
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