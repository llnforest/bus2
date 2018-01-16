<ul class="nav nav-tabs">
    {if condition="checkPath('customer/index')"}
    <li class="active"><a href="{:Url('customer/index')}">客户总账</a></li>
    {/if}
    {if condition="checkPath('customer/customerList')"}
    <li><a href="{:Url('customer/customerList')}">账单列表</a></li>
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
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="客户名称" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="phone" class="form-control" value="{:input('phone')}"  placeholder="联系电话" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="">客户类型</option>
                            <option value="1" {if input('type') == 1}selected{/if}>合作客户</option>
                            <option value="2" {if input('type') == 2}selected{/if}>临时客户</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="status" class="form-control" lay-verify="">
                            <option value="">客户状态</option>
                            <option value="1" {if input('status') == 1}selected{/if}>正常</option>
                            <option value="0" {if input('status') === '0'}selected{/if}>禁用</option>
                        </select>
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
                <th width="80">联系电话</th>
                <th width="60">客户类型</th>
                <th width="60">状态</th>
                <th width="60">欠账<span order="lend_money" class="order-sort"> </span></th>
                <th width="60">还账<span order="back_money" class="order-sort"> </span></th>
                <th width="60">总账<span order="total_money" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{$v.phone}</td>
                    <td>{if $v.type == 1}合作客户{elseif $v.type == 2}临时客户{/if}</td>
                    <td  class="layui-form">
                        {$v.status == 1?'<span class="blue">正常</span>':'<span class="red">禁用</span>'}
                    </td>
                    <td>{$v.lend_money}</td>
                    <td>{$v.back_money}</td>
                    <td>{$v.total_money}</td>
                    <td>
                        {if condition="checkPath('customer/customerAdd',['id'=>$v['id']])"}
                        <a  href="{:url('customer/customerAdd',['id'=>$v['id']])}">入账</a>
                        {/if}
                        {if condition="checkPath('customer/customerList',['customer_id'=>$v['id']])"}
                        <a  href="{:url('customer/customerList',['customer_id'=>$v['id']])}">账单</a>
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