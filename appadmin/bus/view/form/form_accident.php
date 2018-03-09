
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>选择车牌号</th>
                <td>
                    <span class="span-primary select-bus">{$info.num??'选择车牌号'}</span>
                    <input id="bus_id" class="form-control text" type="hidden" name="bus_id" value="{$info.bus_id??''}">
                </td>
            </tr>
            <tr>
                <th>选择驾驶员</th>
                <td>
                    <span class="span-primary select-user">{$info.name??'选择驾驶员'}</span>
                    <input id="user_id" class="form-control text" type="hidden" name="user_id" value="{$info.user_id??''}">
                </td>
            </tr>
            <tr>
                <th>事发日期</th>
                <td>
                    <input name="accident_date" value="{$info.accident_date??''}"  readonly dom-class="accident-date" class="date-time accident-date form-control laydate-icon text"  type="text" placeholder="选择事发日期">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>选择维修点</th>
                <td>
                    <span class="span-primary select-repair">{if !empty($info.repair_name) && $info.repair_name != ''}{$info.repair_name}{else}选择维修点{/if}</span>
                    <input id="repair_id" class="form-control text" type="hidden" name="repair_id" value="{$info.repair_id??''}">
                </td>
            </tr>
            <tr class="hidden">
                <th>损失金额</th>
                <td>
                    <input class="form-control text" type="text" name="lose" value="{$info.lose??''}" placeholder="损失金额">
                </td>
            </tr>
            <tr>
                <th>保险公司</th>
                <td>
                    <div class="layui-form select">
                        <select name="contact_id" class="form-control" lay-verify="">
                            <option value="0">选择保险公司</option>
                            {foreach $contact as $v}
                            <option value="{$v.id}" {if !empty($info) && $info.contact_id == $v.id}selected{/if}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                </td>
            </tr>
            <tr class="hidden">
                <th>保险理赔</th>
                <td>
                    <input class="form-control text" type="text" name="insurance_money" value="{$info.insurance_money??''}" placeholder="保险金额">
                </td>
            </tr>
            <tr>
                <th>事故备注</th>
                <td>
                    <textarea name="remark" class="form-control text" placeholder="事故备注">{$info.remark??''}</textarea>
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
        //选择驾驶员
        $('.select-user').click(function(){
            var id = $("#user_id").val();
            layer.open({
                type: 2,
                title: '驾驶员选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('accident/userSelect','','')}/id/"+id,
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
                content: "{:url('accident/busSelect','','')}/id/"+id,
            })
        });
        //选择维修点
        $('.select-repair').click(function(){
            var id = $("#repair_id").val();
            layer.open({
                type: 2,
                title: '维修点选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('accident/contactSelect','','')}/id/"+id,
            })
        });

    })
</script>
