<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 核心中文语言包
return [
    // 系统错误提示
    'Undefined variable'        => '未定义变量',
    'Undefined index'           => '未定义数组索引',
    'Undefined offset'          => '未定义数组下标',
    'Parse error'               => '语法解析错误',
    'Type error'                => '类型错误',
    'Fatal error'               => '致命错误',
    'syntax error'              => '语法错误',

    // 框架核心错误提示
    'dispatch type not support' => '不支持的调度类型',
    'method param miss'         => '方法参数错误',
    'method not exists'         => '方法不存在',
    'module not exists'         => '模块不存在',
    'controller not exists'     => '控制器不存在',
    'class not exists'          => '类不存在',
    'property not exists'       => '类的属性不存在',
    'template not exists'       => '模板文件不存在',
    'illegal controller name'   => '非法的控制器名称',
    'illegal action name'       => '非法的操作名称',
    'url suffix deny'           => '禁止的URL后缀访问',
    'Route Not Found'           => '当前访问路由未定义',
    'Underfined db type'        => '未定义数据库类型',
    'variable type error'       => '变量类型错误',
    'PSR-4 error'               => 'PSR-4 规范错误',
    'not support total'         => '简洁模式下不能获取数据总数',
    'not support last'          => '简洁模式下不能获取最后一页',
    'error session handler'     => '错误的SESSION处理器类',
    'not allow php tag'         => '模板不允许使用PHP语法',
    'not support'               => '不支持',
    'redisd master'             => 'Redisd 主服务器错误',
    'redisd slave'              => 'Redisd 从服务器错误',
    'must run at sae'           => '必须在SAE运行',
    'memcache init error'       => '未开通Memcache服务，请在SAE管理平台初始化Memcache服务',
    'KVDB init error'           => '没有初始化KVDB，请在SAE管理平台初始化KVDB服务',
    'fields not exists'         => '数据表字段不存在',
    'where express error'       => '查询表达式错误',
    'no data to update'         => '没有任何数据需要更新',
    'miss data to insert'       => '缺少需要写入的数据',
    'miss complex primary data' => '缺少复合主键数据',
    'miss update condition'     => '缺少更新条件',
    'model data Not Found'      => '模型数据不存在',
    'table data not Found'      => '表数据不存在',
    'delete without condition'  => '没有条件不会执行删除操作',
    'miss relation data'        => '缺少关联表数据',
    'tag attr must'             => '模板标签属性必须',
    'tag error'                 => '模板标签错误',
    'cache write error'         => '缓存写入失败',
    'sae mc write error'        => 'SAE mc 写入错误',
    'route name not exists'     => '路由标识不存在（或参数不够）',
    'invalid request'           => '非法请求',
    'bind attr has exists'      => '模型的属性已经存在',
    'relation data not exists'  => '关联数据不存在',

    //2.0版系统提示
    'system_close'              => '系统维护升级中，请稍候再试！',
    'system_error'              => '网络异常，请稍后再试！',
    'system_data_error'         => '参数错误',
    'system_edit_success'       => '修改成功',
    'system_upload_success'     => '上传成功',
    'system_combit_success'     => '申请成功',
    'system_do_success'         => '操作成功',
    'system_do_error'           => '操作失败',
    'system_del_success'        => '删除成功',
    'system_del_confirm'        => '确认删除么？',
    'system_page_nodata'        => '还没有数据产生哦！',
    'system_work_time'          => '周一到周日  09:00-18:00',

    'reg_phone_hasd_errot'      => '该手机号已被注册',
    'reg_success'               => '注册成功,请登陆！',
    'reg_weixin_success'        => '注册成功,即将进入平台！',
    'reg_error'                 => '注册失败',
    'reg_account_hasd_errot'    => '该账号已被注册',

    'agent_has_nodata'          => '经销商不存在',

    'login_session_error'       => '您还没有登录！',
    'login_user_nofound'        => '账号不存在',
    'login_user_nostatus'       => '账号未审核',
    'login_user_logout'         => '注销成功',
    'login_success'             => '登录成功',
    'login_info_error'          => '账号或者密码错误',

    'password_check_error'      => '两次输入密码不一致',

    'sms_phone_data_error'      => '手机号码格式不正确',
    'sms_phone_time_error'      => '手机短信验证码申请时间过短',
    'sms_phone_num_error'       => '当日手机验证码接收条数过多，请联系客服解决！',
    'sms_success'               => '发送成功',
    'sms_check_phone_error'     => '手机号码错误',
    'sms_data_error'            => '验证码错误',
    'sms_check_success'         => '验证码正确',
    'sms_send_success'          => '验证码已发送至手机，请注意查收',

    'veri_phone_null_error'     => '手机号码不能为空！',

    'authen_updata_data'        => '提交成功,请等待审核',
    'authen_no_error'           => '您的账户尚未通过实名认证！',
    'authen_no_error_take'      => '未实名认证账号不能提现，',
    'authen_no_error_account'   => '未实名认证账号不能添加收款账号！',
    'authen_no_status'          => '您的账户实名认证审核中！',
    'authen_read_error'         => '身份证照片识别错误，请重新拍照或联系客服！',

    'assessment_success'        => '手机估价成功',
    'assessment_eval_nohas'     => '参数选全了再估价哦',
    'assessment_no_able'        => '未解锁账号手机无法进行估价回收',
    'assessment_data_error'     => '您提交此参数的手机暂时还没找到价格，请联系客服！',

    'account_name'              => '财务账号',
    'account_nofount'           => '未绑定',
    'account_del_success'       => '解绑成功',
    'accoutn_only_my'           => '只可绑定认证用户账户',
    'account_no_data'           => '还没有财务账户哦！请先添加！',
    'account_data_has'          => '该账号已被绑定，请更换',
    'account_phone_error'       => '该手机号非账号绑定的手机号',

    'recovery_update_success'   => '回收车更新成功',
    'recovery_has_order'        => '该估价数据已下订单，请返回首页重新操作！',
    'recovery_add_success'      => '加入回收车成功',
    'recovery_no_title'         => '回收车是空的，快去填满它',
    'recovery_no_data'          => '您的回收车里太空了，没办法下单哦，请赶紧去装满它！',
    'recovery_price_error'      => '回收车内手机价格低于200元哦，快去凑单吧',
    'recovery_price_member_error'      => '回收车内手机价格低于100元哦，快去凑单吧',
    'recovery_order_price_error'=> '订单价格低于100元哦，快去凑单吧',
    'recovery_delete_confirm'   => '确认将该手机从回收车删除么？',


    'finance_take_tips'         => '只可提现至认证用户账户内',
    'finance_take_money_tips'   => '最低提现金额不少于100元',
    'finance_take_money_tips_0' => '最低提现金额不少于0元',
    'finance_take_can_tips'     => '您最多提现金额不能大于钱包里的余额哦',


    'order_make_address'        => '手机退回只退回原下单地址，请保证下单地址的正确性哦！',
    'order_make_call_address'   => '上门回收会依照您的取件地址，请保证取件地址的正确性哦！',
    'order_phone_deal_confirm'  => '确认成交该订单内所有已定价手机么？',
    'order_recovery_nodata'     => '回收车内无估价数据,请勿重复结算',
    'order_recovery_price'      => '回收车内手机价格已变动，请返回确认',
    'order_member_phone_price'  => '您所选的手机价格已变动，请重新估价',
    'order_make_noaddress'      => '下单地址信息错误',
    'order_no_deal_phone'       => '该订单下暂无已定价手机',
    'order_deal_phone_success'  => '已定价手机成交成功',
    'order_make_success'        => '订单提交成功',
    'order_make_success_info'   => "您的订单已提交成功。请尽快将您的机器寄出，收货地址:address，联系人:name，联系电话:phone。快递寄出后，请在“我的”-“订单中心”-“去发货”处选择快递方式并填入快递单号。如有疑问，请联系客服400-6088891",
    'order_make_success_express'=> '您的订单已提交成功,实价收会在1小时内为您安排快递，届时快递人员会联系您上门取件，请保持联系电话畅通。收货地址:address，联系人:name，联系电话:phone。快递寄出后，请在“我的”-“订单中心”-“去发货”处选择快递方式并填入快递单号。如有疑问，请联系客服4006088891',
    'order_make_succ_shangmen'  => '您的订单已提交成功,实价收客服人会在一个小时内联系您并为您安排上门服务人员，请保持联系电话畅通。如有疑问，请联系客服<a href="tel:4006088891">4006088891</a>',

    'report_data_save'          => '实价收会对手机进行专业格式化数据清理，以保障用户隐私数据安全性',
    'report_phone_deal_confirm' => '确认检验结果并成交该手机吗？',
    'report_phone_back_confirm' => '确定退回该手机吗？',

    'report_company_info'       => '北京实价科技有限公司质检中心对以上质检结果真实性承诺',
    'order_phone_deal'          => '确认并成交成功',
    'order_phone_back'          => '要求退回成功',
    'order_phone_cancel'        => '取消交易成功',
    'order_two_deal'            => '请勿重复成交',

    'express_send_error'        => '物流单号格式不正确',

    'addresss_data_error'       => '姓名手机号不可为空',

    'search_no_data'            => '很抱歉，没有找到与" <font></font> "相关的机型信息<br />实价收建议您：<br />1.减少关键词数量，扩大搜索范围进行重新搜索，如“金立W909”可以去掉“金立”进行重新搜索<br />2.若重新搜索还是没有，请联系在线客服尝试添加机器型号',


    'channel_data_sign'         => '数据校验错误',
    'channel_data_extra_error'  => '附加信息错误',
    'channel_order_has_error'   => '商品数据重复下单，请重新填写商品参数',

    'phone_check_error'         => '手机号已被绑定，请更换',
    'phone_hasd_errot'          => '手机号码与当前号码重复，无需修改',
    'phone_edit_success'        => '修改手机号码成功',

    'weixin_phone_nostatus'     => '手机号码未审核',
    'weixin_bind_nostatus'      => '微信账号未审核',
    'weixin_phone_unbind'       => '手机号未解绑',
    'weixin_is_bind'            => '微信未解绑',
    'weixin_bind_success'       => '绑定微信成功',
    'map_nofound_store'         => '本地暂无线下授权门店',

    'user_operate_again'        => '请勿重复操作',

    'buy_phone_detail_num'      => '参数选全了再提交哦',
    'buy_success'               => '我们已经收到您的需求，将尽快和您联系',
    'buy_data_again'            => '我们已经有您对该机型相同的参数需求咯',

    'contact_success'           => '系统已收到您的反馈，我们将尽快和您联系！',
];
