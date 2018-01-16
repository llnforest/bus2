<ul class="nav nav-tabs">
    {if condition="checkPath('protect/index')"}
    <li class="active"><a href="{:Url('protect/index')}">维修保养</a></li>
    {/if}
    {if condition="checkPath('protect/protectAdd')"}
    <li><a href="{:Url('protect/protectAdd')}">添加维保</a></li>
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
                            <option value="">维修保养点</option>
                            {foreach $contact as $v}
                            <option value="{$v.id}" {if input('contact_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="维保起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="维保截止日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="60">维修保养点</th>
                <th width="60">维保费用</th>
                <th width="50">备注</th>
                <th width="80">维保日期<span order="a.protect_date" class="order-sort"> </span></th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.num}</td>
                    <td>{$v.name}</td>
                    <td>{$v.fee?:'--'}</td>
                    <td>{if $v.remark}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                            data-content="{$v.remark}">明细</span>{/if}</td>
                    <td>{$v.protect_date}</td>
                    <td>
                        {if condition="checkPath('protect/protectEdit',['id'=>$v['id']])"}
                        <a  href="{:url('protect/protectEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('protect/protectDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('protect/protectDelete',['id'=>$v['id']])}">删除</a>
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