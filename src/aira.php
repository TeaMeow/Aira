<?php
class Aira
{
    /**
     * Error Names
     *
     * Stores the error names here.
     *
     * @var array
     */

    static $errorNames = [];

    /**
     * Success Names
     *
     * Stores the success names here.
     *
     * @var array
     */

    static $successNames = [];

    /**
     * Errors
     *
     * Occurred errors will be stored in here.
     *
     * @var array
     */

    static $errors     = [];

    /**
     * Last Error
     *
     * The name of the last error.
     *
     * @var bool|string
     */

    static $lastError  = false;

    /**
     * Error Handler
     *
     * The name of the error handler.
     *
     * @var null|string
     */

    static $errorHandler    = null;

    /**
     * Success Handler
     *
     * The name of the error handler.
     *
     * @var null|string
     */

    static $successHandler    = null;

    /**
     * Die
     *
     * Call the error handler if we can die, or just ignore the error when this is false.
     *
     * @var bool
     */

    static $die        = false;




    /**
     * Add
     *
     * Add a error name with the message, and a http status code.
     *
     * @param string $errorName   The name of the error, USERNAME_USED for example.
     * @param string $message     The message of the error.
     * @param int    $httpCode    The http status code of the error.
     */

    static function add($errorName, $message, $httpCode = null)
    {
        self::$errorNames[$errorName] = ['message'  => $message,
                                         'httpCode' => $httpCode];
    }




    /**
     * Error
     *
     * Throw an error.
     *
     * @param string $errorName   The name of the error.
     */

    static function error($errorName, $extraData = null, $showName = false)
    {
        array_push(self::$errors, $errorName);

        self::$lastError = [];
        self::$lastError['errorName'] = $errorName;
        self::$lastError['extraData'] = $extraData;
        self::$lastError['showName']  = $showName;

        if(self::$die)
            self::errorOccurred($extraData, $showName);
    }




    /**
     * Success
     *
     * Call the success handler with the success code name.
     */

    static function success($successName, $extraData = null, $showName = false)
    {
        self::successed($successName, $extraData, $showName);
    }




    /**
     * Add Success
     *
     * Add a success code.
     *
     * @param string $successName   The name of the success, EMAIL_AVAILABLE for example.
     * @param string $message       The message of the success.
     * @param int    $httpCode      The http status code of the success.
     */

    static function addSuccess($successName, $message, $httpCode = null)
    {
        self::$successNames[$successName] = ['message'  => $message,
                                             'httpCode' => $httpCode];
    }




    /**
     * End Or Success
     *
     * Call theEnd() before calling the success().
     *
     * @param string $successName   The name of the success code.
     */

    static function endOrSuccess($successName, $extraData = null, $showName = false)
    {
        self::theEnd($extraData, $showName);
        self::success($successName, $extraData, $showName);
    }




    /**
     * The Start
     *
     * Capture all the errors which below this function.
     */

    static function theStart()
    {
        self::$die = true;
    }




    /**
     * The End
     *
     * Capture all the errors which happened after this function.
     */

    static function theEnd($extraData = null, $showName = false)
    {
        self::$die = true;

        if(self::$lastError !== false)
            self::errorOccurred(self::$lastError['extraData'], self::$lastError['showName']);
    }
    
    
    
    static function endHere($errorName, $extraData = null, $showName = false)
    {
        self::error($errorName, $extraData, $showName);
        self::theEnd();
    }



    /**
     * Get Error
     *
     * Returns an error information by the error name.
     *
     * @param string $errorName  The name of the error.
     */

    static function getError($errorName)
    {
        return isset(self::$errorNames[$errorName]) ? self::$errorNames[$errorName] : ['message'  => 'An unknown Aira error occurred.',
                                                                                       'httpCode' => 403];
    }




    /**
     * Alive
     *
     * Keep Aira alive, so the program won't stop when any error occurred.
     */

    static function alive()
    {
        self::$die = false;
    }




    /**
     * Error Occurred
     *
     * Deal with the error, like call the error handler here.
     */

    static function errorOccurred()
    {
        if(!self::$die)
            return false;

        $error     = self::getError(self::$lastError['errorName']);
        $errorName = self::$lastError['errorName'];
        $message   = $error['message'];
        $httpCode  = $error['httpCode'];

        if(self::$errorHandler === null)
        {
            http_response_code($httpCode);

            header('Content-Type: application/json; charset=utf-8');

            $data            = self::generateData(self::$lastError['extraData']);
            $data['message'] = $message;

            if(self::$lastError['showName'])
                $data['code'] = $errorName;

            exit(json_encode($data, JSON_NUMERIC_CHECK));
        }


        call_user_func_array(self::$errorHandler, [$errorName, $message, $httpCode]);
    }



    static function successed($successName, $extraData = null, $showName = false)
    {
        $success     = self::$successNames[$successName];
        $message     = $success['message'];
        $httpCode    = $success['httpCode'];

        if(self::$successHandler === null)
        {
            http_response_code($httpCode);

            header('Content-Type: application/json; charset=utf-8');

            $data            = self::generateData($extraData);
            $data['message'] = $message;

            if($showName)
                $data['code'] = $successName;

            exit(json_encode($data, JSON_NUMERIC_CHECK));
        }

        call_user_func_array(self::$successHandler, [$successName, $message, $httpCode]);
    }



    static function generateData($extraData = null)
    {
        $data = [];

        if(!$extraData)
            return $data;

        foreach($extraData as $key => $value)
            $data[$key] = $value;

        return $data;
    }




    /**
     * Set Error Handler
     *
     * Set the error handler.
     *
     * @param string $handlerName   The name of the error handler function.
     */

    static function setErrorHandler($handlerName)
    {
        self::$errorHandler = $handlerName;
    }




    /**
     * Set Success Handler
     *
     * Set the success handler.
     *
     * @param string $handlerName   The name of the success handler function.
     */

    static function setSuccessHandler($handlerName)
    {
        self::$successHandler = $handlerName;
    }
}
?>