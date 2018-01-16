<ul class="nav nav-tabs">
    {if condition="checkPath('order/index')"}
    <li><a href="{:Url('order/index')}">订单管理</a></li>
    {/if}
    {if condition="checkPath('order/orderFollow')"}
    <li class="active"><a href="{:url('order/orderFollow',['id'=>$info.id])}">跟单备注</a></li>
    {/if}
    
</ul>
{if condition="checkPath('order/followAdd')"}
<form  class="form-horizontal" action="{:url('order/followAdd',['id'=>$info.id])}" method="post">
    <div class="col-sm-12">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th class="text-center">
                        订单编号：{$info.id}
                    </th>
                </tr>
                <tr>
                    <td>
                        <textarea name="remarks" class="form-control" placeholder="请填写备注内容" rows="3" style="width:100%;resize:none;font-size:14px;line-height:28px;padding:5px"></textarea>
                    </td>
                </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="button" class="btn btn-success form-post" >添加备注</button>
                    <a class="btn btn-default active" href="JavaScript:history.go(-1)">返回</a>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</form>
{/if}
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>备注内容</th>
                <th width="100">备注人</th>
                <th width="150">备注时间</th>
                <th width="60">操作</th>
            </tr>
        {if count($list) == 0}
            <tr>
                <td colspan="4" class="text-center">暂无备注</td>
            </tr>
        {else}
        {foreach $list as $item}
            <tr>
                <td>{$item.remarks}</td>
                <td>{$item.nick_name}</td>
                <td>{$item.create_time}</td>
                {if condition="checkPath('order/followDelete')"}
                <td><span class="span-post" post-msg="你确定要删除吗" post-url="{:url('order/followDelete',['id'=>$item.id,'order_id' => $item.order_id])}">删除</span></td>
                {/if}
            </tr>
        {/foreach}
        {/if}
        </tbody>
    </table>
</div>
