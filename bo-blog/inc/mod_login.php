<?PHP
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
<<A Bluview Technology Product>>
禁止使用Windows记事本修改文件，由此造成的一切使用不正常恕不解答！
PHP+MySQL blog system.
Code: Bob Shen
Offical site: http://www.bo-blog.com
Copyright (c) Bob Shen 中国－上海
In memory of my university life
------------------------------------------------------- */

if (!defined('VALIDREQUEST')) die ('Access Denied.');

acceptrequest('job', 1);

if (!$job) {
	$m_b=new getblogs;
	$jobs="javascript: ajax_login();";
	$actionnow="{$lnc[253]} [<a href=\"login.php?job=register\">{$lnc[254]}</a>]";
	$formbody.=$t->set('form_eachline', array('text'=>$lnc[132], 'formelement'=>"<input name='username' type='text' id='username' size='24' class='text' />"));
	$formbody.=$t->set('form_eachline', array('text'=>$lnc[133], 'formelement'=>"<input type='password'  class='text' size='16' name='password' id='password' />"));
	$formbody.=$t->set('form_eachline', array('text'=>$lnc[255], 'formelement'=>"<input name=\"savecookie\" type=\"radio\" id=\"savecookie\" value=\"0\"/>{$lnc[256]} <input name=\"savecookie\" type=\"radio\" id=\"savecookie1\" value=\"3600\" checked='checked'/>{$lnc[257]} <input name=\"savecookie\" type=\"radio\" id=\"savecookie2\" value=\"86400\"/>{$lnc[258]}  <input name=\"savecookie\" type=\"radio\" id=\"savecookie3\" value=\"604800\"/>{$lnc[259]}  <input name=\"savecookie\" type=\"radio\" id=\"savecookie4\" value=\"2592000\"/>{$lnc[260]}   <input name=\"savecookie\" type=\"radio\" id=\"savecookie5\" value=\"31104000\"/>{$lnc[261]}"));
	if ($config['loginvalidation']==1) {
		$rand=rand (0,100000);
		$formbody.=$t->set('form_eachline', array('text'=>$lnc[249], 'formelement'=>"<span id='securityimagearea'><img src='inc/securitycode.php?rand={$rand}' alt='' title='{$lnc[250]}'/></span> <input name='securitycode' type='text' id='securitycode' size='16' class='text' /> {$lnc[251]} [<a href=\"javascript: refreshsecuritycode('securityimagearea', 'securitycode');\">{$lnc[283]}</a>]"));
	}
	$section_body_main=$t->set('register', array('title'=>$actionnow, 'job'=>$jobs, 'registerbody'=>$formbody));
	announcebar();
	$bodymenu=$t->set('mainpage', array('pagebar'=>'', 'iftoppage'=>'none', 'ifbottompage'=>'none', 'ifannouncement'=>$ifannouncement, 'topannounce'=>$topannounce, 'mainpart'=>$section_body_main, 'currentpage'=>'', 'previouspageurl'=>'', 'nextpageurl'=>'', 'turningpages'=>'', 'totalpages'=>'', 'previouspageexists'=>'', 'nextpageexists'=>''));
}

if ($job=='adminlog') {
	$t=new template;
	$jobs="login.php?job=adminverify";
	$actionnow=$lnc[273];
	$formbody.=$t->set('form_eachline', array('text'=>$lnc[274], 'formelement'=>$lnc[275]));
	$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[132]}", 'formelement'=>"<input type='text' class='text' size='16' name='username' value='{$userdetail['username']}' disabled='disabled' />"));
	$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[133]}", 'formelement'=>"<input type='password'  class='text' size='16' name='ipassword' />"));
	$section_body_main=$t->set('register', array('title'=>$actionnow, 'job'=>$jobs, 'registerbody'=>$formbody));
	announcebar();
	$bodymenu=$t->set('mainpage', array('pagebar'=>$pagebar, 'iftoppage'=>'none', 'ifbottompage'=>'none', 'ifannouncement'=>$ifannouncement, 'topannounce'=>$topannounce,  'mainpart'=>$section_body_main, 'currentpage'=>'', 'previouspageurl'=>'', 'nextpageurl'=>'', 'turningpages'=>'', 'totalpages'=>'', 'previouspageexists'=>'', 'nextpageexists'=>''));
}

