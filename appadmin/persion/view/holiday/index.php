<ul class="nav nav-tabs">
    {if condition="checkPath('holiday/index')"}
    <li class="active"><a href="{:Url('holiday/index')}">请假列表</a></li>
    {/if}
    {if condition="checkPath('holiday/holidayAdd')"}
    <li><a href="{:Url('holiday/holidayAdd')}">添加请假</a></li>
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
                        <input name="start" value="{:input('start')}" placeholder="起始日期" readonly dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="结束日期" readonly dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="80">员工姓名</th>
                <th width="80">开始日期</th>
                <th width="60">结束日期</th>
                <th width="60">天数</th>
                <th width="60">类型</th>
                <th width="60">备注</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{$v.start_date}</td>
                    <td>{$v.end_date}</td>
                    <td>{$v.days}</td>
                    <td>{if $v.type == 1}事假{elseif $v.type == 2}病假{else}其他{/if}</td>
                    <td>{if $v.remark}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                            data-content="{$v.remark}">明细</span>{/if}</td>
                    <td>
                        {if condition="checkPath('holiday/holidayEdit',['id'=>$v['id']])"}
                        <a  href="{:url('holiday/holidayEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('holiday/holidayDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('holiday/holidayDelete',['id'=>$v['id']])}">删除</a>
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