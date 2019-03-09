<?php
function sql_pin_where($array,$join = 'and',$pux = '`'){
    if(!empty($array)){
        $pinArr = [];
        foreach ($array as $k=>$v){
            if(!(strpos($k,'[') && strpos($k,']'))){
                $k .= '[=]';
            }
            $s = strpos($k,'[');
            $e = strpos($k,']');
            $condition = str_replace(']','',str_replace('[','',substr($k,$s)));
            $field = str_replace(substr($k,$s),'',$k);
            sql_pin_create_condition($pux.$field.$pux, $condition, $v,$pinArr);
        }
        if(empty($pinArr)){
            return '';
        }
        if(count($pinArr) == 1){
            return array_pop($pinArr);
        }
        return implode(" $join ",$pinArr);
    }else{
        return '';
    }
}
function sql_pin_create_condition($filed,$condition,$value,&$pinArr){
    $map = [
        'in' => " $filed in (%s) ",
        'not in' => " $filed not in (%s) ",
        '=' => " $filed = '%s' ",
        'like' => " $filed like '%s' "
    ];
    if(is_array($value)){
        foreach ($value as $v){
            sql_pin_create_condition($filed, $condition, $v, $pinArr);
        }
    }else{
        if(sql_pin_filter_value($value)){
            !empty($f = $map[$condition]) ? $pinArr[] = sprintf($f,sql_repalce_custom(strval($value))) : $pinArr[] = " $filed $condition " . sql_repalce_custom($value);
        }
    }
}
function sql_pin_filter_value($value){
    if($value === 0)return true;
    if($value === '0')return true;
    if(empty($value))return false;
    if(empty(str_replace('%', '', $value)))return false;
    return true;
}
function sql_add_single($value){
    $value = explode(',', $value);
    if(is_array($value)){
        return implode(',', array_map(function($v){
            return "'$v'";
        }, $value));
    }else{
        return "'$value'";
    }
}
function sql_repalce_custom($value){
    $custom = [
        'empty' => "''",
        'null' => 'NULL'
    ];
    if(in_array($value,array_keys($custom))){
        return $custom[$value];
    }else{
        return $value;
    }
}
/**
 * 返回mysql的limit
 *
 * @param INT $page
 * @param INT $size
 * @return string
 */
function sql_get_limit($page=1, $size=20) {
	if ($size) {
		$page || $page = 1;
		$start = ($page - 1) * $size;

		return " $start,$size";
	}
	else {
		return '1, 500';
	}
}
////////////////////////////////////////////////////////
function array_values_by_key($array,$keys,$func){
  if(!empty($keys) && !empty($array)){
    $return = [];
    foreach ($keys as $k) {
      $value = $array[$k];
      if($func){
        if($func($k,$value)){
          $return[$k] = $value;
        }
      }else{
        $return[$k] = $value;
      }
    }
    return $return;
  }else{
    return $array;
  }
}
/////////////////////////////////////////////////////////////

function role_str_add($role_str, $new_role) {
    if (trim($new_role) == '')
        return $role_str;
    $role_arr = explode(',', $role_str);
    if (!in_array($new_role, $role_arr)) {
        array_push($role_arr, $new_role);
    }
    $role_arr=array_filter($role_arr);
    return implode(',', $role_arr);
}

function role_str_remove($role_str, $remove_role) {
    if (trim($remove_role) == '')
        return $role_str;
    $role_arr = explode(',', $role_str);

    $pos = array_search($remove_role, $role_arr);
    if ($pos !== false) {
        unset($role_arr[$pos]);
    }
    $role_arr=array_filter($role_arr);
    return implode(',', $role_arr);
}

