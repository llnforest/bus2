<ul class="nav nav-tabs">
    {if condition="checkPath('check/index')"}
    <li class="active"><a href="{:Url('check/index')}">年检列表</a></li>
    {/if}
    {if condition="checkPath('check/checkAdd')"}
    <li><a href="{:Url('check/checkAdd')}">添加年检</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" value="{:input('num')}" placeholder="车牌号" class="form-control"  type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="contact_id" class="form-control" lay-verify="">
                            <option value="">检测站</option>
                            {foreach $contact as $v}
                            <option value="{$v.id}" {if input('contact_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group">年检日期:</div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="年检起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="年检截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">到期日期:</div>
                    <div class="btn-group">
                        <input name="start_date" value="{:input('start_date')}" placeholder="到期起始日期" dom-class="date-start-end" class="date-time date-start-end form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end_date" value="{:input('end_date')}" placeholder="到期截止日期" dom-class="date-end-end" class="date-time date-end-end form-control laydate-icon"  type="text">
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
                <th width="80">车牌号</th>
                <th width="60">检测站</th>
                <th width="60">年检费用</th>
                <th width="80">年检日期<span order="a.check_date" class="order-sort"> </span></th>
                <th width="80">到期日期<span order="a.end_date" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.num}</td>
                    <td>{$v.name}</td>
                    <td>{$v.fee?:'--'}</td>
                    <td>{$v.check_date}</td>
                    <td>{$v.end_date}</td>
                    <td>
                        {if condition="checkPath('check/checkEdit',['id'=>$v['id']])"}
                        <a  href="{:url('check/checkEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('check/checkDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('check/checkDelete',['id'=>$v['id']])}">删除</a>
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