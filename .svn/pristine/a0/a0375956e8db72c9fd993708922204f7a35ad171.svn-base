<?php
function sql_pin_where($array, $join = 'and', $pux = '`')
{
    if (!empty($array)) {
        $pinArr = [];
        foreach ($array as $k => $v) {
            if (!(strpos($k, '[') && strpos($k, ']'))) {
                $k .= '[=]';
            }
            $s = strpos($k, '[');
            $e = strpos($k, ']');
            $condition = str_replace(']', '', str_replace('[', '', substr($k, $s)));
            $field = str_replace(substr($k, $s), '', $k);
            sql_pin_create_condition($pux . $field . $pux, $condition, $v, $pinArr);
        }
        if (empty($pinArr)) {
            return '';
        }
        if (count($pinArr) == 1) {
            return array_pop($pinArr);
        }
        return implode(" $join ", $pinArr);
    } else {
        return '';
    }
}

function sql_pin_create_condition($filed, $condition, $value, &$pinArr)
{
    $map = [
        'in' => " $filed in (%s) ",
        'not in' => " $filed not in (%s) ",
        '=' => " $filed = '%s' ",
        'like' => " $filed like '%s' "
    ];
    if (is_array($value)) {
        foreach ($value as $v) {
            sql_pin_create_condition($filed, $condition, $v, $pinArr);
        }
    } else {
        if (sql_pin_filter_value($value)) {
            !empty($f = $map[$condition]) ? $pinArr[] = sprintf($f, sql_repalce_custom(strval($value))) : $pinArr[] = " $filed $condition " . sql_repalce_custom($value);
        }
    }
}

function sql_pin_filter_value($value)
{
    if ($value === 0) return true;
    if ($value === '0') return true;
    if (empty($value)) return false;
    if (empty(str_replace('%', '', $value))) return false;
    return true;
}

function sql_add_single($value)
{
    $value = explode(',', $value);
    if (is_array($value)) {
        return implode(',', array_map(function ($v) {
            return "'$v'";
        }, $value));
    } else {
        return "'$value'";
    }
}

function sql_repalce_custom($value)
{
    $custom = [
        'empty' => "''",
        'null' => 'NULL'
    ];
    if (in_array($value, array_keys($custom))) {
        return $custom[$value];
    } else {
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
function sql_get_limit($page = 1, $size = 20)
{
    if ($size) {
        $page || $page = 1;
        $start = ($page - 1) * $size;

        return " $start,$size";
    } else {
        return '1, 500';
    }
}

////////////////////////////////////////////////////////
function array_values_by_key($array, $keys, $func)
{
    if (!empty($keys) && !empty($array)) {
        $return = [];
        foreach ($keys as $k) {
            $value = $array[$k];
            if ($func) {
                if ($func($k, $value)) {
                    $return[$k] = $value;
                }
            } else {
                $return[$k] = $value;
            }
        }
        return $return;
    } else {
        return $array;
    }
}

/////////////////////////////////////////////////////////////

function role_str_add($role_str, $new_role)
{
    if (trim($new_role) == '')
        return $role_str;
    $role_arr = explode(',', $role_str);
    if (!in_array($new_role, $role_arr)) {
        array_push($role_arr, $new_role);
    }
    $role_arr = array_filter($role_arr);
    return implode(',', $role_arr);
}

function role_str_remove($role_str, $remove_role)
{
    if (trim($remove_role) == '')
        return $role_str;
    $role_arr = explode(',', $role_str);

    $pos = array_search($remove_role, $role_arr);
    if ($pos !== false) {
        unset($role_arr[$pos]);
    }
    $role_arr = array_filter($role_arr);
    return implode(',', $role_arr);
}

function html_deconvert_content_cut($content, $len = 45)//被转化过的html内容切割字符串，先转回来html_entity_decode
{
    $content = html_entity_decode($content, ENT_QUOTES);
    $content = str_replace('&nbsp;', ' ', $content);
    $content = str_replace('&quot;', '"', $content);
    $content = str_replace('&#039;', '\'', $content);
    $content = str_replace('&#39;', '\'', $content);
    $content = str_replace('&lt;', '<', $content);
    $content = str_replace('&gt;', '>', $content);
    $content = str_replace('&amp;', '&', $content);
    $content = trim(strip_tags($content));
    if (mb_strlen($content) <= $len) {
        return $content;
    } else {
        return rtrim(mb_substr($content, 0, $len)) . '......';
    }
}

function ShopActivityAccess_add($activity_id)
{
    if ($activity_id <= 0) return;
    $referer = trim($_SERVER['HTTP_REFERER']);
    $referer_arr=parse_url($referer);
//    $referer_fix=$referer_arr['host'].$referer_arr['path'].$referer_arr['query'];
    $referer_fix=$referer_arr['path'].'?'.$referer_arr['query'];
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
//    $host_module_controller_action = $_SERVER['SERVER_NAME'] . '/' . MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
    $host_module_controller_action =  MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
    $ip = $_SERVER['REMOTE_ADDR'];

    $user_agent = strtolower(trim($_SERVER['HTTP_USER_AGENT']));
    $pos = strpos($user_agent, 'artzhe');
    $is_app=$pos===false?0:1;

    $access_log_M = M('ShopActivityAccess');
    $access_log_M->add([
        'activity_id' => intval($activity_id),
        'url' => $url,
        'is_app' => $is_app,
        'referer' => $referer,
        'referer_fix' => $referer_fix,
        'host_module_controller_action' => $host_module_controller_action,
        'ip' => ip2long($ip),
        'create_date' => date('Y-m-d', $_SERVER['REQUEST_TIME']),
        'create_time' => $_SERVER['REQUEST_TIME'],
    ]);
}