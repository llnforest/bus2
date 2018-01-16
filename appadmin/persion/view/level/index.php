<ul class="nav nav-tabs">
    {if condition="checkPath('level/index')"}
    <li class="active"><a href="{:Url('level/index')}">岗位列表</a></li>
    {/if}
    {if condition="checkPath('level/levelAdd')"}
    <li><a href="{:Url('level/levelAdd')}">添加岗位</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="岗位名称" type="text">
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
                <th>岗位名称</th>
                <th width="80">排序</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{if condition="checkPath('level/orderSort',['id'=>$v['id']])"}
                        <input class="form-control change-data"  post-id="{$v.id}" post-url="{:url('level/orderSort')}" value="{$v.sort}">
                        {else}
                        {$v.sort}
                        {/if}
                    </td>
                    <td>
                        {if condition="checkPath('level/levelEdit',['id'=>$v['id']])"}
                        <a  href="{:url('level/levelEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('level/levelDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('level/levelDelete',['id'=>$v['id']])}">删除</a>
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