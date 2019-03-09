<?php

namespace Custom\Helper;


class Nav extends Base
{
    public static function render($baseUrl, $params, $page, $perPageCount, $totalCount, $fixPageNumber = 5)
    {
        if ($page <= 0||$perPageCount <=0||$totalCount <= 0 ||$page>$totalCount) {
            return false;
        }
        $totalPageCount = ceil($totalCount/$perPageCount);
        $lastPageGroupCount = $totalPageCount%$fixPageNumber;
        $navPrefix = '<nav aria-label="az-label-pager">
                      <ul class="pagination pagination-lg">';
        $navSuffix = '</ul>
                      </nav>';
        if ($page == $totalPageCount) {
            if ($page == 1) {
                $pagerUrl = self::buildPageUrl($baseUrl, $params, $page, $perPageCount);
                $pagerBody = '<li  class="disabled"><span aria-hidden="true">«</span></li>
                              <li  class="active"><a href="'.$pagerUrl.'">'.$page.'</a></li>
                              <li  class="disabled"><span aria-hidden="true">»</span></li>';
            } else {
                $listContent  = '';
                if ($page%$fixPageNumber == 0){
                    for ($i=$fixPageNumber-1;$i>=0; $i--)
                    {
                        $pagerUrl = self::buildPageUrl($baseUrl, $params, $page-$i, $perPageCount);
                        if ($page == $page-$i) {
                            $listContent .= '<li class="active"><a href="'.$pagerUrl.'">'.$page.'</a></li>';
                            continue;
                        }
                        $listContent .= '<li><a href="'.$pagerUrl.'">'.($page-$i).'</a></li>';
                    }
                } else {
                    $restPageCount = $page%$fixPageNumber;
                    for ($i= $page -$restPageCount+1; $i<=$page; $i++)
                    {
                        $pagerUrl = self::buildPageUrl($baseUrl, $params, $i, $perPageCount);
                        if ($page == $i) {
                            $listContent .= '<li class="active"><a href="'.$pagerUrl.'">'.$page.'</a></li>';
                            continue;
                        }
                        $listContent .= '<li><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                    }
                }
                $previousUrl = self::buildPageUrl($baseUrl, $params, $page-1, $perPageCount);
                $pagerBody = '<li><a href="'.$previousUrl.'" aria-label="Previous"><span aria-hidden="true">«</span></a></li>'.
                                $listContent.
                              '<li  class="disabled"><a href="#"  aria-label="Next"><span aria-hidden="true">»</span></a></li>';
            }
        }else {
            //$page < $totalPageCount
            if ($page == 1) {
                $pagerUrl = self::buildPageUrl($baseUrl, $params, $page, $perPageCount);
                $pagerBody = '<li  class="disabled"><span aria-hidden="true">«</span></li>
                                <li class="active"> <a href="'.$pagerUrl.'">'.$page.'</a></li>';
                $listContent = '';
                if ($totalPageCount <= $fixPageNumber) {
                    for ($i =2; $i<=$totalPageCount; $i++) {
                        $pagerUrl = self::buildPageUrl($baseUrl, $params, $i, $perPageCount);
                        $listContent .= '<li><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                    }
                    $nextUrl = self::buildPageUrl($baseUrl, $params, 2, $perPageCount);
                    $listContent .= '<li ><a href="'.$nextUrl.'"  aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                    $pagerBody .= $listContent;
                } else {
                    for ($i =2; $i<=$fixPageNumber; $i++) {
                        $pagerUrl = self::buildPageUrl($baseUrl, $params, $i, $perPageCount);
                        $listContent .= '<li><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                    }
                    $nextUrl = self::buildPageUrl($baseUrl, $params, 2, $perPageCount);
                    $listContent .= '<li ><a href="'.$nextUrl.'"  aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                    $pagerBody .= $listContent;
                }

            } else {
                $previousUrl = self::buildPageUrl($baseUrl, $params, $page -1, $perPageCount);
                $nextUrl = self::buildPageUrl($baseUrl, $params, $page +1, $perPageCount);
                $listContent = '';
                if ($page%$fixPageNumber == 0) {
                    for ($i= $page -$fixPageNumber +1; $i <= $page; $i++) {
                        $pagerUrl = self::buildPageUrl($baseUrl, $params, $i, $perPageCount);
                        if ($i == $page) {
                            $listContent .= '<li class="active"><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                        } else {
                            $listContent .= '<li><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                        }
                    }
                } else {
                    if ($page < $totalPageCount - $lastPageGroupCount) {
                        for ($i= ($page - $page%$fixPageNumber +1); $i<($page - $page%$fixPageNumber +1+$fixPageNumber); $i++) {
                            $pagerUrl = self::buildPageUrl($baseUrl, $params, $i, $perPageCount);
                            if ($i == $page) {
                                $listContent .= '<li class="active"><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                            } else {
                                $listContent .= '<li><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                            }
                        }
                    } else {
                        for ($i= $totalPageCount - $lastPageGroupCount+1; $i<= $totalPageCount; $i++)
                        {
                            $pagerUrl = self::buildPageUrl($baseUrl, $params, $i, $perPageCount);
                            if ($i == $page) {
                                $listContent .= '<li class="active"><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                            } else {
                                $listContent .= '<li><a href="'.$pagerUrl.'">'.$i.'</a></li>';
                            }
                        }

                    }
                }
                $pagerBody = '<li><a href="'.$previousUrl.'">«</a></li>'.$listContent.'<li><a href="'.$nextUrl.'">»</a></li>';
            }
        }
        return $navPrefix.$pagerBody.$navSuffix;
    }
    public static function buildPageUrl($baseUrl, $params, $page, $perPageCount)
    {
        $pageParams = [
            'page'=>$page,
            'perPageCount'=>$perPageCount,
        ];
        $params = array_merge($params, $pageParams);
        return $baseUrl."?".http_build_query($params);
    }
}