<?php $name = $type == 1?'进货':'领用';?>
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>配件名称</th>
                <td>
                    {$info.name}
                    <input class="form-control text" type="hidden" name="machine_id" value="{$info.machine_id}">
                </td>
            </tr>
            {if $type == 1}
            <tr>
                <th>{$name}员工</th>
                <td>
                    <span class="span-primary select-user fl">{$info.user_name?:'选择员工'}</span>
                    <input id="user_id" class="form-control" type="hidden" name="user_id" value="{$info.user_id??''}">
                </td>
            </tr>
            {else}
            <tr>
                <th>{$name}车辆</th>
                <td>
                    <span class="span-primary select-bus fl">{$info.bus_num?:'选择车辆'}</span>
                    <input id="bus_id" class="form-control" type="hidden" name="bus_id" value="{$info.bus_id??''}">
                </td>
            </tr>
            {/if}
            <tr>
                <th>{$name}数量</th>
                <td>
                    <input class="form-control text" type="text" name="num" value="{$info.num??'1'}" placeholder="{$name}数量">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>{$name}日期</th>
                <td>
                    {if $type == 1}
                    <input name="in_date" value="{$info.in_date??''}"  readonly dom-class="in-date" class="date-time in-date form-control laydate-icon text"  type="text" placeholder="选择{$name}日期">
                    {else}
                    <input name="out_date" value="{$info.out_date??''}"  readonly dom-class="out-date" class="date-time out-date form-control laydate-icon text"  type="text" placeholder="选择{$name}日期">
                    {/if}
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="button" class="btn btn-success form-post " >保存</button>
                    <a class="btn btn-default active" href="JavaScript:history.go(-1)">返回</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $(function(){
        //选择员工
        $('.select-user').click(function(){
            var id = $("#user_id").val();
            layer.open({
                type: 2,
                title: '选择{$name}员工',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('machine/userSelect','','')}/id/"+id,
            })
        });

        //选择车牌号
        $('.select-bus').click(function(){
            var id = $("#bus_id").val();
            layer.open({
                type: 2,
                title: '车牌号选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('machine/busSelect','','')}/id/"+id,
            })
        });
    })
</script>
