<ul class="nav nav-tabs">
    {if condition="checkPath('customer/index')"}
    <li class="active"><a href="{:Url('customer/index')}">客户列表</a></li>
    {/if}
    {if condition="checkPath('customer/customerAdd')"}
    <li><a href="{:Url('customer/customerAdd')}">添加客户</a></li>
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
                        <select name="user_type" class="form-control" lay-verify="">
                            <option value="">客户属性</option>
                            <option value="1" {if input('user_type') == 1}selected{/if}>公司</option>
                            <option value="2" {if input('user_type') == 2}selected{/if}>个人</option>
                        </select>
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
                        <input name="start" value="{:input('start')}" placeholder="起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="结束日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                    </div>
                    {if condition="checkPath('customer/importCustomer')"}
                    <div class="btn-group">
                        <div class="btn btn-success import" lay-data="{'url': '{:url('customer/importCustomer')}',accept:'file'}">导入客户</div>
                    </div>
                    {/if}
                    <div class="btn-group">
                        <a class="btn btn-default" href="__ImagePath__/download/template_customer.xlsx" download="客户导入表模板.xlsx">下载模板</a>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="80">客户名称</th>
                <th width="80">客户姓名</th>
                <th width="60">客户属性</th>
                <th width="80">联系电话</th>
                <th width="60">客户类型</th>
                <th width="60">状态</th>
                <th width="130">创建时间<span order="create_time" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{$v.user_name}</td>
                    <td>{if $v.user_type == 1}公司{elseif $v.user_type == 2}个人{/if}</td>
                    <td>{$v.phone}</td>
                    <td>{if $v.type == 1}合作客户{elseif $v.type == 2}临时客户{/if}</td>
                    <td  class="layui-form">
                        {if condition="checkPath('customer/editStatus')"}
                        <input type="checkbox" data-name="status" data-url="{:url('customer/editStatus',['id'=>$v.id])}" lay-skin="switch" lay-text="开启|禁用" {$v.status == 1 ?'checked':''} data-value="1|0">
                        {else}
                        {$v.status == 1?'<span class="blue">√</span>':'<span class="red">╳</span>'}
                        {/if}
                    </td>
                    <td>{$v.create_time}</td>
                    <td>
                        {if condition="checkPath('customer/customerEdit',['id'=>$v['id']])"}
                        <a  href="{:url('customer/customerEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
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