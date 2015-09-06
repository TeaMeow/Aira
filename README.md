# Aira
Sometimes you might need to return a false,

but sometimes, you might want to return an error message,

this is Aira should handle.

#Usage
Aira is a static class, so you don't need to construst it.

```php
Aira::FUNCTION()
```

## First - The error handler.

An Aira handler is highly recommended, 

Aira will directly `exit()` if there's no error handler setted.

```php
Aira::SetHandler('HANDLER_FUNCTION_NAME');
```

Aira will pass the following two arguments,

`$Msg` and `$ErrorCode` is the error message and the error code that you setted before,

the handler will be called once the error occurred.

```
HANDLER($Msg, $ErrorCode);
```

## Second - Add the error codes.

You must add the error codes and the error messages before you use Aira,

here's how you add it.

```php
Aira::ErrorCode(['ERROR_CODE'   => 'Error message.',
                 'LOGIN_FAILED' => 'Hey, you entered the wrong password.']);
```

## Thrid - Prepare to die.

**Aira can only handle the known errors**, *and false will be returned by default*.

You should put it to the place where you know the error will occurred,

here's how you call it once the error occurred.

```php
return Aira::Add('ERROR_CODE');
```

For example, if you are dealing with a login system, you should use it like this:

```php
if(!$Login)
    return Aira::Add('LOGIN_FAILED');
```

## Fourth - Deal with the end.

Here's three ways to deal with it once the `Aira::Add()` was called,

1. **Return false**.
2. Exit and output the **last error message**.
3. Exit and output the error message if anything **happened next**.

If you don't get it, we'll talk about that later, 

and here's how you switch to the three modes. Easy.

```php

/** Exit and output the error message if any error occurred AFTER this code. */
Aira::EndFrom();

/** Exit and output the error message if any error occurred BEFORE this code. */
Aira::EndHere();

/** Just keep going, no matter what happened. (Aira will only return FALSE.) */
Aira::Alive();
```

## Real Example

Let's see how should you use it and WHEN.

A login system will be a great example.

```php
/** 1.Add the error code first */
Aira::ErrorCode(['LOGIN_FAILED' => 'Login failed, the username or the password was incorrect.']);

/** 2.Find a moment to die */
function Login($Usr, $Pw)
{
    /** Call Aira if login failed */
    if($Failed)
      return Aira::Add('LOGIN_FAILED');
}

/** Let's login now no matter if logged in failed */
$User->Login($Username, $Password);

/** The error message will be ouputted if user logged in failed */
Aira::EndHere();
  
/** Nothing will be ended if user logged in successfully! */
exit('Logged In successfully!');
```

## Others

You can detect the last error code like this.

```php
Aira::Equals('ERROR_CODE');
```

For example if you want to know the last error is LOGIN_FAILED or something else.

```php
if(Aira::Equals('LOGIN_FAILED'))
{
    exit('You failed at the login part right?');
}
elseif(Aira::Equals('LOGIN_NOTHING'))
{
    exit('Are you tried to what?');
}
```
