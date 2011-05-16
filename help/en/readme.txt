=====================
Bo-Blog 2.1.1 Installation Instructions

1. Installation conditions:
To install Bo-Blog 2.1.1, your server (or virtual host, the same below) must meet the following conditions:
*PHP version is above 4.1.0;
*Support MySQL, the version is above 4.0.0;
*Support session and cookie;
*There are no restrictions on the content of the output page that will be changed by the mandatory addition of advertisements.

To use all the features of Bo-Blog 2.1.1 smoothly, your server should also have the following conditions:
*PHP version is above 4.3.0;
* GD library is installed;
*Zlib Function is installed;

In addition, if the following functions are disabled, they will not work properly:
*opendir / readdir
*unlink
*fopen / fsockopen
*error_reporting
*chdir

2. New installation:
2.1. Upload all files in the Bo-Blog folder to the server. For Unix servers, please set the attributes of the following folders to 777 or ensure that the program can be read and written:
  attachment/
  bak/
  data/
  post/
  temp/
  temp/openid/
  temp/openid/associations/
  temp/openid/nonces/
  temp/openid/temp/
Warning: If you are using a Windows server, it is recommended not to install it in the root directory.
2.2. Execute install/install.php. Follow the instructions to complete the installation.
2.3. If your server supports Gzip, please turn on Gzip compression in the background blog settings.

3. Document composition
The functions of the folders in the installation package are as follows:
*bo-blog-complete program
*documents-document description;
*tools-some small tools, please refer to the enclosed document for details.

4. More information
1. Pay attention to "Check for Updates" to discover new versions.
2. Official website: http://www.bo-blog.com
3. Discussion area: http://bbs.bo-blog.com