function role_get_str($role_str) {
    $role_list=[
        'artist'=>'艺术家',
        'agency'=>'机构',
        'planner'=>'策展人',
    ];
    $return_str='';
    $role_str_arr=explode(',',$role_str);
    foreach ($role_str_arr as $value){
        $return_str=$return_str==''?$role_list[''.$value.'']:$return_str.','.$role_list[''.$value.''];
    }
    return $return_str;
}

 function html_deconvert_content_cut($content, $len = 45)//被转化过的html内容切割字符串，先转回来html_entity_decode
{
    $content=html_entity_decode($content, ENT_QUOTES);
    $content=str_replace('&nbsp;', ' ', $content);
    $content=str_replace('&quot;', '"', $content);
    $content=str_replace('&#039;', '\'', $content);
    $content=str_replace('&#39;', '\'', $content);
    $content=str_replace('&lt;', '<', $content);
    $content=str_replace('&gt;', '>', $content);
    $content=str_replace('&amp;', '&', $content);
    $content=trim(strip_tags($content));
    if (mb_strlen($content) <= $len) {
        return $content;
    } else {
        return rtrim(mb_substr($content, 0, $len)) . '......';
    }
}

function html_deconvert_content_cut_forApp($content, $len = 45)//APP原生显示专用（html内容简介）,原生APP不支持html,所以要两次html_entity_decode
{
    $content = html_entity_decode($content, ENT_QUOTES);
    $content = html_entity_decode($content, ENT_QUOTES);
    $content = trim(strip_tags($content));
    $content = str_replace("\r\n", '', $content);
    $content = str_replace("\r", '', $content);
    $content = str_replace("\n", '', $content);
    if (mb_strlen($content) <= $len) {
        $return_str=$content;
//         $return_str = trim($content, " \t\n\r\0\x0B\xC2\xA0");#去除html_entity_decode转换前的&nbsp;空格
        return trim($return_str);
    } else {
        $return_str = mb_substr($content, 0, $len);
//         $return_str = trim($return_str, " \t\n\r\0\x0B\xC2\xA0");#去除html_entity_decode转换前的&nbsp;空格
        return trim($return_str) . '......';
    }
}

function html_content_cut($content, $len = 45)//html内容切割字符串
{
    $content=str_replace('&nbsp;', ' ', $content);
    $content=str_replace('&quot;', '"', $content);
    $content=str_replace('&#039;', '\'', $content);
    $content=str_replace('&#39;', '\'', $content);
    $content=str_replace('&lt;', '<', $content);
    $content=str_replace('&gt;', '>', $content);
    $content=str_replace('&amp;', '&', $content);
    $content=trim(strip_tags($content));
    if (mb_strlen($content) <= $len) {
        return $content;
    } else {
        return rtrim(mb_substr($content, 0, $len)) . '......';
    }
}

function html_deconvert_content($content)//被转化过的html内容，先转回来html_entity_decode,再替换
{
    $content=html_entity_decode($content, ENT_QUOTES);
    $content=str_replace('&nbsp;', ' ', $content);
    $content=str_replace('&quot;', '"', $content);
    $content=str_replace('&#039;', '\'', $content);
    $content=str_replace('&#39;', '\'', $content);
    $content=str_replace('&lt;', '<', $content);
    $content=str_replace('&gt;', '>', $content);
    $content=str_replace('&amp;', '&', $content);
    return $content;
}

 function oss_user_file_dir($userid){// 类似：用户id:122455返回 user/122/455/files
    $userid=intval($userid);
    $length_fix=3;
    $return_str='user';
    $length=strlen($userid);
    for($i=0;$i<$length;$i++){
        if($i%3==0)
            $return_str=$return_str.'/'. substr($userid, $i,$length_fix);
    }
    $return_str=$return_str.'/files';
    return $return_str;
}
/*
 * userid,
 * role  (artist 艺术家,agency 机构,planner 策展人)
 */
function CheckUserRole($user_id,$role){
    $userinfo=M('user')->field('role')->where(['id'=>$user_id])->find();
   if(strpos(',' . $userinfo['role'] . ',', ','.$role.',') === false){
       $data=[
           'data' => ['status' => 1000],
           'code' => 30004,
           'message' => '没有'.$role.'权限',
       ];
       header('Content-Type:application/json; charset=utf-8');
       echo json_encode($data);
       exit();
   }
}

function checkDateFormat($date)
{
    if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
        if (checkdate($parts[2], $parts[3], $parts[1])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}