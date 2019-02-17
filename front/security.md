* [XSS](#xss)
  * [攻击](#攻击)
  * [防御](#防御)

# XSS #
XSS（Cross-Site Scripting）跨站脚本攻击，是一种代码注入攻击。攻击者通过在目标网站上注入恶意脚本，使之在用户的浏览器上运行。利用这些恶意脚本，攻击者可获取用户的敏感信息如 Cookie、SessionID 等，进而危害数据安全。<br>
XSS 利用的是用户对指定网站的信任。
## 攻击 ##
  - 存储型
  - 反射型
  - DOM型
## 防御 ##
  - 过滤
  - 转义
  - CSP

＃ CSRF ＃
CSRF（Cross-site request forgery）跨站请求伪造，攻击者诱导受害者进入第三方网站，在第三方网站中，向被攻击网站发送跨站请求。利用受害者在被攻击网站已经获取的注册凭证，绕过后台的用户验证，达到冒充用户对被攻击的网站执行某项操作的目的。<br>
CSRF 利用的是网站对用户网页浏览器的信任。
## 攻击 ##
  - GET类型
  - POST类型
  - 链接类型
## 防御 ##
  - 同源检测
    - Origin Header
    - Referer Header
  - Token
  - 双重Cookie验证
  - Samesite Cookie
    - Strict 这个 Cookie 在任何情况下都不可能作为第三方 Cookie
    - Lax 这个请求改变了当前页面或者打开了新页面且同时是个GET请求，则这个Cookie可以作为第三方Cookie