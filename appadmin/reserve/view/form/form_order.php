
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>租车客户</th>
                <td>
                    <span class="span-primary select-customer fl">{$info.fir_name?:'选择客户'}</span>
                    <a href="{:url('customer/customer/customerAdd',['skip_type'=>'order'])}" style="margin-left:20px;">添加客户</a>
                    <input id="customer_id" class="form-control" type="hidden" name="customer_id" value="{$info.customer_id??''}">
                </td>
            </tr>
            <tr>
                <th>订单类型</th>
                <td class="layui-form">
                    <input type="radio" name="order_type" value="1" title="普通单次" checked>
                    <input type="radio" name="order_type" value="2" title="常规班次">
                </td>
            </tr>
            <tr>
                <th>开始日期</th>
                <td>
                    <input name="start_date" value="{$info.start_date??''}"  readonly dom-class="start-date" class="date-time start-date form-control laydate-icon text"  type="text">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>结束日期</th>
                <td>
                    <input name="end_date" value="{$info.end_date??''}"  readonly dom-class="end-date" class="date-time end-date form-control laydate-icon text"  type="text">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>乘坐人数</th>
                <td>
                    <input class="form-control text" type="text" name="num" value="{$info.site_num??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>租车要求</th>
                <td class="layui-form">
                    <input type="checkbox" name="is_air" value="1" checked title="空调">
                    <input type="checkbox" name="is_tv" value="1" checked title="电视">
                    <input type="checkbox" name="is_microphone" value="1" title="麦克风">
                    <input type="checkbox" name="is_bathroom" value="1" title="卫生间">
                </td>
            </tr>
            <tr>
                <th>起始地点</th>
                <td>
                    <input class="form-control text" type="text" name="start_address" value="{$info.start_address??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>到达地点</th>
                <td>
                    <input class="form-control text" type="text" name="end_address" value="{$info.end_address??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>订单总额</th>
                <td>
                    <input class="form-control text" type="text" name="total_money" value="{$info.total_moeny??''}">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>结账类型</th>
                <td class="layui-form">
                    <input type="radio" name="type" value="1"  title="全包现收">
                    <input type="radio" name="type" value="2"  title="全包预收" checked>
                    <input type="radio" name="type" value="3"  title="全包记账">
                    <input type="radio" name="type" value="4"  title="净价现收">
                    <input type="radio" name="type" value="5"  title="净价预收">
                    <input type="radio" name="type" value="6"  title="净价记账">
                </td>
            </tr>
            <tr class="true_money">
                <th>下单支付</th>
                <td>
                    <input class="form-control text" type="text" name="true_money" value="{$info.true_money??''}">
                </td>
            </tr>
            <tr class="fanli" style="display:none;">
                <th>返利金额</th>
                <td>
                    <input class="form-control text" type="text" name="return_money" value="{$info.return_money??''}">
                </td>
            </tr>
            <tr>
                <th>订单备注</th>
                <td>
                    <textarea name="remark" class="form-control text"></textarea>
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