if ($job=='adminverify') {
	acceptrequest('ipassword');
	$password=md5($_POST['ipassword']);
	$username=safe_convert(mystrtolower($userdetail['username']));
	$try=$blog->getbyquery("SELECT * FROM `{$db_prefix}user` WHERE LOWER(username)='{$username}'");
	if (!is_array($try)) {
		catcherror ($lnc[276]);
	} elseif ($try['userpsw']!=$password) {
		catcherror ($lnc[276]);
	}
	if ($db_defaultsessdir!=1) session_save_path("./{$db_tmpdir}");
	session_cache_limiter("private, must-revalidate");
	session_start();
	$_SESSION['admin_userid']=$try['userid'];
	$_SESSION['admin_psw']=$try['userpsw'];
	catchsuccess ($lnc[277], "{$lnc[278]}|admin.php");
	exit();
}

if (($job=='register' || $job=='doregister') && $logstat==1) 	catcherror($lnc[130]);
if (($job=='modpro' || $job=='domodpro') && ($logstat!=1 || $userdetail['userid']==-1)) catcherror($lnc[131]);

if ($job=='register' || $job=='modpro') {
	if ($config['registeron']!='1' && $job=='register') {
		catcherror($config['registeroffmess']);
	}
	$t=new template;
	if ($job=='register') {
		$actionnow=$lnc[79];
		$jobs="login.php?job=doregister";
		$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[132]}", 'formelement'=>"<input type='text' class='text' size='16' name='username' />"));
		$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[133]}", 'formelement'=>"<input type='password'  class='text' size='16' name='password' />"));
		$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[134]}", 'formelement'=>"<input type='password' class='text' size='16' name='confirmpsw' />"));
	}
	if ($job=='modpro') {
		$jobs="login.php?job=domodpro";
		$actionnow=$lnc[90];
		$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[135]}", 'formelement'=>"<input type='password'  class='text' size='16' name='password' /> {$lnc[137]}"));
		$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[136]}", 'formelement'=>"<input type='password'  class='text' size='16' name='newpsw' /> {$lnc[137]}"));
		$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[138]}", 'formelement'=>"<input type='password'  class='text' size='16' name='confirmpsw' /> {$lnc[137]}"));
	}
	$formbody.=$t->set('form_eachline', array('text'=>$lnc[139], 'formelement'=>"<input type='text' class='text' size='16' name='email' value='".stripslashes($userdetail['email'])."'/>"));
	if (($job=='register' && $mbcon['regadvance']=='1') || $job=='modpro') {
		$formbody.=$t->set('form_eachline', array('text'=>$lnc[140], 'formelement'=>"<input type='text' class='text' size='16' name='homepage' value='".stripslashes($userdetail['homepage'])."'/>"));
		$sex_sel=array('0'=>$lnc[141], '1'=>$lnc[142], '2'=>$lnc[143]);
		$sex_choice=array('0'=>'', '1'=>'', '2'=>'');
		$tmp_gender=$userdetail['gender'];
		$sex_choice[$tmp_gender]="checked=checked";
		$formbody.=$t->set('form_eachline', array('text'=>$lnc[144], 'formelement'=>"<input type='radio' name='gender' value='0' {$sex_choice[0]}/>{$lnc[141]} <input type='radio' name='gender' value='1' {$sex_choice[1]}/>{$lnc[142]} <input type='radio' name='gender' value='2' {$sex_choice[2]}/>{$lnc[143]} "));
		$formbody.=$t->set('form_eachline', array('text'=>$lnc[145], 'formelement'=>"<input type='text' class='text' size='16' name='qq' value='".stripslashes($userdetail['qq'])."'/>"));
		$formbody.=$t->set('form_eachline', array('text'=>'MSN', 'formelement'=>"<input type='text' class='text' size='16' name='msn' value='".stripslashes($userdetail['msn'])."'/>"));
		$formbody.=$t->set('form_eachline', array('text'=>'Skype', 'formelement'=>"<input type='text' class='text' size='16' name='skype' value='".stripslashes($userdetail['skype'])."'/>"));
		$formbody.=$t->set('form_eachline', array('text'=>$lnc[146], 'formelement'=>"<input type='text' class='text' size='16' name='from' value='".stripslashes($userdetail['from'])."'/>"));
		$formbody.=$t->set('form_eachline', array('text'=>$lnc[147], 'formelement'=>"<textarea cols='30' rows='3' name='intro'>".stripslashes($userdetail['intro'])."</textarea>"));
		if ($mbcon['avatar']=='1') {
			if (file_exists('data/cache_avatars.php')) @require_once ('data/cache_avatars.php');
			if (is_array($avatars)) {
				foreach ($avatars as $avapic) {
					$bodyofselctavatar.="<option value='$avapic'>{$avapic}</option>";
				}
			}
			$bodyofselctavatar.="<option value=''>{$lnc[148]}</option>";
			@list($avatartype, $avatarvalue)=@explode('|', $userdetail['avatar']);
			$avatarstatus[0]=($avatartype!=1) ? 'selected' : '';
			$avatarstatus[1]=($avatartype==1) ? 'selected' : '';
			if (!empty($avatarvalue)) $avatararea="<img src='images/avatars/{$avatarvalue}' alt=''/>";
			else $avatararea=$lnc[148];
			$formbody.=$t->set('form_eachline', array('text'=>$lnc[149], 'formelement'=>"<select name='avatartype'><option value='0' {$avatarstatus[0]}>{$lnc[150]}</option><option value='1' {$avatarstatus[1]}>{$lnc[151]}</option></select>"));
			$formbody.=$t->set('form_eachline', array('text'=>$lnc[152], 'formelement'=>"<select name='avatarvalue' id='avatarvalue' onchange=\"changeavatar('avatarvalue', 'avatararea');\"><option value='$avatarvalue'>{$lnc[153]}</option>{$bodyofselctavatar}</select><br/><span id='avatararea'>{$avatararea}</span>"));
		}
	}
	if ($job=='register' && $config['registervalidation']==1) {
		$rand=rand (0,100000);
		$formbody.=$t->set('form_eachline', array('text'=>$lnc[249], 'formelement'=>"<span id='securityimagearea'><img src='inc/securitycode.php?rand={$rand}' alt='' title='{$lnc[250]}'/></span> <input name='securitycode' type='text' id='securitycode' size='16' class='text' /> {$lnc[251]} [<a href=\"javascript: refreshsecuritycode('securityimagearea', 'securitycode');\">{$lnc[283]}</a>]"));
	}
	$section_body_main=$t->set('register', array('title'=>$actionnow, 'job'=>$jobs, 'registerbody'=>$formbody));
	announcebar();
	$bodymenu=$t->set('mainpage', array('pagebar'=>$pagebar, 'iftoppage'=>'none', 'ifbottompage'=>'none', 'ifannouncement'=>$ifannouncement, 'topannounce'=>$topannounce,  'mainpart'=>$section_body_main, 'currentpage'=>'', 'previouspageurl'=>'', 'nextpageurl'=>'', 'turningpages'=>'', 'totalpages'=>'', 'previouspageexists'=>'', 'nextpageexists'=>''));
}

