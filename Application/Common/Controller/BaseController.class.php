<?php

namespace Common\Controller;

/**
 * Class BaseController
 * @author yourname
 */
class BaseController extends \Think\Controller {

       /**
        * 分页控件
        * @param $total int     总记录数
        * @param $size  int     每页显示的记录数
        * @param $type  string  类型
        * */
        protected function _pageShow($total, $size, $type = 'default') {
                $page = new \Common\Lib\Page($total, $size);// 实例化分页类 传入总记录数和每页显示的记录数
                switch($type) {
//                    case C('TPL_PAGE_SHOW_NORMAL'):
//                        $page->setConfig('theme'
//, '<div class="dataTables_paginate paging_bootstrap_full"><ul class="pagination">
// <li>%UP_PAGE%</li> <li>%FIRST%</li> <li>%LINK_PAGE%</li> <li>%END%</li> <li>%DOWN_PAGE%</li> </ul></div>');
//                        break;
//                    case C('TPL_PAGE_SHOW_IMPROVE'):
//                        $page->setConfig('theme', '<div class="dataTables_paginate paging_bootstrap_f
//ull"><ul class="pagination">
// <li>%UP_PAGE%</li>
// <li>%FIRST%</li>
// <li>%LINK_PAGE%</li>
// <li>%END%</li>
// <li>%DOWN_PAGE%</li>
// </ul>
// <ul class="pagination pull-right"> <li>'.$this->_pageNumberWidget($size, C('SEARCH_DEFAULT_PAGE_ASSEMBLAGE')).'</li> <li><i>条/页</i></li> <li><i>(%HEADER%)</i></li> </ul> </div>');
//                        break;
                    default:
                        $theme = <<<EOF
<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_info" id="sample-table_info" role="status" aria-live="polite">%1TOTAL_ROW%</div>
    </div>
    <div class="col-sm-6">
        <div class="dataTables_paginate paging_bootstrap" id="sample-table_paginate">
            <ul class="pagination">
                <li class="prev disabled">%UP_PAGE% </li>
                %LINK_PAGE%
                <li class="next disabled">%DOWN_PAGE%</li>
            </ul>
        </div>
    </div>
</div>
EOF;


                        $page->setConfig('prev', '上一页');
                        $page->setConfig('next', '下一页');
                         $page->setConfig('theme', $theme);
                    break;
                }
        
                $show = $page->show();// 分页显示输出
                $this->assign('my_page', $show);// 赋值分页输出
        }


}
