**JavaScript**
- [定义](#定义)
- [使用](#使用)
  - [基础](#基础)
    - [变量](#变量)
    - [数据类型](#数据类型)

# 定义 #

# 使用 #
## 基础 ##
### 变量 ###
- 必须要声明

<details>
<summary>code</summary>
<pre>
<code> 
var name = value
</code>
</pre>
</details>

### 数据类型 ###
| 数据类型 | 描述 |
| :--: | :--: |
| Number | 数字  |
| String | 字符串 |
| Boolean | 布尔 |
| Undefined | 未定义 |
| Null | 空值 |
| Array | 数组 |
| Object | 对象 |
| Function | 函数 |

**对象**
> 一组属性和方法集合

<details>
<summary>code</summary>
<pre>
<code> 
- 定义
  var person = {
      firstName: "Kobe",
      lastName : "Bryant",
      job:"basketball star",
      fullName : function() {
          return this.firstName + " " + this.lastName;
      }
  };
- 获取属性
  - 对象.属性名
  - 对象["属性名"];
</code>
</pre>
</details>


DOM
<details>
<summary>code</summary>
<pre>
<code> 
- document.getElementById
- document.getElementsByName
- document.getElementsByTagName
- document.getElementsByClassName
- node.getAttribute
- node.setAttribute
- node.style
- node.innerHTML
</code>
</pre>
</details>