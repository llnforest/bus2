
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>选择车牌号</th>
                <td>
                    <span class="span-primary select-bus fl">{$info.num?:'选择车牌号'}</span>
                    <input id="bus_id" class="form-control" type="hidden" name="bus_id" value="{$info.bus_id??''}">
                </td>
            </tr>
            <tr>
                <th>选择维保点</th>
                <td>
                    <span class="span-primary select-contact">{if !empty($info.name) && $info.name != ''}{$info.name}{else}选择维修保养点{/if}</span>
                    <input id="contact_id" class="form-control text" type="hidden" name="contact_id" value="{$info.contact_id??''}">
                </td>
            </tr>
            <tr>
                <th>维保日期</th>
                <td>
                    <input name="protect_date" value="{$info.protect_date??''}"  readonly dom-class="check-date" class="date-time check-date form-control laydate-icon text"  type="text" placeholder="选择维保日期">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>维保备注</th>
                <td>
                    <textarea name="remark" class="form-control text" placeholder="维保备注">{$info.remark??''}</textarea>
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
        //选择车牌号
        $('.select-bus').click(function(){
            var id = $("#bus_id").val();
            layer.open({
                type: 2,
                title: '车牌号选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('protect/busSelect','','')}/id/"+id,
            })
        });
        //选择维保点
        $('.select-contact').click(function(){
            var id = $("#contact_id").val();
            layer.open({
                type: 2,
                title: '选择维修保养点',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('protect/contactSelect','','')}/id/"+id,
            })
        });
    })
</script>
