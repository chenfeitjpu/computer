**CSS**
- [定义](#定义)
- [使用](#使用)
  - [基础](#基础)
  - [布局](#布局)

# 定义 #
> CSS(Cascading Style Sheets，层叠样式表)是一种用于描述HTML文档外观和格式的样式语言。  
> 它与HTML一起构成了现代网页的核心技术，用于控制页面的视觉呈现，包括布局、颜色、字体等。

# 使用 #
## 基础 ##
- 样式引入
  > 内联样式 
  > 内部样式表 
  > 外部样式表
- 选择器
  - 单一选择器
    > 通配选择器  *{}
    > 标签选择器  .elementname{}
    > 类选择器  .classname{}
    > ID选择器  #id{}
    > 属性选择器  [属性名=值] 包含(*=), 开头(^=), 结尾($=)
  - 复合选择器
    > 交集选择器  选择器1选择器2
    > 并集选择器  选择器1, 选择器2
  - 关系选择器
    > 子元素选择器  父元素 > 子元素
    > 后代元素选择器  祖先 后代
    > 兄弟元素选择器  前一个 + 下一个, 前一个 ~ 下一组
  - 伪类选择器
    > :first-child 第一个子元素
    > :last-child 最后一个子元素
    > :nth-child() 选中第n个子元素 
    > :first-of-type 同类型中的第一个子元素
    > :last-of-type 同类型中的最后一个子元素
    > :nth-of-type() 选中同类型中的第n个子元素
    > :link 未访问的链接
    > :visited 已访问的链接 
    > :hover 鼠标悬停的链接
    > :active 鼠标点击的链接
    > :not 否认伪类
  - 伪元素选择器
    > ::first-letter  表示第一个字母
    > ::first-line  表示第一行
    > ::selection  表示选中的内容
    > ::before  必须结合content属性来使用
    > ::after  必须结合content属性来使用
- 文本
  - color  文字颜色
  - font-size  文字大小
  - font-family  字体
  - text-align  对齐方式
  - text-shadow  文本阴影
  - line-height  行高
- 背景
  - background-color  背景颜色
  - background-image  背景图片
  - background-repeat  背景图片是否重复
  - background-position  背景图片位置
  - background-size  背景图片尺寸
  - background-attachment  背景图片滚动控制
- 过渡  指定状态变化所需要的时间
  - transition: transition-property transition-duration transition-timing-function transition-delay  属性、时长、效果、延时
- 动画  
  - animation: 

## 布局 ##
- display
  - block 块级元素
    - 独占一行
    - 可以设置宽高
    - 默认宽度是其父容器的100%
    - 默认高度是子元素高度
    - 可以包含块级或内联元素
  - inline 内联元素
    - 不独占一行
    - 不能设置宽高
    - 默认宽度是内容宽度
    - 默认高度是内容高度
    - 只能包含内联元素
  - inline-block 内联块级元素
    - 不独占一行
    - 可以设置宽高

- box
  - content 内容
  - padding 内边距
  - border 边框 
  - margin 外边距 

- float
  - 浮动的元素会脱离文档流，但仍保留在父容器的范围内
  - 浮动元素后面的内容会环绕它（如果没有清除浮动）
  
- position
  - static  没有定位
  - relative  相对定位，元素仍在文档流中，但可以相对于自身的初始位置偏移
  - absolute  绝对定位，元素脱离文档流，按照最近的定位祖先(非static)进行定位
  - fixed  固定定位，元素脱离文档流，相对于视口进行定位，不随页面滚动而改变位置
  - sticky  粘性定位，元素根据滚动位置，在相对和固定定位之间切换
	
- flex
  - container
      - flex-direction
      - flex-wrap
      - flex-flow
      - justify-content
      - align-items
      - align-content  
  - item
      - flex-grow
      - flex-shrink
      - flex-basis
      - flex
      - order 
      - align-self  
     
- grid
  - container
    - grid-template-columns  设置列宽
    - grid-template-rows  设置行高
    - grid-row-gap   设置行间距
    - grid-column-gap  设置列间距
    - grid-gap  
    - grid-template-areas  定义区域，一个区域由一个或者多个单元格组成
    - grid-auto-flow  控制着自动布局算法怎样运作，默认的放置顺序是先行后列，也可设置先列后行
    - justify-items  设置单元格内容的水平位置
    - align-items  设置单元格内容的垂直位置
    - place-items
    - justify-content  整个内容区域在容器里面的水平位置
    - align-content  整个内容区域的垂直位置
    - place-content
    - grid-auto-columns  隐式网格列宽
    - grid-auto-rows  隐式网格行高
  - item
    - grid-column-start  左边框所在的垂直网格线
    - grid-column-end  右边框所在的垂直网格线
    - grid-row-start  上边框所在的水平网格线
    - grid-row-end  下边框所在的水平网格线
    - grid-area  
    - justify-self  设置单元格内容的水平位置
    - align-self  设置单元格内容的垂直位置
    - place-self  