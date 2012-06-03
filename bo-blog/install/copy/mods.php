<?php
if (!defined('VALIDREQUEST')) die ('Access Denied.');
addbar('header', [
	'index',
	'alltags',
	'guestbook',
	'togglesidebar',
	'viewlinks',
	'archivelink',
	'starred'
]);
addbar('sidebar', [
	'category',
	'calendar',
	'statistics',
	'search',
	'entries',
	'replies',
	'columnbreak',
	'link',
	'archive',
	'misc'
]);
addbar('footer', [
	'copyright'
]);
