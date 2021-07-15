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

/* Email Helper */

if (!function_exists('send_mail')) {
    /**
     * Send Mail
     * @param   string $to 
     * @param   string $body Email Message
     * @param   string|(optional) $subject
     * @return  bool
     **/
    function send_mail(string $to, string $body, string $subject = null)
    {
        $message = "\r\n";
        $message .= "{$body}\r\n";
        $headers = "From: noreply@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        
        return mail($to, $subject, $message, $headers);
    }
}

if (!function_exists('valid_mail')) {
    /**
     * Check valid mail
     * @param   string $mail
     * @return  bool 
     **/
    function valid_mail(string $mail)
    {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return TRUE;
        }

        return FALSE;
    }
}
