<ul class="nav nav-tabs">
    {if condition="checkPath('bus/index')"}
    <li class="active"><a href="{:Url('bus/index')}">车辆列表</a></li>
    {/if}
    {if condition="checkPath('bus/busAdd')"}
    <li><a href="{:Url('bus/busAdd')}">添加车辆</a></li>
    {/if}
    {if condition="checkPath('bus/busList')"}
    <li><a href="{:Url('bus/busList')}">用车记录</a></li>
    {/if}
    {if condition="checkPath('bus/busUser')"}
    <li><a href="{:Url('bus/busUser')}">股份列表</a></li>
    {/if}
</ul>
 <div>
        <div class="cf well form-search row">

            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" class="form-control" value="{:input('num')}"  placeholder="车牌号码" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="engine_code" class="form-control" value="{:input('engine_code')}"  placeholder="发动机号" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="name" class="form-control" value="{:input('name')}"  placeholder="主驾驶员" type="text">
                    </div>
                    <div class="btn-group">
                        <input name="sec_name" class="form-control" value="{:input('sec_name')}"  placeholder="副驾驶员" type="text">
                    </div>
                    <div class="btn-group layui-form">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="">车辆类型</option>
                            <option value="1" {if input('type') == 1}selected{/if}>自有车</option>
                            <option value="2" {if input('type') == 2}selected{/if}>加盟车</option>
                            <option value="3" {if input('type') == 3}selected{/if}>外请车</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="status" class="form-control" lay-verify="">
                            <option value="">车辆状态</option>
                            <option value="1" {if input('status') == 1}selected{/if}>正常</option>
                            <option value="2" {if input('status') == 2}selected{/if}>维修</option>
                            <option value="3" {if input('status') == 3}selected{/if}>报废</option>
                            <option value="0" {if input('status') === '0'}selected{/if}>停用</option>
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="corporation_id" class="form-control">
                            <option value="">车辆归属</option>
                            {foreach $corporation as $v}
                            <option value="{$v.id}" {if input('corporation_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="department_id" class="form-control">
                            <option value="">所属部门</option>
                            {foreach $department as $v}
                            <option value="{$v.id}" {if input('department_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <input type="checkbox" name="is_air" value="1" {:input('is_air') == 1?'checked':''} title="空调">
                        <input type="checkbox" name="is_tv" value="1" {:input('is_tv') == 1?'checked':''}  title="电视">
                        <input type="checkbox" name="is_microphone" value="1" {:input('is_microphone') == 1?'checked':''}  title="麦克风">
                        <input type="checkbox" name="is_bathroom" value="1" {:input('is_bathroom') == 1?'checked':''}  title="卫生间">
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">查询</button>
                    </div>
                    {if condition="checkPath('bus/importBus')"}
                    <div class="btn-group">
                        <div class="btn btn-success import" lay-data="{'url': '{:url('bus/importBus')}',accept:'file'}">导入车辆</div>
                    </div>
                    {/if}
                    <div class="btn-group">
                        <a class="btn btn-default" href="__ImagePath__/download/template_bus.xlsx" download="车辆导入表模板.xlsx">下载模板</a>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="80">车牌号码</th>
                <th width="80">主驾驶</th>
                <th width="60">副驾驶</th>
                <th width="60">状态</th>
                <th width="60">类型</th>
                <th width="60">座位</th>
                <th width="60">车辆归属</th>
                <th width="60">所属部门</th>
                <th width="60">年限</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr>
                    <td><span class="span-primary bus-detail" data-id="{$v.id}">{$v.num}</span></td>
                    <td>{$v.fir_name}</td>
                    <td>{$v.sec_name}</td>
                    <td>{if $v.status == 1}<span class="blue">正常</span>{elseif $v.type == 2}维修{elseif $v.type == 3}报废{else}<span class="red">停用</span>{/if}</td>
                    <td>{if $v.type == 1}自有车{elseif $v.type == 2}加盟车{else}外请车{/if}</td>
                    <td >
                        {$v.site_num}
                    </td>
                    <td>{$v.corporation_name}</td>
                    <td>{$v.department_name}</td>
                    <td>{$v.buy_date|getYearNum}</td>
                    <td>
                        {if condition="checkPath('bus/busStatus',['id'=>$v['id']]) && $v.status != 3"}
                        <span class="span-primary edit-status" data-id="{$v.id}">更改状态</span>
                        {/if}
                        {if condition="checkPath('bus/busEdit',['id'=>$v['id']])"}
                        <a  href="{:url('bus/busEdit',['id'=>$v['id']])}">修改</a>
                        {/if}
<!--                        {if condition="checkPath('bus/busUse',['id'=>$v['id']])"}-->
<!--                        <a  href="{:url('bus/busUse',['id'=>$v['id']])}">用车</a>-->
<!--                        {/if}-->
                        {if condition="checkPath('bus/busList',['num'=>$v['num']])"}
                        <a  href="{:url('bus/busList',['num'=>$v['num']])}">用车记录</a>
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
//    查看详情
    $('.bus-detail').mouseover(function(){
        var id = $(this).attr("data-id");
        openLayer = layer.open({
            type: 2,
            title: '车辆详情',
            shadeClose: true,
            shade: false,
            area: ['400px', '420px'],
            content: "{:url('bus/busInfo','','')}/id/"+id,
        })
    }).mouseout(function(){
        layer.close(openLayer)
    });
    $('.edit-status').click(function(){
        var id = $(this).attr("data-id");
        openLayer = layer.open({
            type: 2,
            title: '选择所更改车辆状态',
            shadeClose: true,
            shade: [0.3, '#393D49'],
            area: ['400px', '110px'],
            content: "{:url('bus/busStatus','','')}/id/"+id,
        })
    })
</script>