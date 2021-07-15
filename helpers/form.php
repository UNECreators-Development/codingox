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

/* Form & Input Control Helper */

if (!function_exists('form_open')) {
	/** 
	 * Form opening tag
	 * @param 	string|array $arg attribute 
	 * @return	string form tag
	 **/
	function form_open(...$arg)
	{
		$prop = "";
		if ($arg != null) {
			if (is_array($arg[0])) {
				foreach ($arg[0] as $key => $value) {
					$prop .= $key . '=' . '"' . $value . '" ';
				}
				return "<form {$prop}>\n";
			} else {
				switch (count($arg)) {
					case 0:
						return '<form action="" method="post">' . "\n";
					case 1:
						return '<form action="' . $arg[0] . '" method="post">' . "\n";
					case 2:
						return '<form action="' . $arg[0] . '" method="post" class="' . $arg[1] . '">' . "\n";
					case 3:
						return '<form action="' . $arg[0] . '" method="post" class="' . $arg[1] . '" id="' . $arg[2] . '">' . "\n";
				}
			}
		} else {
			return '<form action="" method="post">' . "\n";
		}
	}
}

if (!function_exists('form_media')) {
	/** 
	 * Form opening tag enctype
	 * @param 	string|array $arg attribute 
	 * @return	string form tag
	 **/
	function form_media(...$arg)
	{
		$prop = "";
		if ($arg != null) {
			if (is_array($arg[0])) {
				foreach ($arg[0] as $key => $value) {
					$prop .= $key . '=' . '"' . $value . '" ';
				}
				return '<form ' . $prop . ' enctype="multipart/form-data">' . "\n";
			} else {
				switch (count($arg)) {
					case 0:
						return '<form action="" method="post" enctype="multipart/form-data">' . "\n";
					case 1:
						return '<form action="' . $arg[0] . '" method="post" enctype="multipart/form-data">' . "\n";
					case 2:
						return '<form action="' . $arg[0] . '" method="post" class="' . $arg[1] . '" enctype="multipart/form-data">' . "\n";
					case 3:
						return '<form action="' . $arg[0] . '" method="post" class="' . $arg[1] . '" id="' . $arg[2] . '" enctype="multipart/form-data">' . "\n";
				}
			}
		} else {
			return '<form action="" method="post" enctype="multipart/form-data">' . "\n";
		}
	}
}

if (!function_exists('form_close')) {
	/** 
	 * Form closing tag
	 * @return	string form tag
	 **/
	function form_close()
	{
		return "</form>\n";
	}
}

if (!function_exists('form_input')) {
	/** 
	 * Form input tag
	 * @param 	string|array $arg attribute 
	 * @return	string input tag
	 **/
	function form_input(...$arg)
	{
		$prop = "";
		if ($arg != null) {
			if (is_array($arg[0])) {
				foreach ($arg[0] as $key => $value) {
					$prop .= $key . '=' . '"' . $value . '" ';
				}
				return "<input {$prop} />\n";
			} else {
				switch (count($arg)) {
					case 0:
						return '<input type="text" name="" />' . "\n";
					case 1:
						return '<input type="' . $arg[0] . '" name="" />' . "\n";
					case 2:
						return '<input type="' . $arg[0] . '" name="' . $arg[1] . '" />' . "\n";
					case 3:
						return '<input type="' . $arg[0] . '" name="' . $arg[1] . '" class="' . $arg[2] . '" />' . "\n";
					case 4:
						return '<input type="' . $arg[0] . '" name="' . $arg[1] . '" class="' . $arg[2] . '" id="' . $arg[3] . '" />' . "\n";
					case 5:
						return '<input type="' . $arg[0] . '" name="' . $arg[1] . '" class="' . $arg[2] . '" id="' . $arg[3] . '" placeholder="' . $arg[4] . '" />' . "\n";
					case 6:
						return '<input type="' . $arg[0] . '" name="' . $arg[1] . '" class="' . $arg[2] . '" id="' . $arg[3] . '" placeholder="' . $arg[4] . '" value="' . $arg[5] . '" />' . "\n";
				}
			}
		} else {
			return '<input type="text" name="" />' . "\n";
		}
	}
}