if ($job=='doregister' || $job=='domodpro') {
	acceptrequest('password,confirmpsw,email,homepage,gender,qq,msn,skype,from,intro,avatartype,avatarvalue', 0, 'post');
	extract_forbidden();
	if ($job=='doregister') {
		acceptrequest('username', 0, 'post');
		if ($config['registervalidation']==1) {
			acceptrequest('securitycode');
			if ($db_defaultsessdir!=1) session_save_path("./{$db_tmpdir}");
			session_cache_limiter("private, must-revalidate");
			session_start();
			if ($securitycode=='' || strtolower($securitycode)!=strtolower($_SESSION['code'])) catcherror($lnc[165]);
		}
		$username=trimplus(safe_convert($username));
		if ($username==='') catcherror ($lnc[154]);
		if (strlen($username)<$mbcon['minusenamelen'] || strlen($username)>$mbcon['maxusenamelen']) catcherror ($lnc[155]);
		if ($password==='' || $password!=$confirmpsw || strlen($password)<$mbcon['minpswlen']) catcherror ($lnc[156]);
		else $password=md5($password);
		$usercheck=mystrtolower($username);
		$try=$blog->getbyquery("SELECT userid FROM `{$db_prefix}user` WHERE LOWER(username)='{$usercheck}'");
		if (is_array($try)) catcherror ($lnc[157]);
		if (preg_search($username, $forbidden['banword']) || preg_search($username, $forbidden['keep'])) catcherror ($lnc[158]);
	} else {
		if ($password!=='') {
			if (md5($password)!=$userdetail['userpsw']) catcherror ($lnc[159]);
			acceptrequest('newpsw', 0, 'post');
			if ($newpsw==='' || $newpsw!=$confirmpsw || strlen($newpsw)<$mbcon['minpswlen']) catcherror ($lnc[160]);
			$userdetail['userpsw']=md5($newpsw); //PSW Changed here
		}
	}
	$email=trimplus(safe_convert($email));
	$homepage=trimplus(safe_convert($homepage));
	$gender=floor($gender);
	$qq=floor($qq);
	$msn=trimplus(safe_convert($msn));
	$skype=trimplus(safe_convert($skype));
	$from=trimplus(safe_convert($from));
	$intro=trimplus(safe_convert($intro));
	$avatartype=floor($avatartype);
	$avatarvalue=basename(trimplus(safe_convert($avatarvalue)));
	$avatarall="{$avatartype}|{$avatarvalue}";
	if (preg_search($intro, $forbidden['banword'])) catcherror ($lnc[161]);
	if ($job=='doregister') {
		$maxrecord=$blog->getsinglevalue("{$db_prefix}maxrec");
		$currentuserid=$maxrecord['maxuserid']+1;
		$imajikan=time();
		$blog->query("INSERT INTO `{$db_prefix}user` VALUES ('{$currentuserid}', '{$username}', '{$password}', '{$imajikan}', '1', '{$email}', '{$homepage}', '{$qq}', '{$msn}', '{$intro}', '{$gender}', '{$skype}', '{$from}', '0', '{$userdetail['ip']}', '{$avatarall}', '', '', '', '', '', '', '')");
		$blog->query("UPDATE `{$db_prefix}maxrec` SET `maxuserid`=`maxuserid`+1");
		$blog->query("UPDATE `{$db_prefix}counter` SET `users`=`users`+1");
		@setcookie ('userid', $currentuserid);
		@setcookie ('userpsw', $password);
		catchsuccess($lnc[162], "{$lnc[163]}|index.php");
	} else {
		$blog->query("UPDATE `{$db_prefix}user` SET `userpsw`='{$userdetail['userpsw']}', `email`='{$email}', homepage='{$homepage}',  qq='{$qq}', msn='{$msn}', intro='{$intro}', gender='{$gender}', skype='{$skype}', `from`='{$from}', avatar='{$avatarall}' WHERE `userid`='{$userdetail['userid']}'");
		@setcookie ('userid', '', time()-3600);
		@setcookie ('userpsw', '', time()-3600);
		@setcookie ('userid', $userdetail['userid']);
		@setcookie ('userpsw', $userdetail['userpsw']);
		catchsuccess($lnc[164], "{$lnc[163]}|index.php");
	}
}


