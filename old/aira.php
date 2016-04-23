<?php

/**
 * Aira Static Class
 *
 * @category  Tools
 * @package   Aira
 * @author    Yami Odymel <yamiodymel@gmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @link      http://github.com/TeaMeow/Aira
 * @version   1.0
 **/

class Aira
{
    /** Die if we catched an exception. */
    public static $Die           = false;
    public static $Errors        = [];
    public static $LastError     = '';
    public static $Handler       = NULL;

    public static $ErrorMsgs     = [];



    /**
     * The End
     *
     * Just die if any error occurred.
     */

    public static function EndHere()
    {
        self::$Die = true;

        if(self::$LastError != '')
            self::Handler(self::$LastError);
    }




    /**
     * End From
     *
     * Just die if any error occurred FROM NOW ON.
     */

    public static function EndFrom()
    {
        self::$LastError = '';
        self::$Errors    = [];
        self::$Die = true;
    }




    /**
     * Error Codes
     *
     * Add the error codes.
     *
     * @param array $ErrorCodes   The
     */

    public static function ErrorCode($ErrorCodes)
    {
        self::$ErrorMsgs = $ErrorCodes;
    }



    /**
     * Equals
     *
     * If eq
     */

    public static function Equals($ErrorCode)
    {
        return self::$LastError == $ErrorCode;
    }




    /**
     * Alive
     *
     * Keep alive even error occurred.
     */

    public static function Alive()
    {
        self::$Die = false;
    }




    /**
     * Add
     *
     * Add an error.
     */

    public static function Add($ErrorCode, $Message=NULL, $Return=false)
    {
        self::$Errors[] = $ErrorCode;
        self::$LastError = $ErrorCode;

        if(self::$Die && self::$LastError != '')
            self::Handler(self::$LastError);

        return $Return;
    }




    /**
     * Set Handler
     *
     * Set a error handler.
     *
     * @param string $FunctionName   The name of the function which we want it to be the handler.
     */

    public static function SetHandler($FunctionName)
    {
        self::$Handler = $FunctionName;
    }




    /**
     * Handler
     *
     * The error exception handler.
     *
     * @param mixed $Exception   The exception that we catched.
     */

    public static function Handler($ErrorCode)
    {
        if(!self::$Die)
            return;

        $Msg = isset(self::$ErrorMsgs[$ErrorCode]) ? self::$ErrorMsgs[$ErrorCode] : 'Unknown error occurred.';

        if(self::$Handler !== NULL)
            call_user_func_array(self::$Handler, [$Msg, $ErrorCode]);
        else
            exit($Msg);
    }
}
?>
