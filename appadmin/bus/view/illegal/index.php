<ul class="nav nav-tabs">
    {if condition="checkPath('illegal/index')"}
    <li class="active"><a href="{:Url('illegal/index')}">违章列表</a></li>
    {/if}
    {if condition="checkPath('illegal/illegalAdd')"}
    <li><a href="{:Url('illegal/illegalAdd')}">添加违章</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" value="{:input('num')}" placeholder="车牌号" class="form-control"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="num" value="{:input('name')}" placeholder="驾驶员" class="form-control"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="start" value="{:input('start')}" placeholder="违章起始日期" dom-class="date-start" class="date-time date-start form-control laydate-icon"  type="text">
                    </div>
                    <div class="btn-group">
                        <input name="end" value="{:input('end')}" placeholder="违章结束日期" dom-class="date-end" class="date-time date-end form-control laydate-icon"  type="text">
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
                <th width="80">驾驶员</th>
                <th width="80">罚款</th>
                <th width="60">扣分</th>
                <th width="60">备注</th>
                <th width="130">违章日期<span order="a.illegal_date" class="order-sort"> </span></th>
                <th width="130">创建时间<span order="a.create_time" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.num}</td>
                    <td>{$v.name}</td>
                    <td>{$v.money?:'--'}</td>
                    <td>{$v.score}</td>
                    <td>{if $v.remark}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                            data-content="{$v.remark}">明细</span>{/if}</td>
                    <td>{$v.illegal_date}</td>
                    <td>{$v.create_time}</td>
                    <td>
                        {if condition="checkPath('illegal/illegalEdit',['id'=>$v['id']])"}
                        <a  href="{:url('illegal/illegalEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('illegal/illegalDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('illegal/illegalDelete',['id'=>$v['id']])}">删除</a>
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