if ($job=='verify') {
	acceptrequest('savecookie,securitycode');
	if ($config['loginvalidation']==1) {
		if ($db_defaultsessdir!=1) session_save_path("./{$db_tmpdir}");
		session_cache_limiter("private, must-revalidate");
		session_start();
		if ($securitycode=='' || strtolower($securitycode)!=strtolower($_SESSION['code'])) catcherror($lnc[165]);
	}
	$password=md5($_POST['password']);
	$username=safe_convert(mystrtolower($_POST['username']));
	$try=$blog->getbyquery("SELECT * FROM `{$db_prefix}user` WHERE LOWER(username)='{$username}' AND `userpsw`='{$password}'");
	if (!is_array($try)) {
		catcherror ($lnc[166]);
	} else {
		setcookie ('userid', '', time()-3600);
		setcookie ('userpsw', '', time()-3600);
		setcookie('blogtemplate', '', time()-3600);
		setcookie('lastpost', '', time()-3600);
		setcookie('lastsearch', '', time()-3600);
		setcookie('sidebaroff', '', time()-3600);
		$userid=$try['userid'];
		if ($savecookie==0) {
			setcookie ('userid', $userid);
			setcookie ('userpsw', $password);
		} else {
			setcookie ('userid', $userid, gmmktime()-$config['timezone']*3600+$savecookie);
			setcookie ('userpsw', $password, gmmktime()-$config['timezone']*3600+$savecookie);
		}
		catchsuccess ("{$lnc[167]} ".$username, "{$lnc[163]}|index.php");
	}
}

