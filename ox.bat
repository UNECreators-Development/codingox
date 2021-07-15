@REM /**
@REM  * CodingOx
@REM  *
@REM  * An open source application development framework for PHP
@REM  *
@REM  * This content is released under the MIT License (MIT)
@REM  *
@REM  * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
@REM  * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
@REM  * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
@REM  * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
@REM  * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
@REM  * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
@REM  * THE SOFTWARE.
@REM  *
@REM  * @author		Satyendra Sagar Singh
@REM  * @license	https://opensource.org/licenses/MIT	MIT License
@REM  * @link		https://codingox.epizy.com
@REM  * @since		Version 1.2.0
@REM  **/

@ECHO OFF
if "%1" == "" goto :help
if "%1" == "help" goto :help
if "%1" == "serve" goto :serve
if "%1" == "create" goto :create

:serve
cls
title Codingox
echo [41m[96m-----------------------------------------------------------
echo ------------------------ Codingox -------------------------
echo -----------------------------------------------------------[0m
echo [47m[94m         @author       Satyendra Sagar Singh               
echo          @link         https://codingox.epizy.com          
echo          @since        Version 2.0.0                       
echo [42m[96m-----------------------------------------------------------
echo -----------------------------------------------------------
echo -----------------------------------------------------------[0m
echo.
start http://localhost:8080
php -S localhost:8080
exit /b 0

:create
if "%2" == "" goto :createHelp
if "%2" == "controller" goto :controller
if "%2" == "model" goto :model
if "%2" == "view" goto :view
exit /b 0

:controller
if "%3" == "" (goto :default) else (goto :createController)
exit /b 0

:model
if "%3" == "" (goto :default) else (goto :createModel)
exit /b 0

:view
if "%3" == "" (goto :default) else (goto :createView)
exit /b 0

:createController
if exist controllers/"%3".php (echo %3.php already exist) else (break>"controllers/%3.php")
exit /b 0

:createModel
if exist models/"%3".php (echo %3.php already exist) else (break>"models/%3.php")
exit /b 0

:createView
if exist views/"%3".php (echo %3.php already exist) else (break>"views/%3.php")
exit /b 0

:default
echo use "create 'TYPE (controller, model, view)' <File Name>"
exit /b 0

:help
echo [96m-------------------------------------
echo --------------- Help ----------------
echo -------------------------------------
echo 1. serve  - Start development server
echo 2. create - Create file in directory
echo -------------------------------------
echo -------------------------------------[0m
exit /b 0

:createHelp
echo [96m-------------------------------------
echo -------------- Create ---------------
echo -------------------------------------
echo 1. controller  - New controller
echo 2. model       - New model
echo 2. view        - New View
echo -------------------------------------
echo -------------------------------------[0m
exit /b 0
