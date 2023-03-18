**网络系统**
- [内容](#内容)
  - [IO](#io)
  - [文件传输](#文件传输)
  - [大文件传输](#大文件传输)

# 内容 #
## IO ##
**直接IO**  
![](./images/net_system/direct_io.webp)  

**DMA**  
![](./images/net_system/dma_io.webp)  


## 文件传输 ##
**read+write**  
![](./images/net_system/read_write.webp)

**mmap+write**  
![](./images/net_system/mmap_write.webp)

**sendfile+dma**  
![](./images/net_system/sendfile_dma.webp)

**sendfile+sg-dma**  
![](./images/net_system/sendfile_sg_dma.webp)

## 大文件传输 ##
**异步IO+直接IO**  
![](./images/net_system/big_file.webp)
