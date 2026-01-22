<?php
class ImageHelper
{
    /**
     * Get the full URL/path for a project image
     * Handles both local uploads and external URLs
     * 
     * @param string|null $image_url The image_url from database
     * @return string Full image URL
     */
    public static function getProjectImageUrl($image_url)
    {
        // If no image, return placeholder
        if (empty($image_url)) {
            return 'https://picsum.photos/400/200?default';
        }

        // If it's already a full URL (starts with http:// or https://)
        if (filter_var($image_url, FILTER_VALIDATE_URL)) {
            return $image_url;
        }

        // For local paths from public/ directory, just add ../
        // Remove leading slash if present
        $image_url = ltrim($image_url, '/');
        
        return '../' . $image_url;
    }

    /**
     * Get a fallback image URL for a specific project
     * 
     * @return string Fallback image URL
     */
    public static function getFallbackImageUrl() {
        return 'https://picsum.photos/400/200?default';
    }
}

?>