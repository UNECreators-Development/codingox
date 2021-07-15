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
 * @link		https://codingox.epizy.com
 * @since		Version 1.2.0
 * @filesource
 **/

defined('APP_PATH') or exit('No direct script access allowed');

/* Set error handler to handle all error */
set_error_handler('errorHandler');

function errorHandler($errorNo = 3, $errorMessage = null, $errorFile = null, $errorLine = null, $errorContext = null)
{
    $errorType = [1 => 'Error', 2 => 'Warning', 8 => 'Notice', 256 => 'Error', 512 => 'Warning', 1024 => 'Notice'];
    config['APP_ENV'] != 'production' ? ob_end_clean() : NULL;

    $errorTitle = $errorType[$errorNo];

    if ($errorNo == 256 || $errorNo == 512 || $errorNo == 1024) {
        $errorMessage = "<b class='text-danger'>{$errorType[$errorNo]}:</b>" . " {$errorMessage}";
    } else {
        log_error($errorNo, $errorMessage, $errorFile, $errorLine);
        $errorMessage = "<b class='text-danger'>{$errorType[$errorNo]}:</b>" . " {$errorMessage} in <b>{$errorFile}</b> on line <b class='text-danger'>{$errorLine}</b>";
    }

    ob_start();
    if (config['APP_ENV'] != 'production') {
        require_once(path() . view_path . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . 'error.php');
        exit();
    }
}

if (!function_exists('display_error')) {
    /**
     * Display error
     * @param   int     $code       Response Code
     * @param   string  $message    Error Message
     * @param   string  $title      Page Title
     * @return  Buffer Output
     */
    function display_error($code = 404, $message = 'Page Not Found', $title = 'Page Not Found')
    {
        ob_end_clean();
        require_once(path() . view_path . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . '404.php');
        exit();
    }
}

if (!function_exists('log_error')) {
    /**
     * Create error log
     * @param   int     $code       Error Code
     * @param   string  $message    Error Message
     * @param   string|(optional)   $file       
     * @param   int|(optional)      $line
     * @return  bool
     */
    function log_error($code = 1, $message = null, $file = __FILE__, $line = __LINE__)
    {
        $errorType = [1 => 'Error', 2 => 'Warning', 8 => 'Notice', 256 => 'Error', 512 => 'Warning', 1024 => 'Notice'];

        if (config['APP_ENV'] == 'production') {
            $log_exts = config['LOG_FILE_EXTENSION'] == '' ? '' : '.' . config['LOG_FILE_EXTENSION'];
            $log_path = path() . config['LOG_FILE_PATH'] . '/' . config['LOG_FILE_NAME'] . $log_exts;
            (!file_exists($log_path)) ? fopen($log_path, 'w') : NULL;
            chmod($log_path, config['LOG_FILE_PERMISSION']);

            return error_log("[" . date('M d-Y h:i A') . "] {$errorType[$code]}: {$message} in {$file} on line {$line}\n", 3, $log_path);
        }
    }
}
