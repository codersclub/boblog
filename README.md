# Bo-Blog

Bo-Blog is a single-user blog (web log) engine based on PHP and MySQL.

## Bo-Blog 2.0 main features:

* Based on the template structure of XHTML+CSS+div layout, the changeable and gorgeous templates can make your blog unique;
* Freely customizable page blocks (widgets), add code without modifying the program, and you can also add new module items through automatic file installation;
* Use Ajax-based message and comment addition and management methods;
* Tags function;
* Compared with the 1.x version, greatly improved customization and ease of use;
* Recognize advertising/spam message/comment information using multiple conditions such as keywords, number of links, and number of words;
* Fully support of batch operations for blog posts, users, links and other content in the background, saving your time and efforts;
* Customizable expression system, customizable weather system, customizable avatar system;
* User group management system, which can set various use and management authority of each group of users in detail;
* It can automatically check whether there is an updated program;
* Support XML-RPC interface;
* Link grouping function, built-in link application and approval system;
* Multi-language support, built-in five language packs: simplified and traditional Chinese, English, Russian and Vietnamese;
* Supports the direct import of blog content via RSS, which can be converted in an emergency when there is no conversion program;
* Compatible with PHP5, MySQL5;
* Hidden categories can be set, hidden blogs can be written, drafts can be written;
* Optional custom editor;
* Two ways to top (pin) a blog post, you can lock a blog post, and add a star to the blog post;
* Support Trackbacks and RSS 2.0 (all new blog posts, single post or a certain category can be tracked);
* Visual link and sort order adjustment method;
* Two viewing methods of list or summary can be set freely;
* Freely switch blogs, switch registration, and set reasons;
* Time difference adjustment function;
* Verification code (captcha) based on GD;
* Bad words that are restricted or blocked can be imported;
* Attachment upload and management system;
* Import and export special backup format or RSS format.

## Bo-Blog 2.1.1 Installation Instructions

### 1. Installation conditions:

To install Bo-Blog 2.1.1, your server (or virtual host) must meet the following conditions:

* PHP version 4.3.0 and above;
* GD library installed;
* Zlib functions installed;
* Support sessions and cookies;
* Support MySQL version 4.0.0 and above;

In addition, the following functions must be enabled:

* opendir / readdir
* unlink
* fopen / fsockopen
* error_reporting
* chdir

### 2. New installation:

2.1. Upload all files from "bo-blog" folder to the server.
For Unix servers, please set the attributes of the following folders to 777
or ensure that the program can read and write files:

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

## File structure

The functions of the folders in the installation package are as follows:

* /bo-blog - Bo-blog program itself
* /help - documenting files;
* /tools - some small tools, please refer to the enclosed document for details.

## More information

* Pay attention to "Check for Updates" to discover new versions.
* Official website: http://www.bo-blog.com
* Discussion area: http://bbs.bo-blog.com

Thanks to the following netizens for their assistance.
(Sorted in alphabetical order)

* Jianxin (http://www.loveshell.net)
* Light blue radiant fish (http://www.51shell.cn)
* msxcms (http://www.bmforum.com)
* Nicky (http://www.osxcn.com)
* totti (http://www.ittot.com)
* Valery Votintsev (http://www.sources.ru)

This program contains codes from the following projects.
Copyrights of these parts belong to their perspective authors.

* TinyMCE (http://tinymce.moxiecode.com)
* Lunar Calendar original code by S&S Lab
* Watermark and Anti-spam in Trackbacks original code/algorithm by 4ngel (http://sablog.net)
* Enabling Javascript Copy and Paste in Firefox, Drop menu in Admin Center, UBB in Firefox (partial) original coders unknown
