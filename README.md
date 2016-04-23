<p align="center">
  <img src="http://imgur.com/"/>
</p>
<p align="center">
  <i>The way about how you die.</i>
</p>

&nbsp;

# Aira

艾拉是一個用來在 PHP 中回傳錯誤訊息的好選擇，

倘若你有時候可能要回傳 `False`，有時候又希望是錯誤訊息，這個時候你就可以使用艾拉。

&nbsp;

# 特色

1. 支援錯誤代碼。

2. 可只回傳 False。

3. 支援自訂錯誤監聽者。

4. 隨時決定要直接輸出錯誤，或者是僅 False。

&nbsp;

# 範例

假設你正在設計一套登入系統，首先你需要先自定錯誤代碼。

```php
Aira::addError('USERNAME_USED', '帳號已被使用。', 409);
```

&nbsp;

接著你可以把艾拉放入你的登入函式中，就像這樣。

```php
function login($username, $password)
{

    ... 程式 ...


    if($failed)
        return Aira::error('USERNAME_USED');
}
```

&nbsp;

之後你如果要登入，就先在登入函式呼叫前新增一段用以切換艾拉模式的程式。

```php
/** 開始擷取，接下來如果擷取到艾拉錯誤，就直接結束程式 */
Aira::capture();

login($username, $password);
```