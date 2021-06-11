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

/* Form Validation Library */

class form
{
    /* Global Variables */
    protected $formError;
    protected $isValid = false;

    /**
     * Check text input
     * @param 	string $input
     * @return	bool
     **/
    public function is_text($input)
    {
        if (preg_match("/^[a-zA-Z-' ]*$/", $this->post($input))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check email input
     * @param 	string $input
     * @return	bool
     **/
    public function is_email($input)
    {
        if (filter_var($this->post($input), FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check link input
     * @param 	string $input
     * @return	bool
     **/
    public function is_link($input)
    {
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->post($input))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check number input
     * @param 	string $input
     * @return	bool
     **/
    public function is_number($input)
    {
        if (preg_match("/^[0-9]*$/", $this->post($input))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validate input data
     * @param string|array $field Input field
     * @param string|array $rules Validation rules
     **/
    public function validate($field, $rules = null)
    {
        if ($this->method() == "POST") {
            if (is_array($field)) {
                $valid = 0;
                foreach ($field as $key => $value) {
                    $valid += (int)$this->rules($key, $value);
                }

                $this->isValid = (count($field) == $valid) ? TRUE : FALSE;
            } else {
                $this->isValid = $this->rules($field, $rules);
            }

            return $this->isValid;
        }
    }

    /**
     * Check defined rules
     * @return bool
     **/
    protected function rules($field, $rules)
    {
        $valid = 0;
        $rules = str_replace(',', '|', $rules);
        $rules = explode('|', $rules);

        if (isset($_POST[$field])) {
            foreach ($rules as $key => $value) {
                $string = str_replace('[', '|', $value);
                $string = str_replace(']', '|', $string);
                $string = array_filter(explode('|', $string));
                if (count($string) > 1) {
                    switch ($string[0]) {
                        case 'min_length':
                            if (strlen($_POST[$field]) < $string[1]) {
                                $valid--;
                                $this->formError .= "Minimum length of {$field} field is {$string[1]}\n";
                            }
                            break;
                        case 'max_length':
                            if (strlen($_POST[$field]) > $string[1]) {
                                $valid--;
                                $this->formError .= "Maxmimum length of {$field} field is {$string[1]}\n";
                            }
                            break;
						case 'length':
                            if (strlen($_POST[$field]) != $string[1]) {
                                $valid--;
                                $this->formError .= "Required Length of {$field} field is {$string[1]}\n";
                            }
                            break;
						case 'less_than':
                            if ((int)($_POST[$field]) > (int)$string[1]) {
                                $valid--;
                                $this->formError .= "Value of {$field} field should be less than {$string[1]}\n";
                            }
                            break;
						case 'greater_than':
                            if ((int)($_POST[$field]) < (int)$string[1]) {
                                $valid--;
                                $this->formError .= "Value of {$field} field should be greater than {$string[1]}\n";
                            }
                            break;
                        default:
                            $valid--;
                            $this->formError .= "{$value} is not valid rule\n";
                            break;
                    }
                } else {
                    switch ($value) {
                        case 'required':
                            if (empty($_POST[$field])) {
                                $valid--;
                                $this->formError .= "The {$field} field is required\n";
                            }
                            break;
						case 'valid_email':
                            if (!$this->is_email($field)) {
                                $valid--;
                                $this->formError .= "The {$field} field is not contain valid email\n";
                            }
                            break;
						case 'valid_url':
                            if (!$this->is_link($field)) {
                                $valid--;
                                $this->formError .= "The {$field} field is not contain valid URL\n";
                            }
                            break;
						case 'valid_number':
                            if (!$this->is_number($field)) {
                                $valid--;
                                $this->formError .= "The {$field} field is not contain valid number\n";
                            }
                            break;
						case 'valid_text':
                            if (!$this->is_text($field)) {
                                $valid--;
                                $this->formError .= "The {$field} field is not contain valid text\n";
                            }
                            break;
                        default:
                            $valid--;
                            $this->formError .= "{$value} is not valid rule\n";
                            break;
                    }
                }
            }

            return $valid == 0 ? TRUE : FALSE;
        } else {
            trigger_error("The {$field} field is not defined.", E_USER_NOTICE);
        }
    }

    /**
     * Get input data through get request
     * @param 	string $data (input control name)
     * @return	string value
     **/
    public function get($data)
    {
        $data = trim($_GET[$data]);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Get input data through post request
     * @param 	string $data (input control name)
     * @return	string value
     **/
    public function post($data)
    {
        $data = trim($_POST[$data]);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Get request method
     * @return	string
     **/
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get validation status
     * @return	bool
     **/
    public function is_valid()
    {
        return $this->isValid;
    }

    /**
     * Get validation error
     * @return	string
     **/
    public function form_error()
    {
        return $this->formError;
    }
}
