========
本檔案分為簡繁兩部分，繁體使用者請往下拉。
========

=====================
Bo-Blog 2.0.3 安装说明

一、安装条件：
要安装Bo-Blog 2.0，您的服务器（或虚拟主机，下同）必须满足以下条件：
*PHP版本在 4.1.0 以上；
*支持MySQL；
*支持session和cookie；
*没有强制添加的广告等会改变输出页面内容的限制。

要顺畅地使用Bo-Blog 2.0全部功能，您的服务器最好还应具备下面的条件：
*PHP版本在 4.3.0 以上；
*MySQL版本在 4.0.0 以上；
*安装了GD库；
*安装了Zlib Function；
*建议在PHP全局变量 register_globals = Off 的情况下使用。

此外，下面的函数如果被禁用，将无法正常使用：
*opendir / readdir
*unlink
*fopen / fsockopen
*error_reporting

二、全新安装：
1. 将Bo-Blog文件夹下的所有文件上传到服务器上。Unix类服务器请设置以下文件夹的属性为777或保证程序可读写：
  bak/
  data/
  temp/
  attachment/
2. 执行 install/install.php。按照指示完成安装。
3. 到后台blog设置里设一下blog的地址，这样在rss和MetaweblogAPI里面显示的url才是正确的。
4. 如果您的服务器支持Gzip，请到后台blog设置中打开Gzip压缩，将有效提高页面打开的速度。

三、升级：
如无特别说明，2.0.2均包括 2.0.2、2.0.2sp1、sp2。

1. 自动升级步骤
1.1 下载完整安装包。解压。
1.2 将 tools/updateto203.php上传到blog安装目录下，在浏览器内执行之。该文件将根据你当前的blog版本自动修改数据结构。
1.3 将 bo-blog 目录下除install/和data/外的所有文件上传到blog安装目录下，覆盖所有旧版的文件。
1.4 登入到后台，到参数设置中配置所有空白的新选项并保存。
注意：一定要先上传升级程序完成数据库改动，再上传文件覆盖，否则自动升级无效。
如果你已经先上传了更新文件覆盖，请按下面的步骤手动升级，或者替换原先的 global.php 后重新执行自动升级程序。

2. 手动升级步骤
2.1 下载完整安装包。解压。
2.2 将 bo-blog 目录下除install/和data/外的所有文件上传到blog安装目录下，覆盖所有旧版的文件。
2.3 登入到后台，到参数设置中配置所有空白的新选项并保存。
2.4 到 数据维护 - MySQL 下，输入适合您版本的sql语句，并按确定按钮执行即可。

SQL for 2.0.2 & 2.0.3 alpha4：
引用
ALTER TABLE `[db]replies` CHANGE `empty1` `reppsw` TINYTEXT NULL;
ALTER TABLE `[db]messages` CHANGE `empty1` `reppsw` TINYTEXT NULL;
ALTER TABLE `[db]blogs`   DROP `empty2`,   DROP `empty3`,   DROP `empty4`,  DROP `empty5`,  DROP `empty6`,  DROP `empty7`,  DROP `empty8`,  DROP `empty9`,  DROP `empty10`;
ALTER TABLE `[db]blogs` ADD `blogpsw` TINYTEXT, ADD `frontpage` TINYINT( 1 ) DEFAULT '0' NOT NULL

SQL for  2.0.3 alpha5：
引用
ALTER TABLE `[db]replies` CHANGE `empty1` `reppsw` TINYTEXT NULL;
ALTER TABLE `[db]messages` CHANGE `empty1` `reppsw` TINYTEXT NULL

注意，如果您在Phpmyadmin等界面中执行sql操作，请把[db]替换为实际设置的数据表前缀。

3. 注意别忘了到后台参数设置中设置之前没有的选项！

四、文件组成
安装包里的文件夹作用如下：
*bo-blog - 完整的程序
*documents - 文档说明；
*tools - 一些小工具，详见内附文档。

五、更多信息
1. 可留意“检查更新”来发现新版本。
2. 官方网站：http://www.bo-blog.com
3. 讨论区： http://bbs.bo-blog.com



============
Bo-Blog 2.0.3 安裝說明

