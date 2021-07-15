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

/* API Request Library */

class api
{
    /**
     * POST Request
     * @param   string|array|(optional) $field (Request fields name)
     * @return  property|array 
     */
    public function requestPost(...$field)
    {
        return $this->get_post_request($field, $_POST);
    }

    /**
     * GET Request
     * @param   string|array|(optional) $field (Request fields name)
     * @return  property|array 
     */
    public function requestGet(...$field)
    {
        return $this->get_post_request($field, $_GET);
    }

    /**
     * JSON Request
     * @return  property|array
     */
    public function requestJson()
    {
        $result     = array();
        $jsonData   = json_decode(file_get_contents("php://input"), true);

        foreach ($jsonData as $key => $value) {
            $this->{$key} = $value;
            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * Request
     * @param   string|array|(optional) $field (Request fields name)
     * @return  property|array 
     */
    public function request(...$field)
    {
        return $this->get_post_request($field, $_REQUEST);
    }

    /**
     * All Request
     * @return  property|array
     */
    public function requestAll()
    {
        $method     = $_SERVER['REQUEST_METHOD'];
        $jsonData   = json_decode(file_get_contents("php://input"), true);

        if ($jsonData != null) {
            $this->requestJson();
        } else {
            if ($method == 'POST') {
                return $this->get_post_request(null, $_POST);
            } else if ($method == 'GET') {
                return $this->get_post_request(null, $_GET);
            } else {
                return $this->get_post_request(null, $_REQUEST);
            }
        }
    }

    /**
     * Get, Post, Request
     * @param   string|array|(optional)     $field
     * @param   array                       $method
     * @return  property|array
     */
    protected function get_post_request($field, $method = null)
    {
        $fields = array();
        if ($field != null) {
            if (is_array($field[0])) {
                foreach ($field[0] as $key => $value) {
                    $this->{$value} = $method[$value];
                    $fields[$value] = $method[$value];
                }

                return $fields;
            } else {
                foreach ($field as $key => $value) {
                    $this->{$value} = $method[$value];
                    $fields[$value] = $method[$value];
                }

                return $fields;
            }
        } else {
            foreach ($method as $key => $value) {
                $this->{$key} = $value;
                $fields[$key] = $value;
            }

            return $fields;
        }
    }

    /**
     * API Response
     * @param   array   $data
     * @param   int     $code
     * @return  json
     */
    public function response($data, int $code = 200)
    {
        header('Content-Type: application/json');
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('status' => false, 'message' => 'Failure'));
        }
    }
}
