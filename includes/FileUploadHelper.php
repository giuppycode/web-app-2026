<?php
class FileUploadHelper
{
    // Maximum file size in bytes (5MB)
    const MAX_FILE_SIZE = 5 * 1024 * 1024;
    
    // Allowed MIME types
    const ALLOWED_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp'
    ];
    
    // Allowed extensions
    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    
    /**
     * Upload a project image
     * 
     * @param array $file $_FILES array element
     * @return array ['success' => bool, 'path' => string|null, 'error' => string|null]
     */
    public static function uploadProjectImage($file)
    {
        try {
            // Check if file was uploaded
            if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
                return ['success' => false, 'path' => null, 'error' => 'No file uploaded'];
            }

            // Check for upload errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['success' => false, 'path' => null, 'error' => self::getUploadErrorMessage($file['error'])];
            }

            // Validate file size
            if ($file['size'] > self::MAX_FILE_SIZE) {
                return ['success' => false, 'path' => null, 'error' => 'File size exceeds 5MB limit'];
            }

            // Validate MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mime_type, self::ALLOWED_TYPES)) {
                return ['success' => false, 'path' => null, 'error' => 'Invalid file type. Only JPEG, PNG, and WebP images are allowed'];
            }

            // Validate file extension
            $original_name = basename($file['name']);
            $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

            if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
                return ['success' => false, 'path' => null, 'error' => 'Invalid file extension'];
            }

            // Generate unique filename
            $unique_name = self::generateUniqueFilename($extension);
            
            // Define upload directory and path
            $upload_dir = __DIR__ . '/../assets/img/projects/';
            $upload_path = $upload_dir . $unique_name;
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    return ['success' => false, 'path' => null, 'error' => 'Failed to create upload directory'];
                }
            }

            // Check directory permissions
            if (!is_writable($upload_dir)) {
                return ['success' => false, 'path' => null, 'error' => 'Upload directory is not writable'];
            }

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                return ['success' => false, 'path' => null, 'error' => 'Failed to move uploaded file'];
            }

            // Set proper permissions on uploaded file
            chmod($upload_path, 0644);

            // Return relative path for database storage
            $relative_path = 'assets/img/projects/' . $unique_name;
            
            return ['success' => true, 'path' => $relative_path, 'error' => null];

        } catch (Exception $e) {
            return ['success' => false, 'path' => null, 'error' => 'Upload failed: ' . $e->getMessage()];
        }
    }

    /**
     * Generate a unique filename
     * 
     * @param string $extension File extension
     * @return string Unique filename
     */
    private static function generateUniqueFilename($extension)
    {
        return 'project_' . uniqid() . '_' . time() . '.' . $extension;
    }

    /**
     * Get human-readable upload error message
     * 
     * @param int $error_code PHP upload error code
     * @return string Error message
     */
    private static function getUploadErrorMessage($error_code)
    {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'File size exceeds maximum allowed size';
            case UPLOAD_ERR_PARTIAL:
                return 'File was only partially uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing temporary upload directory';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'File upload blocked by extension';
            default:
                return 'Unknown upload error';
        }
    }
}
?>