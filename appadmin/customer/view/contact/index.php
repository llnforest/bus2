<ul class="nav nav-tabs">
    {if condition="checkPath('contact/index')"}
    <li class="active"><a href="{:Url('contact/index')}">往来单位</a></li>
    {/if}
    {if condition="checkPath('contact/contactAdd')"}
    <li><a href="{:Url('contact/contactAdd')}">添加单位</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group layui-form">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="">单位类型</option>
                            <option value="1" {if input('type') == 1}selected{/if}>4S店</option>
                            <option value="2" {if input('type') == 2}selected{/if}>油气站</option>
                            <option value="3" {if input('type') == 3}selected{/if}>车管所</option>
                            <option value="4" {if input('type') == 4}selected{/if}>保险公司</option>
                            <option value="5" {if input('type') == 5}selected{/if}>维修店</option>
                            <option value="6" {if input('type') == 6}selected{/if}>检测站</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="单位名称" type="text">
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
                <th width="80">单位名称</th>
                <th width="80">联系人员</th>
                <th width="80">联系电话</th>
                <th width="60">单位类型</th>
                <th width="60">单位地址</th>
                <th width="60">状态</th>
                <th width="130">创建时间<span order="create_time" class="order-sort"> </span></th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td>{$v.name}</td>
                    <td>{$v.contact}</td>
                    <td>{$v.phone}</td>
                    <td>{if $v.type == 1}4S店{elseif $v.type == 2}油气站{elseif $v.type == 3}车管所{elseif $v.type == 4}保险公司{elseif $v.type == 5}维修店{elseif $v.type == 6}检测站{/if}</td>
                    <td>{if $v.address}<span class="span-primary" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top"
                                            data-content="{$v.address}">明细</span>{/if}</td>
                    <td  class="layui-form">
                        {if condition="checkPath('contact/editStatus')"}
                        <input type="checkbox" data-name="status" data-url="{:url('contact/editStatus',['id'=>$v.id])}" lay-skin="switch" lay-text="开启|禁用" {$v.status == 1 ?'checked':''} data-value="1|0">
                        {else}
                        {$v.status == 1?'<span class="blue">√</span>':'<span class="red">╳</span>'}
                        {/if}
                    </td>
                    <td>{$v.create_time}</td>
                    <td>
                        {if condition="checkPath('contact/contactEdit',['id'=>$v['id']])"}
                        <a  href="{:url('contact/contactEdit',['id'=>$v['id']])}">编辑</a>
                        {/if}
                        {if condition="checkPath('contact/contactDelete',['id'=>$v['id']])"}
                            <a  class="span-post" post-msg="确定要删除吗" post-url="{:url('contact/contactDelete',['id'=>$v['id']])}">删除</a>
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