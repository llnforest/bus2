
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>租车客户</th>
                <td>
                    <span class="span-primary select-customer fl">{$info.name?:'选择客户'}</span>
                    {if !isset($info.id)}<a href="{:url('customer/customer/customerAdd',['skip_type'=>'order'])}" style="margin-left:20px;">添加客户</a>{/if}
                    <input id="customer_id" class="form-control" type="hidden" name="customer_id" value="{$info.customer_id??''}">
                </td>
            </tr>
            <tr>
                <th>订单类型</th>
                <td class="layui-form">
                    <input type="radio" name="order_type" value="1" title="普通单次" {if !isset($info.order_type) ||$info.order_type == 1}checked{/if}>
                    <input type="radio" name="order_type" value="2" title="常规班次" {$info.order_type == 2?'checked':''}>
                </td>
            </tr>
            <tr>
                <th>出发时间</th>
                <td>
                    <input name="start_date" value="{$info.start_date?date_format(date_create($info.start_date),'Y-m-d H:i'):''}"  readonly dom-format="yyyy-MM-dd HH:mm" dom-type="datetime"  dom-class="start-date" class="date-time start-date form-control laydate-icon text"  type="text">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>结束时间</th>
                <td>
                    <input name="end_date" value="{$info.start_date?date_format(date_create($info.end_date),'Y-m-d H:i'):''}"  readonly dom-format="yyyy-MM-dd HH:mm" dom-type="datetime" dom-class="end-date" class="date-time end-date form-control laydate-icon text"  type="text">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>乘坐人数</th>
                <td>
                    <input class="form-control text" type="text" name="num" value="{$info.num??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>租车要求</th>
                <td class="layui-form">
                    <input type="checkbox" name="is_air" value="1" title="空调" {if !isset($info.is_air) ||$info.is_air == 1}checked{/if}>
                    <input type="checkbox" name="is_tv" value="1" title="电视" {if !isset($info.is_tv) ||$info.is_tv == 1}checked{/if}>
                    <input type="checkbox" name="is_microphone" value="1" title="麦克风" {$info.is_microphone == 1?'checked':''}>
                    <input type="checkbox" name="is_bathroom" value="1" title="卫生间" {$info.is_bathroom == 1?'checked':''}>
                </td>
            </tr>
            <tr>
                <th>起始地点</th>
                <td>
                    <div class="layui-form address-area" data-prov="start_prov" data-city="start_city" data-area="start_area" data-provid="{$info.start_provid??''}" data-cityid="{$info.start_cityid??''}" data-areaid="{$info.start_areaid??''}">
                        <div class="layui-form-item">
                            <div class="layui-input-inline">
                                <select name="start_prov" id="start_prov" lay-filter="start_prov">
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="start_city" id="start_city" lay-filter="start_city">
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="start_area" id="start_area" lay-filter="start_area">
                                </select>
                            </div>
                        </div>
                    </div>
                    <input class="form-control text" type="text" name="start_address" value="{$info.start_address??''}" placeholder="起始详细地址">
                </td>
            </tr>
            <tr>
                <th>到达地点</th>
                <td>
                    <div class="layui-form address-area" data-prov="end_prov" data-city="end_city" data-area="end_area" data-provid="{$info.end_provid??''}" data-cityid="{$info.end_cityid??''}" data-areaid="{$info.end_areaid??''}">
                        <div class="layui-form-item">
                            <div class="layui-input-inline">
                                <select name="end_prov" id="end_prov" lay-filter="end_prov">
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="end_city" id="end_city" lay-filter="end_city">
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="end_area" id="end_area" lay-filter="end_area">
                                </select>
                            </div>
                        </div>
                    </div>
                    <input class="form-control text" type="text" name="end_address" value="{$info.end_address??''}" placeholder="到达详细地址">
                </td>
            </tr>
            <tr>
                <th>订单总额</th>
                <td>
                    <input class="form-control text" type="text" name="total_money" value="{$info.total_money??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>结账类型</th>
                <td class="layui-form">
                    <input type="radio" name="type" value="1"  title="全包现收" {$info.type == 1?'checked':''}>
                    <input type="radio" name="type" value="2"  title="全包预收" {if !isset($info.type) || $info.type == 2}checked{/if}>
                    <input type="radio" name="type" value="3"  title="全包记账" {$info.type == 3?'checked':''}>
                    <input type="radio" name="type" value="4"  title="净价现收" {$info.type == 4?'checked':''}>
                    <input type="radio" name="type" value="5"  title="净价预收" {$info.type == 5?'checked':''}>
                    <input type="radio" name="type" value="6"  title="净价记账" {$info.type == 6?'checked':''}>
                </td>
            </tr>
            <tr class="true_money" style="{if isset($info.type) && in_array($info.type,[1,3,4,6])}display:none;{/if}">
                <th>下单支付</th>
                <td>
                    <input class="form-control text" type="text" name="true_money" value="{$info.true_money??''}">
                </td>
            </tr>
            <tr class="fanli" style="{if !isset($info.type) || $info.type != 1}display:none{/if}">
                <th>返利金额</th>
                <td>
                    <input class="form-control text" type="text" name="return_money" value="{$info.return_money??''}">
                </td>
            </tr>
            <tr>
                <th>订单备注</th>
                <td>
                    <textarea name="remark" class="form-control text">{$info.remark??''}</textarea>
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
        //选择主驾驶
        $('.select-customer').click(function(){
            var id = $("#customer_id").val();
            layer.open({
                type: 2,
                title: '选择客户',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('order/customerSelect','','')}/id/"+id,
            })
        });
        $("table").on("click",".layui-form-radio",function(){
            var id = $(this).prev().val();
            if(id == 1){
                $(".fanli").show();
            }else{
                $(".fanli").hide();
                $("input[name='return_money']").val('');
            }
            if(id == 1 || id == 4 || id == 3 || id == 6){
                $(".true_money").hide()
            }else{
                $(".true_money").show();
            }
        })

    })
</script>
