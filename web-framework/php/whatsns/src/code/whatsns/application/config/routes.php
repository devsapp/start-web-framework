<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['index'] = 'index/index';//对首页重写
//问题库列表重写
$route['ask'] = 'Ask/index';//对问题库列表重写
$route['ask/(:any)'] = 'Ask/index/$1';//对问题库列表重写--分类
$route['ask/(:any)/(:any)'] = 'Ask/index/$1/$2';//对问题库列表重写--分类/排序
$route['ask/(:any)/(:any)/(:num)'] = 'Ask/index/$1/$2/$3';//对问题库列表重写--分类/排序/分页


//文章栏目库列表重写
$route['article'] = 'Seo/index';//对文章栏目库列表重写
$route['article/(:any)'] = 'Seo/index/$1';//对文章栏目库列表重写--分类
$route['article/(:any)/(:any)'] = 'Seo/index/$1/$2';//对文章栏目库列表重写--分类/排序
$route['article/(:any)/(:any)/(:num)'] = 'Seo/index/$1/$2/$3';//对文章栏目库列表重写--分类/排序/分页


$route['answer/(:num)/(:num)'] = 'Question/answer/$1/$2';//对回答详情页面重写
$route['article-(:any)'] = 'Topic/getone/$1';//对文章重写
$route['article-(:any)/(:num)'] = 'Topic/getone/$1/$2';//对文章重写
$route['cat-(:any)'] = 'Topic/catlist/$1';//对文章分类重写
$route['cat-(:any)/(:num)'] = 'Topic/catlist/$1/$2';//对文章分类重写
$route['q-(:num)'] = 'Question/view/$1';//对问题重写
$route['q-(:num)/(:num)'] = 'Question/view/$1/$2';//对问题重写
$route['u-(:num)'] = 'User/space/$1';//对用户空间重写
$route['u-(:num)/(:num)'] = 'User/space/$1/$2';//对用户空间重写
$route['c-(:any)'] = 'Category/view/$1';//对分类详情url重写
$route['c-(:any)/(:any)'] ='Category/view/$1/$2';//对分类重写
$route['c-(:any)/(:any)/(:num)'] ='Category/view/$1/$2/$3';//对分类重写
$route['ua-(:num)'] = 'User/space_answer/$1';//对用户空间用户回答重写
$route['ua-(:num)/(:num)'] = 'User/space_answer/$1/$2';//对用户空间用户回答重写
$route['ua-(:num)/(:num)/(:num)'] = 'User/space_answer/$1/$2/$2';//对用户空间用户回答重写
$route['uask-(:num)/(:num)'] = 'User/space_ask/$1/$2';//对用户空间用户提问重写
$route['uask-(:num)'] = 'User/space_ask/$1';//对用户空间用户提问重写
$route['ut-(:num)'] = 'Topic/userxinzhi/$1';//对用户空间用户文章url重写
$route['ut-(:num)/(:num)'] = 'Topic/userxinzhi/$1/$2';//对用户空间用户文章url重写
$route['new'] = 'Newpage/index';
$route['new/maketag'] = 'Newpage/maketag';
$route['new/default'] = 'Newpage/index';
$route['appstore/default'] = 'Appstore/index';
$route['new/default/(:num)'] = 'Newpage/index/$1';
$route['new/default/(:num)/(:num)'] = 'Newpage/index/$1/$2';
$route['new/question/(:num)/(:num)'] = 'Newpage/catname/$1/$2';
$route['new/question/(:num)/(:num)/(:num)'] = 'Newpage/catname/$1/$2/$3';

$route['new-(:num)'] = 'Newpage/index/$1';
$route['new-(:num)-(:num)'] = 'Newpage/index/$1/$2';
$route['note/list'] = 'Note/clist';
$route['note/list/(:num)'] = 'Note/clist/$1';//公告分页
$route['rss/list'] = 'Rss/clist';
$route['Api_article/list'] = 'Api_article/clist';
$route['pccaiji_catgory/list'] = 'Pccaiji_catgory/clist';
$route['tag/(:any)'] = 'Tags/view/$1';
$route['tag/(:any)/(:any)'] = 'Tags/view/$1/$2';
$route['content/(:any)'] = 'Content/index/$1';
$route['content/(:any)/(:any)'] = 'Content/index/$1/$2';
$route['attention/(:any)'] = 'User/attention/$1';
$route['attention/(:any)/(:any)'] = 'User/attention/$1/$2';

