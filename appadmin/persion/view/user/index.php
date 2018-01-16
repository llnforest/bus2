<ul class="nav nav-tabs">
    {if condition="checkPath('user/index')"}
    <li class="active"><a href="{:Url('user/index')}">员工列表</a></li>
    {/if}
    {if condition="checkPath('user/userAdd')"}
    <li><a href="{:Url('user/userAdd')}">添加员工</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="员工姓名" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="num" class="form-control" value="{:input('num')}"  placeholder="员工编号" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="phone" class="form-control" value="{:input('phone')}"  placeholder="手机号码" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="level_id" class="form-control" lay-verify="">
                            <option value="">选择岗位</option>
                            {foreach $level as $v}
                            <option value="{$v.id}" {if input('level') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="department_id" class="form-control" lay-verify="">
                            <option value="">选择部门</option>
                            {foreach $department as $v}
                            <option value="{$v.id}" {if input('department_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="is_driver" class="form-control" lay-verify="">
                            <option value="">是否驾驶员</option>
                            <option value="1" {if input('is_driver') == 1}selected{/if}>是</option>
                            <option value="0" {if input('is_driver') === '0'}selected{/if}>否</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="is_partner" class="form-control" lay-verify="">
                            <option value="">车辆股东</option>
                            <option value="1" {if input('is_driver') == 1}selected{/if}>是</option>
                            <option value="0" {if input('is_driver') === '0'}selected{/if}>否</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="起始日期" readonly dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="结束日期" readonly dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                    </div>
                    {if condition="checkPath('user/importUser')"}
                    <div class="btn-group">
                        <div class="btn btn-success import" lay-data="{'url': '{:url('user/importUser')}',accept:'file'}">导入员工</div>
                    </div>
                    {/if}
                    <div class="btn-group">
                        <a class="btn btn-default" href="__ImagePath__/download/template_user.xlsx" download="员工导入表模板.xlsx">下载模板</a>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="80">员工编号</th>
                <th width="80">员工姓名</th>
                <th width="80">手机号码</th>
                <th width="60">部门</th>
                <th width="60">岗位</th>
                <th width="60">驾驶员</th>
                <th width="60">股东</th>
                <th width="60">状态</th>
                <th width="130">创建时间<span order="create_time" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.num}</td>
                    <td><span class="span-primary user-detail" data-id="{$v.id}">{$v.name}</span></td>
                    <td>{$v.phone}</td>
                    <td>{$v.department_name}</td>
                    <td>{$v.level_name}</td>
                    <td>{if $v.is_driver == 1}是{else}否{/if}</td>
                    <td>{if $v.is_partner == 1}是{else}否{/if}</td>
                    <td>{if $v.status == 1}在职{elseif $v.status == 2}离职{/if}</td>
                    <td>{$v.create_time}</td>
                    <td>
                        {if condition="checkPath('user/userDetail',['id'=>$v['id']])"}
                        <a  href="{:url('user/userDetail',['id'=>$v['id']])}">详情</a>
                        {/if}
                        {if condition="checkPath('user/userEdit',['id'=>$v['id']])"}
                        <a  href="{:url('user/userEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('user/userDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('user/userDelete',['id'=>$v['id']])}">删除</a>
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
<script>
    {if condition="checkPath('user/userInfo',['id'=>$v['id']])"}
    $('.user-detail').mouseover(function(){
        var id = $(this).attr("data-id");
        openLayer = layer.open({
            type: 2,
            title: '员工详情',
            shadeClose: true,
            shade: false,
            area: ['400px', '500px'],
            content: "{:url('user/userInfo','','')}/id/"+id,
        })
    }).mouseout(function(){
        layer.close(openLayer)
    });
    {/if}
</script>