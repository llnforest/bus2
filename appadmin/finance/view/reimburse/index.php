<ul class="nav nav-tabs">
    {if condition="checkPath('reimburse/index')"}
    <li class="active"><a href="{:Url('reimburse/index')}">报销列表</a></li>
    {/if}
    {if condition="checkPath('reimburse/reimburseAdd')"}
    <li><a href="{:Url('reimburse/reimburseAdd')}">添加报销</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="title" class="form-control" value="{:input('title')}"  placeholder="报销项目" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="员工姓名" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="department_id" class="form-control" lay-verify="">
                            <option value="">选择部门</option>
                            {foreach $department as $v}
                            <option value="{$v.id}" {if input('department_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="报销起始日期" readonly dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="报销结束日期" readonly dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="100">报销项目</th>
                <th width="80">员工姓名</th>
                <th width="60">报销部门</th>
                <th width="60">报销金额<span order="a.fee" class="order-sort"> </span></th>
                <th width="60">报销日期<span order="a.reimburse_date" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.title}</td>
                    <td>{$v.user_name}</td>
                    <td>{$v.department_name}</td>
                    <td>{$v.fee}</td>
                    <td>{$v.reimburse_date}</td>
                    <td>
                        {if condition="checkPath('reimburse/reimburseEdit',['id'=>$v['id']])"}
                        <a  href="{:url('reimburse/reimburseEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('reimburse/reimburseDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('reimburse/reimburseDelete',['id'=>$v['id']])}">删除</a>
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