<ul class="nav nav-tabs">
    {if condition="checkPath('corporation/index')"}
    <li class="active"><a href="{:Url('corporation/index')}">车辆归属</a></li>
    {/if}
    {if condition="checkPath('corporation/corporationAdd')"}
    <li><a href="{:Url('corporation/corporationAdd')}">添加归属</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="归属名称" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="contact" class="form-control" value="{:input('contact')}"  placeholder="联系人员" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="phone" class="form-control" value="{:input('phone')}"  placeholder="联系电话" type="text">
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
                <th width="80">排序</th>
                <th width="80">归属名称</th>
                <th width="80">联系人员</th>
                <th width="80">联系电话</th>
                <th width="80">状态</th>
                <th width="130">创建时间<span order="create_time" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{if condition="checkPath('corporation/orderSort',['id'=>$v['id']])"}
                        <input class="form-control change-data"  post-id="{$v.id}" post-url="{:url('corporation/orderSort')}" value="{$v.sort}">
                        {else}
                        {$v.sort}
                        {/if}
                    </td>
                    <td>{$v.name}</td>
                    <td>{$v.contact}</td>
                    <td>{$v.phone}</td>
                    <td  class="layui-form">
                        {if condition="checkPath('corporation/editStatus')"}
                        <input type="checkbox" data-name="status" data-url="{:url('corporation/editStatus',['id'=>$v.id])}" lay-skin="switch" lay-text="开启|禁用" {$v.status == 1 ?'checked':''} data-value="1|0">
                        {else}
                        {$v.status == 1?'<span class="blue">√</span>':'<span class="red">╳</span>'}
                        {/if}
                    </td>
                    <td>{$v.create_time}</td>
                    <td>
                        {if condition="checkPath('corporation/corporationEdit',['id'=>$v['id']])"}
                        <a  href="{:url('corporation/corporationEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('corporation/corporationDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('corporation/corporationDelete',['id'=>$v['id']])}">删除</a>
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