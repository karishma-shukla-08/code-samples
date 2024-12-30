<?php
/**
 * Calculates the total size of a directory, including subdirectories and files.
 *
 * @param string $directory Path to the directory.
 * @return int Total size of the directory in bytes.
 * @throws Exception If the directory does not exist or is not readable.
 *
 * Example usage:
 * $size = getDirectorySize('/path/to/directory');
 * echo "Directory size: " . $size . " bytes";
 */
function getDirectorySize(string $directory): int {
    if (!is_dir($directory)) {
        throw new Exception("Invalid directory: $directory");
    }

    $size = 0;
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $filePath = $directory . DIRECTORY_SEPARATOR . $file;

        if (is_file($filePath)) {
            $size += filesize($filePath);
        } elseif (is_dir($filePath)) {
            $size += getDirectorySize($filePath); // Recursive call for subdirectories
        }
    }

    return $size;
}