if (!function_exists('form_button')) {
	/** 
	 * Form button tag
	 * @param 	string|array $arg attribute 
	 * @return	string button tag
	 **/
	function form_button(...$arg)
	{
		$prop = "";
		if ($arg != null) {
			if (is_array($arg[0])) {
				foreach ($arg[0] as $key => $value) {
					$prop .= $key . '=' . '"' . $value . '" ';
				}
				return "<button {$prop} ></button>\n";
			} else {
				switch (count($arg)) {
					case 0:
						return "<button>Button</button>\n";
					case 1:
						return '<button type="button">' . $arg[0] . '</button>' . "\n";
					case 2:
						return '<button type="' . $arg[1] . '">' . $arg[0] . '</button>' . "\n";
					case 3:
						return '<button type="' . $arg[1] . '" id="' . $arg[2] . '">' . $arg[0] . '</button>' . "\n";
					case 4:
						return '<button type="' . $arg[1] . '" id="' . $arg[2] . '" class="' . $arg[3] . '">' . $arg[0] . '</button>' . "\n";
					case 5:
						return '<button type="' . $arg[1] . '" id="' . $arg[2] . '" class="' . $arg[3] . '" value="' . $arg[4] . '">' . $arg[0] . '</button>' . "\n";
				}
			}
		} else {
			return "<button>Button</button>\n";
		}
	}
}

if (!function_exists('form_select')) {
	/** 
	 * Form select tag
	 * @param 	array $arg attribute 
	 * @param 	string|array $option value 
	 * @return	string select tag
	 **/
	function form_select($arg, ...$option)
	{
		$opt = "";
		$prop = "";
		foreach ($option as $key => $value) {
			$opt .= "\t<option>{$value}</option>\n";
		}

		if (array_key_first($arg) != "0") {
			foreach ($arg as $key => $value) {
				$prop .= $key . '=' . '"' . $value . '" ';
			}
			return "<select {$prop}>\n{$opt}</select>\n";
		} else {
			switch (count($arg)) {
				case 0:
					return '<select>' . "\n" . $opt . '</select>' . "\n";
				case 1:
					return '<select name="' . $arg[0] . '">' . "\n" . $opt . '</select>' . "\n";
				case 2:
					return '<select name="' . $arg[0] . '" class="' . $arg[1] . '">' . "\n" . $opt . '</select>' . "\n";
				case 3:
					return '<select name="' . $arg[0] . '" class="' . $arg[1] . '" id="' . $arg[2] . '">' . "\n" . $opt . '</select>' . "\n";
			}
		}
	}
}

if (!function_exists('form_textarea')) {
	/** 
	 * Form textarea tag
	 * @param 	string|array $arg attribute 
	 * @return	string textarea tag
	 **/
	function form_textarea(...$arg)
	{
		$prop = "";
		$text = "";
		if ($arg != null) {
			if (is_array($arg[0])) {
				foreach ($arg[0] as $key => $value) {
					if ($key == "value") {
						$text = $value;
					} else {
						$prop .= $key . '=' . '"' . $value . '" ';
					}
				}
				return "<textarea {$prop} >{$text}</textarea>\n";
			} else {
				switch (count($arg)) {
					case 0:
						return "<textarea></textarea>\n";
					case 1:
						return '<textarea>' . $arg[0] . '</textarea>' . "\n";
					case 2:
						return '<textarea id="' . $arg[1] . '">' . $arg[0] . '</textarea>' . "\n";
					case 3:
						return '<textarea id="' . $arg[1] . '" class="' . $arg[2] . '">' . $arg[0] . '</textarea>' . "\n";
					case 4:
						return '<textarea id="' . $arg[1] . '" class="' . $arg[2] . '" rows="' . $arg[3] . '">' . $arg[0] . '</textarea>' . "\n";
					case 5:
						return '<textarea id="' . $arg[1] . '" class="' . $arg[2] . '" rows="' . $arg[3] . '" cols="' . $arg[4] . '">' . $arg[0] . '</textarea>' . "\n";
				}
			}
		} else {
			return "<textarea></textarea>\n";
		}
	}
}
