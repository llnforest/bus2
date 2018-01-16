<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>油卡名称</th>
                <td>
                    {$info.name}
                    <input class="form-control text" type="hidden" name="oil_id" value="{$info.oil_id}">
                </td>
            </tr>
            <tr>
                <th>加油车辆</th>
                <td>
                    <span class="span-primary select-bus fl">{$info.bus_num?:'选择车辆'}</span>
                    <input id="bus_id" class="form-control" type="hidden" name="bus_id" value="{$info.bus_id??''}">
                </td>
            </tr>
            <tr>
                <th>选择加油站</th>
                <td>
                    <span class="span-primary select-contact">{if !empty($info.contact_name) && $info.contact_name != ''}{$info.contact_name}{else}选择加油站{/if}</span>
                    <input id="contact_id" class="form-control text" type="hidden" name="contact_id" value="{$info.contact_id??''}">
                </td>
            </tr>
            <tr>
                <th>加油金额</th>
                <td>
                    <input class="form-control text" type="text" name="fee" value="{$info.fee??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>加油日期</th>
                <td>
                    <input name="out_date" value="{$info.out_date??''}"  readonly dom-class="out-date" class="date-time out-date form-control laydate-icon text"  type="text">
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
        $('.select-contact').click(function(){
            var id = $("#contact_id").val();
            layer.open({
                type: 2,
                title: '选择加油站',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('oil/contactSelect','','')}/id/"+id,
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
                content: "{:url('oil/busSelect','','')}/id/"+id,
            })
        });
    })
</script>