if ($job=='logout') {
	define ('isLogout', 1);
	if ($config['noadminsession']!='1') {
		if ($db_defaultsessdir!=1) session_save_path("./{$db_tmpdir}");
		session_cache_limiter("private, must-revalidate");
		session_start();
		session_destroy();
	}
	$logoutjs="\n<script type='text/javascript'>quicklogout();</script>\n";
	catchsuccess ($lnc[168], "{$logoutjs}{$lnc[163]}|index.php");
}

if ($job=='applylink') {
	checkpermission ('ApplyLink');
	$mycode1="<a href=\"{$config['blogurl']}\" target=\"_blank\" title=\"{$config['blogname']}\">{$config['blogname']}</a>";
	$mycode2="<a href=\"{$config['blogurl']}\" target=\"_blank\"><img src=\"{$config['bloglogo']}\"  title=\"{$config['blogname']}\" alt=\"{$config['blogname']}\" border=\"0\"/></a>";
	$mycode1=htmlspecialchars($mycode1);
	$mycode2=htmlspecialchars($mycode2);
	$t=new template;
	$actionnow=$lnc[109];
	$jobs="login.php?job=doapplylink";
	$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[169]}", 'formelement'=>"<input type='text' class='text' size='20' name='sitename' />"));
	$formbody.=$t->set('form_eachline', array('text'=>"*{$lnc[170]}", 'formelement'=>"<input type='text'  class='text' size='30' name='siteurl' />"));
	$formbody.=$t->set('form_eachline', array('text'=>$lnc[171], 'formelement'=>"<input type='text'  class='text' size='30' name='sitelogo' /> {$lnc[172]}"));
	$formbody.=$t->set('form_eachline', array('text'=>$lnc[173], 'formelement'=>"<input type='text'  class='text' size='30' name='siteintro' /> {$lnc[174]}"));
	$formbody.=$t->set('form_eachline', array('text'=>$lnc[175], 'formelement'=>"{$lnc[176]}<br/><ul><li>{$lnc[177]}<br/><textarea class='text' cols='60' rows='2' name='sitemycode1'>{$mycode1}</textarea></li><li>{$lnc[178]}<br/><textarea class='text' cols='60' rows='2' name='sitemycode2'>{$mycode2}</textarea></li></ul>"));
	if ($config['applylinkvalidation']==1) {
		$rand=rand (0,100000);
		$formbody.=$t->set('form_eachline', array('text'=>$lnc[249], 'formelement'=>"<span id='securityimagearea'><img src='inc/securitycode.php?rand={$rand}' alt='' title='{$lnc[250]}'/></span> <input name='securitycode' type='text' id='securitycode' size='16' class='text' /> {$lnc[251]} [<a href=\"javascript: refreshsecuritycode('securityimagearea', 'securitycode');\">{$lnc[283]}</a>]"));
	}
	$section_body_main=$t->set('register', array('title'=>$actionnow, 'job'=>$jobs, 'registerbody'=>$formbody));
	announcebar();
	$bodymenu=$t->set('mainpage', array('pagebar'=>$pagebar, 'iftoppage'=>'none', 'ifbottompage'=>'none', 'ifannouncement'=>$ifannouncement, 'topannounce'=>$topannounce,  'mainpart'=>$section_body_main, 'currentpage'=>'', 'previouspageurl'=>'', 'nextpageurl'=>'', 'turningpages'=>'', 'totalpages'=>'', 'previouspageexists'=>'', 'nextpageexists'=>''));
}

