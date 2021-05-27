<?php

/**
 * CodingOx
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author		Satyendra Sagar Singh
 * @license		https://opensource.org/licenses/MIT	MIT License
 * @link		http://framework.upgradeads.in
 * @since		Version 1.0.0
 * @filesource
 **/

defined('APP_PATH') or exit('No direct script access allowed');

/* File Helper */

if (!function_exists('read_file')) {
    /** 
     * Read File
     * @param 	string $file Path to file
     * @return	string File Contents
     **/
    function read_file($file)
    {
        return @file_get_contents($file);
    }
}

if (!function_exists('write_file')) {
    /** 
     * Write File
     * @param	string	$file	File path
     * @param	string	$data	Data to write
     * @param	string	$mode	fopen() mode (default: 'wb')
     * @return	bool
     **/
    function write_file($file, $data, $mode = 'wb')
    {
        if (!$fp = @fopen($file, $mode)) {
            return FALSE;
        }

        flock($fp, LOCK_EX);

        for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result) {
            if (($result = fwrite($fp, substr($data, $written))) === FALSE) {
                break;
            }
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        return is_int($result);
    }
}

if (!function_exists('delete_file')) {
    /**
     * Delete Files 
     * @param	string $file File path
     * @return	bool
     **/
    function delete_file($file)
    {
        if (!is_dir($file) && !is_link($file)) {
            @unlink($file);
            return TRUE;
        }

        return FALSE;
    }
}

if (!function_exists('get_filename')) {
    /** 
     * Get Filenames
     * @param	string	path to source
     * @param	bool	whether to include the path as part of the filename
     * @param	bool	internal variable to determine recursion status - do not use in calls
     * @return	array
     **/
    function get_filename($source_dir, $include_path = FALSE, $_recursion = FALSE)
    {
        static $_filedata = array();

        if ($fp = @opendir($source_dir)) {
            if ($_recursion === FALSE) {
                $_filedata = array();
                $source_dir = rtrim(realpath($source_dir), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            }

            while (FALSE !== ($file = readdir($fp))) {
                if (is_dir($source_dir . $file) && $file[0] !== '.') {
                    get_filename($source_dir . $file . DIRECTORY_SEPARATOR, $include_path, TRUE);
                } elseif ($file[0] !== '.') {
                    $_filedata[] = ($include_path === TRUE) ? $source_dir . $file : $file;
                }
            }

            closedir($fp);
            return $_filedata;
        }

        return FALSE;
    }
}

if (!function_exists('get_file_info')) {
    /** 
     * Get File Info
     * @param	string	path to file
     * @param	mixed	array or comma separated string of information returned
     * @return	array
     **/
    function get_file_info($file, $returned_values = array('name', 'server_path', 'size', 'date'))
    {
        if (!file_exists($file)) {
            return FALSE;
        }

        if (is_string($returned_values)) {
            $returned_values = explode(',', $returned_values);
        }

        foreach ($returned_values as $key) {
            switch ($key) {
                case 'name':
                    $fileinfo['name'] = basename($file);
                    break;
                case 'server_path':
                    $fileinfo['server_path'] = $file;
                    break;
                case 'size':
                    $fileinfo['size'] = filesize($file);
                    break;
                case 'date':
                    $fileinfo['date'] = filemtime($file);
                    break;
                case 'readable':
                    $fileinfo['readable'] = is_readable($file);
                    break;
                case 'writable':
                    $fileinfo['writable'] = is_writable($file);
                    break;
                case 'executable':
                    $fileinfo['executable'] = is_executable($file);
                    break;
                case 'fileperms':
                    $fileinfo['fileperms'] = fileperms($file);
                    break;
            }
        }

        return $fileinfo;
    }
}
