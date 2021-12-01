<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

class column_tag extends tag {
    // 必须包含Tag属性 不可修改
    public $config = array(
        '_category'         => array( 'block' => 1, 'level' => 4 ),
        '_list'             => array( 'block' => 1, 'level' => 5 ),
        'app_column'        => array('block'=>1,'level'=>4),
    );


    public function _category( $attr, $content ) {
        global $_M;
        $type = isset( $attr['type'] ) ? $attr['type'] : "current";
        $cid = isset( $attr['cid'] ) ? ( $attr['cid'][0] == '$' ? $attr['cid']
            : "'{$attr['cid']}'" ) : 0;
        //当前栏目的class样式
        $class = isset( $attr['class'] ) ? $attr['class'] : "''";

        $hide = isset($attr['hide']) ? ( $attr['hide'][0] == '$' ? $attr['hide']
            : "'{$attr['hide']}'" ) : '1';

        $name = isset($attr['name']) ? $attr['name'] : '$m';
        $num = isset($attr['num']) ? $attr['num'] :1000;
        $php = <<<str
<?php
    \$type=strtolower(trim('$type'));
    \$cid = $cid;
    \$num = $num;
    if(!isset(\$column)){
        \$column = load::sys_class('label', 'new')->get('column');
    }
    \$result = \$column->get_column_by_type(\$type,\$cid,\$num);
    
    \$sub = is_array(\$result) ? count(\$result) : 0;
    foreach(\$result as \$index=>\$m):
        if(\$m['display'] == 1){
            continue;
        }
          
        if(\$data['module'] == 10001){
            \$m['url'] = str_replace(array('../',\$_M['url']['site']),'',\$m['url']);
            \$m['content'] = str_replace(array('../',\$_M['url']['site']),'',\$m['content']);
            \$m['indeximg'] = str_replace(array('../',\$_M['url']['site']),'',\$m['indeximg']);
            \$m['columnimg'] = str_replace(array('../',\$_M['url']['site']),'',\$m['columnimg']);
        }
        
        if(\$data['module'] == 404){
            \$m['url'] = str_replace(array('../',\$_M['url']['web_site']),'',\$m['url']);
            if(!strstr(\$m['url'],'http')){
                \$m['url'] = \$_M['url']['web_site'] . \$m['url'];
            }
            \$m['content'] = str_replace(array('../',\$_M['url']['web_site']),'',\$m['content']);
            \$m['indeximg'] = str_replace(array('../',\$_M['url']['web_site']),'',\$m['indeximg']);
            \$m['columnimg'] = str_replace(array('../',\$_M['url']['web_site']),'',\$m['columnimg']);
        }
        
        \$hides = $hide;
        \$hide = explode("|",\$hides);
        \$m['_index']= \$index;
        if(\$data['classnow']==\$m['id'] || \$data['class1']==\$m['id'] || \$data['class2']==\$m['id'] || \$data['releclass'] == \$m['id']){
            \$m['class']="$class";
        }else{
            \$m['class'] = '';
        }
        if(in_array(\$m['name'],\$hide)){
            unset(\$m['id']);
            \$m['hide'] = \$hide;
            \$m['sub'] = 0;
        }

        if(substr(trim(\$m['icon']),0,1) == 'm' || substr(trim(\$m['icon']),0,1) == ''){
            \$m['icon'] = 'icon fa-pencil-square-o '.\$m['icon'];
        }
        \$m['urlnew'] = \$m['new_windows'] ? "target='_blank'" :"target='_self'";
        \$m['urlnew'] = \$m['nofollow'] ? \$m['urlnew']." rel='nofollow'" :\$m['urlnew'];
        \$m['_first']=\$index==0 ? true:false;
        \$m['_last']=\$index==(\$sub-1)?true:false;
        \$$name = \$m;
        
        \$result[\$index] = \$m;
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;

    }


    public function _list( $attr, $content ) {
        global $_M;
        $module = isset( $attr['module'] ) ? $attr['module'] : "";
        $cid = isset( $attr['cid'] ) ? ( $attr['cid'][0] == '$' ? $attr['cid'] : "'{$attr['cid']}'" ) : 0;
        $order = isset($attr['order']) ? $attr['order'] : "'no_order asc'";
        $num = isset($attr['num']) ? $attr['num'] :10;
        $name = isset($attr['name']) ? $attr['name'] : '$v';
        $type = isset($attr['type']) ? $attr['type'][0] == '$' ? $attr['type']
            : "'{$attr['type']}'"  :"'all'";
        $para = isset($attr['para']) ? $attr['para'] : 0;
        if(trim($type) == ''){$type = "'all'";}
        $php = <<<str
<?php
    \$cid=$cid;

    \$num = $num;
    \$module = "$module";
    \$type = $type;
    \$order = $order;
    \$para = "$para";
    if(!\$module){
        if(!\$cid){
            \$value = \$m['classnow'];
        }else{
            \$value = \$cid;
        }
    }else{
        \$value = \$module;
    }

    \$result = load::sys_class('label', 'new')->get('tag')->get_list(\$value, \$num, \$type, \$order, \$para);
    \$sub = is_array(\$result)? count(\$result):0;
    foreach(\$result as \$index=>\$v):
        \$id = \$v['id'];
        \$v['sub'] = \$sub;
        \$v['_index']= \$index;
        \$v['_first']= \$index==0 ? true:false;
        \$v['_last']=\$index==(count(\$result)-1)?true:false;
        \$$name = \$v;    
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;

    }

    public function _app_column($attr,$content)
    {
        global $_M;
        $name = isset($attr['name']) ? $attr['name'] : '$v';
        $php = <<<str
<?php
    \$result = load::mod_class('column/ifcolumn_database','new')->getLeftColumn();
    \$sub = is_array(\$result) ? count(\$result) : 0;
    foreach(\$result as \$index=>\$v):
        \$id = \$v['id'];
        \$v['sub'] = \$sub;
        \$v['_index']= \$index;
        \$v['_first']= \$index==0 ? true:false;
        \$v['_last']=\$index==(count(\$result)-1)?true:false;
        \$v['active']=(\$_M['config']['app_no']==\$v['no']&&\$_M['config']['own_order']==\$v['own_order'])?'active':'';
        \$v['target']=\$v['target']?'target="_blank"':'';
        \$$name = \$v;
?>
str;
        $php .= $content;
        $php .= '<?php endforeach;?>';
        return $php;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.;
#  Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>