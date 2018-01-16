<ul class="nav nav-tabs">
    {if condition="checkPath('order/index')"}
    <li><a href="{:Url('order/index')}">订单管理</a></li>
    {/if}
    {if condition="checkPath('order/orderAdd')"}
    <li><a href="{:Url('order/orderAdd')}">添加订单</a></li>
    {/if}
    {if condition="checkPath('order/selectAnyBus')"}
    <li class="active"><a href="{:Url('order/selectAnyBus',['id'=>$order.id])}">分批配载</a></li>
    {/if}
    {if condition="checkPath('bus/bus/busAdd')"}
    <li><a href="{:Url('bus/bus/busAdd',['style'=>'order_any','order_id'=>$order.id])}">添加车辆</a></li>
    {/if}
</ul>
 <div style="margin-bottom:70px;">
        <div class="cf well form-search row">
            <form  method="get">
                <div class="fl">
                    <div class="btn-group">
                        <input name="num" class="form-control" value="{:input('num')}"  placeholder="车牌号码" type="text">
                        <input name="id" class="form-control" value="{:input('id')}"  placeholder="车牌号码" type="hidden">
                    </div>
                    <div class="btn-group">
                        <input name="color" class="form-control" value="{:input('color')}"  placeholder="车身颜色" type="text">
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
                        <select name="corporation_id" class="form-control" lay-verify="">
                            <option value="">车辆归属</option>
                            {foreach $corporation as $v}
                            <option value="{$v.id}" {if input('corporation_id') == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="btn-group layui-form">
                        <select name="department_id" class="form-control" lay-verify="">
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
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered table-list" id="menus-table">
            <thead>
            <tr>
                <th width="50"></th>
                <th width="80">车牌号码</th>
                <th width="80">主驾驶</th>
                <th width="60">副驾驶</th>
                <th width="60">类型</th>
                <th width="60">座位</th>
                <th width="60">车辆归属</th>
                <th width="60">所属部门</th>
                <th width="60">颜色</th>
                <th width="150">车载设备</th>
            </tr>
            </thead>
            <tbody>
            {foreach $list as $v}
                <tr class="select-tr">
                    <td class="layui-form text-center"><input type="checkbox" class="select-item" value="{$v.id}" lay-skin="primary"></td>
                    <td><span class="span-primary bus-detail" data-id="{$v.id}">{$v.num}</span></td>
                    <td><span class="span-primary select-fir fl" data-id="{$v.fir_user_id}">{$v.fir_name?:'选择主驾驶员'}</span></td>
                    <td><span class="span-primary select-sec fl" data-id="{$v.sec_user_id}">{$v.sec_name?:'选择副驾驶员'}</span></td>
                    <td>{if $v.type == 1}自有车{elseif $v.type == 2}加盟车{else}外请车{/if}</td>
                    <td >
                        {$v.site_num}
                    </td>
                    <td>{$v.corporation_name}</td>
                    <td>{$v.department_name}</td>
                    <td>{$v.color}</td>
                    <td>
                        {if $v.is_air}空凋 {/if} {if $v.is_tv}电视 {/if} {if $v.is_microphone}麦克风 {/if} {if $v.is_bathroom}卫生间{/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="text-center" style="position:fixed;bottom:0;height:60px;rgba(255,255,255,0.5);line-height:60px;width:100%;border-top:1px solid #ccc;"><button type="button" class="btn btn-success select-bus" data-url="{:url('order/selectAnyBus',['id'=>$order.id])}">确认派单</button></div>
<script>
    $(function(){
        //确认派单
        $('.select-bus').click(function(){
            if($("#menus-table .select-item:checked").length == 0) alertDanger('请选择车辆');
            var subList = [];
            $("#menus-table .select-item:checked").each(function(){
                var _this = $(this);
                var _parent = _this.parents(".select-tr")
                subList.push({bus_id:_this.val(),fir_user_id:_parent.find(".select-fir").attr("data-id"),sec_user_id:_parent.find(".select-sec").attr("data-id")})
            });
            var _this = $(this);
            var url = _this.attr('data-url');
            layer.confirm("确定派单吗？", {
                btn: ['确定','取消'], //按钮
                icon:7
            }, function(index){
                layer.close(index);
                spanPost(_this,url,{'data':JSON.stringify(subList)});
            }, function(index){
                layer.close(index);
            });
        });

        //查看详情
        $('.bus-detail').mouseover(function(){
            var id = $(this).attr("data-id");
            openLayer = layer.open({
                type: 2,
                title: '车辆详情',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('bus/bus/busInfo','','')}/id/"+id,
            })
        }).mouseout(function(){
            layer.close(openLayer)
        });

        //选择主驾驶
        $('.select-fir').click(function(){
            var id = $(this).attr("data-id");
            $(this).parents("table").find('.now-active').removeClass("now-active");
            $(this).parents("tr").addClass("now-active");
            layer.open({
                type: 2,
                title: '选择主驾驶员',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('order/userSelect','','')}/fir/1/id/"+id,
            })
        });

        //选择副驾驶
        $('.select-sec').click(function(){
            var id = $(this).attr("data-id");
            $(this).parents("table").find('.now-active').removeClass("now-active");
            $(this).parents("tr").addClass("now-active");
            layer.open({
                type: 2,
                title: '选择副驾驶员',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('order/userSelect','','')}/fir/2/id/"+id,
            })
        });
    })
</script>