一、安裝條件：
要安裝Bo-Blog 2.0，您的伺服器（或虛擬主機，下同）必須滿足以下條件：
*PHP版本在 4.1.0 以上；
*支持MySQL；
*支持session和cookie；
*沒有強制添加的廣告等會改變輸出頁面內容的限制。

要順暢地使用Bo-Blog 2.0全部功能，您的伺服器最好還應具備下面的條件：
*PHP版本在 4.3.0 以上；
*MySQL版本在 4.0.0 以上；
*安裝了GD庫；
*安裝了Zlib Function；
*建議在PHP全局變數 register_globals = Off 的情況下使用。

此外，下面的函數如果被禁用，將無法正常使用：
*opendir / readdir
*unlink
*fopen / fsockopen
*error_reporting

二、全新安裝：
1. 將Bo-Blog資料夾下的所有檔案上傳到伺服器上。Unix類伺服器請設定以下資料夾的內容為777或保證程式可讀寫：
  bak/
  data/
  temp/
  attachment/
2. 執行 install/install.php。按照指示完成安裝。
3. 到後台blog設定裡設一下blog的地址，這樣在rss和MetaweblogAPI裡面顯示的url才是正確的。
4. 如果您的伺服器支持Gzip，請到後台blog設定中開啟Gzip壓縮，將有效提高頁面開啟的速度。

三、升級：
如無特別說明，2.0.2均包括 2.0.2、2.0.2sp1、sp2。

1. 自動升級步驟
1.1 下載完整安裝套件。解壓。
1.2 將 tools/updateto203.php上傳到blog安裝目錄下，在瀏覽器內執行之。該檔案將依你當前的blog版本自動修改資料結構。
1.3 將 bo-blog 目錄下除install/和data/外的所有檔案上傳到blog安裝目錄下，覆蓋所有舊版的檔案。
1.4 登入到後台，到參數設定中配置所有空白的新選項並保存。
注意：一定要先上傳升級程式完成資料庫改動，再上傳檔案覆蓋，否則自動升級無效。
如果你已經先上傳了更新檔案覆蓋，請按下面的步驟手動升級，或是取代原先的 global.php 後重新執行自動升級程式。

2. 手動升級步驟
2.1 下載完整安裝套件。解壓。
2.2 將 bo-blog 目錄下除install/和data/外的所有檔案上傳到blog安裝目錄下，覆蓋所有舊版的檔案。
2.3 登入到後台，到參數設定中配置所有空白的新選項並保存。
2.4 到 資料維護 - MySQL 下，輸入適合您版本的sql語句，並按確定按鈕執行即可。

SQL for 2.0.2 & 2.0.3 alpha4：
引用
ALTER TABLE `[db]replies` CHANGE `empty1` `reppsw` TINYTEXT NULL;
ALTER TABLE `[db]messages` CHANGE `empty1` `reppsw` TINYTEXT NULL;
ALTER TABLE `[db]blogs`   DROP `empty2`,   DROP `empty3`,   DROP `empty4`,  DROP `empty5`,  DROP `empty6`,  DROP `empty7`,  DROP `empty8`,  DROP `empty9`,  DROP `empty10`;
ALTER TABLE `[db]blogs` ADD `blogpsw` TINYTEXT, ADD `frontpage` TINYINT( 1 ) DEFAULT '0' NOT NULL

SQL for  2.0.3 alpha5：
引用
ALTER TABLE `[db]replies` CHANGE `empty1` `reppsw` TINYTEXT NULL;
ALTER TABLE `[db]messages` CHANGE `empty1` `reppsw` TINYTEXT NULL

注意，如果您在Phpmyadmin等介面中執行sql操作，請把[db]取代為實際設定的資料表前綴。

3. 注意別忘了到後台參數設定中設定之前沒有的選項！

四、檔案組成
安裝套件裡的資料夾作用如下：
*bo-blog - 完整的程式
*documents - 文檔說明；
*tools - 一些小工具，詳見內附文檔。

五、更多資訊
1. 可留意“檢查更新”來發現新版本。
2. 官方網站：http://www.bo-blog.com
3. 討論區： http://bbs.bo-blog.com