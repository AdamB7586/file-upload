<?php
namespace Upload;

use finfo;

class FileUpload{
    protected $errorNo;
    protected static $rootFolder;
    
    protected static $fileFolder = 'files/';
    
    public $maxFileSize = 9000000;
    public $fileSize = 0;
    public $allowedExt = array('pdf', 'doc', 'docx', 'zip', 'png', 'jpg', 'jpeg', 'gif', 'odt');
    
    protected $fileInfo = false;
    
    protected $mime_types = array(
        'txt' => 'text/plain',
        'pdf' => 'application/pdf',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // ms office
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    /**
     * Constructor
     */
    public function __construct($folder = NULL) {
        if($folder === NULL){
            $folder = getcwd().DIRECTORY_SEPARATOR;
        }
        $this->setRootFolder($folder);
    }
    
    /**
     * Getter Will return one of the class variables based on the parameters
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        return $this->$name;
    }
    
    /**
     * Setter Will set the class variables based on the parameters given
     * @param string $name This should be the variable name
     * @param mixed $value This should be the value you wish to assign to the variable
     * @return $this
     */
    public function __set($name, $value) {
        if(isset($this->$name)) {
            $this->$name = $value;
        }
        return $this;
    }
    
    /**
     * Sets the maximum file filesize that should be uploaded in bytes
     * @param int $bytes The should be the maximum filesize in bytes
     * @return $this
     */
    public function setMaxFileSize($bytes) {
        if(is_numeric($bytes)){
            $this->maxFileSize = intval($bytes);
        }
        return $this;
    }
    
    /**
     * Returns the maximum filesize that is allowed to be uploaded in bytes 
     * @return int The number of bytes will be returned
     */
    public function getMaxFileSize() {
        return $this->maxFileSize;
    }
    
    /**
     * Sets the root folder where the files folder can be located
     * @param string $folder This should be the file location where files are uploaded to
     */
    public function setRootFolder($folder) {
        self::$rootFolder = $folder;
        return $this;
    }
    
    /**
     * Returns the root folder where all files will be uploaded to
     * @return string This will be the upload directory
     */
    public function getRootFolder() {
        return self::$rootFolder;
    }
    
    /**
     * Sets the allowed extensions that can be uploaded
     * @param array $extensions This should be an array containing all of the extensions you want to allow
     * @return $this Returns the object so method chaining can take place
     */
    public function setAllowedExtensions($extensions){
        if(is_array($extensions)){
            $this->allowedExt = $extensions;
        }
        return $this;
    }
    
    /**
     * Adds extensions to the current array of allowed extensions
     * @param array $extensions This should be an array containing all of the extensions you want to add to the allowed list
     * @return $this Returns the object so method chaining can take place
     */
    public function addAllowedExtensions($extensions){
        if(is_array($extensions)){
            $this->allowedExt = array_unique(array_merge($this->allowedExt, $extensions));
        }
        return $this;
    }
    
    /**
     * Returns an array of the allowed extensions that can be uploaded
     * @return array This will be an array of the allowed extensions
     */
    public function getAllowedExtensions(){
        if(is_array($this->allowedExt)){
            return $this->allowedExt;
        }
        return array();
    }
    
    /**
     * Set the folder where the files will be uploaded to 
     * @param string $folder This should be the name of the folder that the main files will be uploaded to
     * @return $this
     */
    public function setFileFolder($folder) {
        self::$fileFolder = $folder;
        return $this;
    }
    
    /**
     * Returns folder where the files will be uploaded
     * @return string Will return the folder where the main files will be uploaded
     */
    public function getFileFolder(){
        return self::$fileFolder;
    }
    
    /**
     * Upload an file to the server
     * @param file $file This should be the $_FILES['file']
     * @return boolean Returns true if file uploaded successfully else returns false
     */
    public function uploadFile($file) {
        if($this->checkFileName($file['name'])){
            $this->checkDirectoryExists($this->getRootFolder().$this->getFileFolder());
            if($this->checkMimeTypes($file) && $this->fileExtCheck($file) && $this->fileSizeCheck($file) && !$this->fileExist($file)){
                if(move_uploaded_file($file['tmp_name'], $this->getRootFolder().$this->getFileFolder().basename($this->checkFileName($file['name'])))){
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * Delete and file from the server
     * @param string $file This should be the file name with extension
     * @return boolean Returns true if deleted else returns false
     */
    public function deleteFile($file) {
        if(file_exists($this->getRootFolder().$this->getFileFolder().$this->checkFileName($file["name"]))){
            unlink($this->getRootFolder().$this->getFileFolder().$this->checkFileName($file["name"]));
            return true;
        }
        return false;
    }
    
    /**
     * Deletes all files form the directory
     */
    public function deleteAllFiles() {
        foreach($this->listFiles() as $file){
            unlink($this->getRootFolder().$this->getFileFolder().$file);
        }
    }
    
    /**
     * List all of the files in the files directory
     * @return array Will return an array containing all of the files in the files directory
     */
    public function listFiles() {
        $files = scandir($this->getRootFolder().$this->getFileFolder());
        foreach($files as $key => $file){
            if(is_dir($this->getRootFolder().$this->getFileFolder().$file)){
                unset($files[$key]);
            }
        }
        return $files;
    }
    
    /**
     * Checks to see if the file is a real file
     * @param file $file This should be the $_FILES['file']
     * @return string|boolean If the file is real the mime type will be returned else will return false
     */
    protected function checkMimeTypes($file) {
        $fileInfo = new finfo();
        $mimeType = $fileInfo->file($file["tmp_name"], FILEINFO_MIME_TYPE);
        if($this->mime_types[strtolower(end((explode(".", $file["name"]))))] === strtolower($mimeType)) {
           return true;
        }
        $this->errorNo = 1;
        return false;
    }
    
    /**
     * Checks to see if the file is within the allowed size limit
     * @param file $file This should be the $_FILES['file']
     * @return boolean Returns true if allowed size else returns false
     */
    protected function fileSizeCheck($file) {
        if($file['size'] > $this->maxFileSize) {
            $this->fileSize = $file['size'];
            return false;
        }
        $this->errorNo = 2;
        return true;
    }
    
    /**
     * Checks to see if the file has one of the allowed extensions
     * @param file $file This should be the $_FILES['file']
     * @return boolean Returns true if allowed else returns false
     */
    protected function fileExtCheck($file) {
        $fileType = strtolower(end((explode(".", $file["name"]))));
        if(in_array($fileType, $this->allowedExt)) {
            return true;
        }
        $this->errorNo = 3;
        return false;
    }
    
    /**
     * Checks to see if a file with the same name already exists on the server
     * @param file $file This should be the $_FILES['file']
     * @return boolean Returns true if file exists else return false
     */
    protected function fileExist($file) {
        if(file_exists($this->getRootFolder().$this->getFileFolder().basename($file["name"]))){
            $this->errorNo = 4;
            return true;
        }
        return false;
    }
    
    /**
     * Checks to see if a directory exists if not it creates it
     * @param string $directory The location of the directory
     */
    protected function checkDirectoryExists($directory) {
        if(!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }
    
    /**
     * Returns the error message for file upload problems
     * @return string Returns the error message
     */
    public function getErrorMsg() {
        $errors = array(
            0 => 'An error occured while adding the file. Please try again!',
            1 => 'The file is not a valid file format',
            2 => 'The file is too large to upload please make sure your file is smaller than '. number_format(($this->maxFileSize / 100000), 2).'MB in size, your file is '.$this->fileSize,
            3 => 'The file is not allowed! Please make sure your file has of of the allowed extensions',
            4 => 'The file with this name has already been uploaded or already exists on our server!'
        );
        return $errors[intval($this->errorNo)];
    }
    
    /**
     * Remove any invalid characters from the filename
     * @param string $name This should be the original filename
     * @return string The filename will be returned with any invalid characters removed
     */
    protected function checkFileName($name){
        return preg_replace('/[^a-z0-9-_]/i', '', $name);
    }
}
