<ul class="nav nav-tabs">
    {if condition="checkPath('customer/index')"}
    <li><a href="{:Url('customer/index')}">客户总账</a></li>
    {/if}
    {if condition="checkPath('customer/customerList')"}
    <li class="active"><a href="{:Url('customer/customerList')}">账单列表</a></li>
    {/if}
    {if condition="checkPath('customer/customerAdd')"}
    <li><a href="{:Url('customer/customerAdd')}">添加账单</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">

                    <div class="btn-group">
                        {if input('customer_id')}
                        <input name="customer_id" class="form-control" value="{:input('customer_id')}"  placeholder="客户id" type="hidden">
                        {else}
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="客户名称" type="text">
                        {/if}
                    </div>
                    <div class="btn-group layui-form">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="">入账类型</option>
                            <option value="1" {if input('type') == 1}selected{/if}>欠款</option>
                            <option value="2" {if input('type') == 2}selected{/if}>还款</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="入账起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="入账截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="80">客户名称</th>
                <th width="80">入账类型</th>
                <th width="60">入账金额</th>
                <th width="60">入账时间<span order="add_date" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{if $v.type == 1}<span class="red">欠款</span>{elseif $v.type == 2}<span class="blue">还款</span>{/if}</td>
                    <td>{$v.money}</td>
                    <td>{$v.add_date}</td>
                    <td>
                        {if condition="checkPath('customer/customerDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('customer/customerDelete',['id'=>$v['id']])}">删除</a>
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