if ($job=='doapplylink') {
	checkpermission ('ApplyLink');
	acceptrequest('sitename,siteurl,sitelogo,siteintro');
	if ($config['applylinkvalidation']==1) {
		acceptrequest('securitycode');
		if ($db_defaultsessdir!=1) session_save_path("./{$db_tmpdir}");
		session_cache_limiter("private, must-revalidate");
		session_start();
		if ($securitycode=='' || strtolower($securitycode)!=strtolower($_SESSION['code'])) catcherror($lnc[165]);
	}
	$sitename=safe_convert(trimplus($sitename));
	$siteurl=safe_convert(trimplus($siteurl));
	$sitelogo=safe_convert(trimplus($sitelogo));
	$siteintro=safe_convert(trimplus($siteintro));
	if (!$sitename || !$siteurl) catcherror ($lnc[179]);
	$siteurl=urlconvert($siteurl);
	$sitelogo=urlconvert($sitelogo);
	$siteid=time().rand(0,10);
	if (preg_search($sitename, $forbidden['banword']) || preg_search($siteintro, $forbidden['banword']) ||  preg_search($siteurl, $forbidden['banword']) || preg_search($sitename, $forbidden['suspect']) || preg_search($siteintro, $forbidden['suspect']) ||  preg_search($siteurl, $forbidden['suspect'])) catcherror($lnc[214]);
	$addline="<?PHP exit();?><|>$siteid<|>$sitename<|>$siteurl<|>$sitelogo<|>$siteintro<|>\n";
	$filename="data/cache_applylinks.php";
	$oldcontent=@readfromfile($filename);
	$content=$addline.$oldcontent;
	if (!writetofile($filename, $content)) catcherror ($lnc[7].$filename);
	else catchsuccess ($lnc[180], "{$lnc[163]}|index.php");
}

if ($job=='ajaxverify') {
	acceptrequest('savecookie,securitycode');
	$savecookie=floor($savecookie);
	if ($config['loginvalidation']==1) {
		if ($db_defaultsessdir!=1) session_save_path("./{$db_tmpdir}");
		session_cache_limiter("private, must-revalidate");
		session_start();
		if ($securitycode=='' || strtolower($securitycode)!=strtolower($_SESSION['code'])) catcherror($lnc[165]);
	}
	$password=md5($_POST['password']);
	$username=safe_convert(mystrtolower($_POST['username']));
	$try=$blog->getbyquery("SELECT * FROM `{$db_prefix}user` WHERE LOWER(username)='{$username}' AND `userpsw`='{$password}'");
	if (!is_array($try)) {
		catcherror ($lnc[166]);
	} else {
		$userid=$try['userid'];
		catchsuccess ("{$userid}-{$password}-{$savecookie}");
	}
}

if ($job=='ajaxloginsuccess') {
	if ($permission['CP']==1) $destine=array("{$lnc[163]}|index.php", "{$lnc[107]}|admin.php");
	else $destine="{$lnc[163]}|index.php";
	catchsuccess("{$lnc[167]} ".$userdetail['username'], $destine);
}

