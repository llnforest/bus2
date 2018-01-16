<ul class="nav nav-tabs">
    {if condition="checkPath('order/index')"}
    <li class="active"><a href="{:Url('order/index')}">订单管理</a></li>
    {/if}
    {if condition="checkPath('order/orderAdd')"}
    <li><a href="{:Url('order/orderAdd')}">添加订单</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="id" class="form-control" value="{:input('id')}"  placeholder="订单编号" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="客户名称" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="">结账类型</option>
                            <option value="1" {if input('type') == 1}selected{/if}>全包现收</option>
                            <option value="2" {if input('type') == 2}selected{/if}>全包预收</option>
                            <option value="3" {if input('type') == 3}selected{/if}>全包记账</option>
                            <option value="4" {if input('type') == 4}selected{/if}>净价现收</option>
                            <option value="5" {if input('type') == 5}selected{/if}>净价预收</option>
                            <option value="6" {if input('type') == 6}selected{/if}>净价记账</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="">订单状态</option>
                            <option value="0" {if input('type') === '0'}selected{/if}>待派单</option>
                            <option value="1" {if input('type') == 1}selected{/if}>已派单</option>
                            <option value="2" {if input('type') == 2}selected{/if}>交易成功</option>
                            <option value="3" {if input('type') == 3}selected{/if}>交易取消</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="结束日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="60">订单编号</th>
                <th width="70">客户名称</th>
                <th width="55">状态</th>
                <th width="70">订单类型</th>
                <th width="70">结账类型</th>
                <th width="45">人数</th>
                <th width="70">设备要求</th>
                <th width="45">预付</th>
                <th width="70">订单总额</th>
                <th width="90">行车路线</th>
                <th width="100">行车日期<span order="start_date" class="order-sort"> </span></th>
                <th width="45">备注</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.id}</td>
                    <td>{$v.name}</td>
                    <td>{if $v.status == 1}已派单{elseif $v.status == 2}<span class="blue">交易成功</span>{elseif $v.status == 3}<span class="grey">交易取消</span>{else}<span class="red">待派单</span>{/if}</td>
                    <td>{if $v.order_type == 1}普通单次{elseif $v.order_type == 2}常规班次{/if}</td>
                    <td>{if $v.type == 1}全包现收{elseif $v.type == 2}全包预收{elseif $v.type == 3}全包记账{elseif $v.type == 4}净价现收{elseif $v.type == 5}净价预收{elseif $v.type == 6}净价记账{/if}</td>
                    <td>{$v.num}</td>
                    <td>
                        {if $v.is_air}空凋 {/if} {if $v.is_tv}电视 {/if} {if $v.is_microphone}麦克风 {/if} {if $v.is_bathroom}卫生间{/if}
                    </td>
                    <td>{$v.true_money}</td>
                    <td>{$v.total_money}
                        {if $v.return_money}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                                            data-content="返现{$v.return_money}元">返</span>{/if}
                        {if $v.customer_type == 1 && $v.status==2 && $v.total_money-$v.true_money >0}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                                  data-content="老客户记账：{$v.total_money-$v.true_money}元">账</span>{/if}
                        {if $v.customer_type == 2 && $v.status==2 && $v.total_money-$v.true_money >0}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                                                                                           data-content="随车带回：{$v.total_money-$v.true_money}元">带</span>{/if}
                    </td>
                    <td><div>起始:{$v.start_address}</div><div>到达:{$v.end_address}</div></td>
                    <td><div>开始:{$v.start_date}</div><div>结束:{$v.end_date}</div></td>
                    <td>{if $v.remark}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                                  data-content="{$v.remark}">明细</span>{/if}</td>
                    <td>
                        {if condition="checkPath('order/selectBus',['id'=>$v['id']]) && $v.status == 0"}
                        <a  href="{:url('order/selectBus',['id'=>$v['id']])}">需求单派</a>
                        {/if}
                        {if condition="checkPath('order/selectAnyBus',['id'=>$v['id']]) && $v.status == 0"}
                        <a  href="{:url('order/selectAnyBus',['id'=>$v['id']])}">分批配载</a>
                        {/if}
                        {if condition="checkPath('record/index',['order_id'=>$v['id']])"}
                        <a  href="{:url('record/index',['style' => 1,'order_id'=>$v['id']])}">调度记录</a>
                        {/if}
                        {if condition="checkPath('order/orderFollow',['id'=>$v['id']])"}
                        <a  href="{:url('order/orderFollow',['id'=>$v['id']])}">跟单备注</a>
                        {/if}
                        {if condition="checkPath('order/orderDelete',['id'=>$v['id']]) && $v.status == 0"}
                            <span class="span-post" post-msg="确定要关闭订单吗" post-url="{:url('order/editStatus',['id'=>$v['id']])}">关闭订单</span>
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="text-center">
        {$page}
    </div>