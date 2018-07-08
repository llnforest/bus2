
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>租车客户</th>
                <td class="layui-form">
                    <div class="layui-form select">
                        <select name="customer_id" class="form-control" lay-search>
                            <option value="">请输入客户名称或姓名或手机号</option>
                            {foreach $customerList as $v}
                            <option value="{$v.id}" {$info.customer_id == $v.id?'selected':''}>{$v.name}/{$v.user_name}/{$v.phone}</option>
                            {/foreach}
                        </select>
                    </div>
                    <span class="form-required">*</span>
                    {if !isset($info.id)}<a href="{:url('customer/customer/customerAdd',['skip_type'=>'order'])}" style="line-height:34px;margin-left:20px;">添加客户</a>{/if}
                </td>
            </tr>
            <tr>
                <th>订单类型</th>
                <td class="layui-form" id="order_type">
                    {if isset($info.status) && $info.status != 0}
                    <input type="radio" name="order_type" value="{$info.order_type}" title="{if $info.order_type == 1}旅行社用车{elseif $info.order_type==2}交通车{elseif $info.order_type == 3}团车{elseif $info.order_type == 4}社会用车{elseif $info.order_type == 5}同行{elseif $info.order_type == 6}昌顺员工{/if}" checked>
                    {else}
                    <input type="radio" name="order_type" value="1" title="旅行社用车" {if !isset($info.order_type) ||$info.order_type == 1}checked{/if}>
                    <input type="radio" name="order_type" value="4" title="社会用车" {$info.order_type == 4?'checked':''}>
                    <input type="radio" name="order_type" value="2" title="交通车" {$info.order_type == 2?'checked':''}>
                    <input type="radio" name="order_type" value="3" title="团车" {$info.order_type == 3?'checked':''}>
                    <input type="radio" name="order_type" value="5" title="同行" {$info.order_type == 5?'checked':''}>
                    <input type="radio" name="order_type" value="6" title="昌顺员工" {$info.order_type == 6?'checked':''}>
                    {/if}
                </td>
            </tr>
            <tr>
                <th>包车类型</th>
                <td class="layui-form">
                    <div class="layui-form select">
                        <select name="type" class="form-control" lay-verify="">
                            <option value="1" {if empty($info) || $info.type == 1}selected{/if}>全包</option>
                            <option value="2" {$info.type == 2?'selected':''}>净价</option>
                            <option value="3" {$info.type == 3?'selected':''}>赞助</option>
                        </select>
                    </div>
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr class="tuanche jiaotong" {if isset($info.order_type) && in_array($info.order_type,[2,3])}style="display:none"{/if}>
                <th>合同金额</th>
                <td>
                    {if isset($info) && $info.status != 0}
                    {$info.total_money}
                    {else}
                    <input class="form-control text" type="text" name="total_money" value="{$info.total_money??''}"  placeholder="合同金额">
                    <span class="form-required">*</span>
                    {/if}
                </td>
            </tr>
            <tr>
                <th>现收金额</th>
                <td>
                    <input class="form-control text" type="text" name="xianshou" value="{$info.xianshou??''}" placeholder="现收金额">
                </td>
            </tr>
            <tr>
                <th>队收金额</th>
                <td>
                    <input class="form-control text" type="text" name="duishou" value="{$info.duishou??''}" placeholder="队收金额">
                </td>
            </tr>
            <tr>
                <th>队收方式</th>
                <td>
                    <div class="layui-form select">
                        <select name="duishou_type" class="form-control">
                            <option value="0">未选择</option>
                            <option value="1" {$info.type == 1?'selected':''}>支付宝</option>
                            <option value="2" {$info.type == 2?'selected':''}>微信</option>
                            <option value="3" {$info.type == 3?'selected':''}>现金</option>
                            <option value="4" {$info.type == 4?'selected':''}>工行卡</option>
                            <option value="5" {$info.type == 5?'selected':''}>徽行卡</option>
                            <option value="6" {$info.type == 6?'selected':''}>昌顺对公收</option>
                            <option value="7" {$info.type == 7?'selected':''}>伟宏对公</option>
                            <option value="8" {$info.type == 8?'selected':''}>招行卡</option>
                            <option value="9" {$info.type == 9?'selected':''}>光大卡</option>
                            <option value="10" {$info.type == 10?'selected':''}>农行卡</option>
                            <option value="11" {$info.type == 11?'selected':''}>其他卡</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr class="fanli">
                <th>返利金额</th>
                <td>
                    <input class="form-control text" type="text" name="return_money" value="{$info.return_money??''}" placeholder="返利金额">
                </td>
            </tr>
            <tr class="true_money">
                <th>付款金额</th>
                <td>
                    <input class="form-control text" type="text" name="true_money" value="{$info.true_money??''}" placeholder="付款金额">
                </td>
            </tr>
            <tr class="true_money">
                <th>税款</th>
                <td>
                    <input class="form-control text" type="text" name="taxation" value="{$info.taxation??''}" placeholder="税款">
                </td>
            </tr>
            <tr>
                <th>出发时间</th>
                <td>
                    {if isset($info) && $info.status != 0}
                    {$info.start_date?date_format(date_create($info.start_date),'Y-m-d H:i'):''}
                    {else}
                    <input name="start_date" value="{$info.start_date?date_format(date_create($info.start_date),'Y-m-d H:i'):''}"  readonly dom-format="yyyy-MM-dd HH:mm" dom-type="datetime"  dom-class="start-date" class="date-time start-date form-control laydate-icon text"  type="text" placeholder="请选择出发时间">
                    <span class="form-required">*</span>
                    {/if}
                </td>
            </tr>
            <tr>
                <th>结束时间</th>
                <td>
                    {if isset($info) && $info.status != 0}
                    {$info.end_date?date_format(date_create($info.end_date),'Y-m-d H:i'):''}
                    {else}
                    <input name="end_date" value="{$info.end_date?date_format(date_create($info.end_date),'Y-m-d H:i'):''}"  readonly dom-format="yyyy-MM-dd HH:mm" dom-type="datetime" dom-class="end-date" class="date-time end-date form-control laydate-icon text"  type="text" placeholder="请选择结束时间">
                    <span class="form-required">*</span>
                    {/if}
                </td>
            </tr>
            <tr class="jiaotong tuanche" {if isset($info.order_type) && in_array($info.order_type,[2,3])}style="display:none"{/if}>
                <th>乘坐人数</th>
                {if isset($info) && $info.status != 0}
                <td>{$info.num}人</td>
                {else}
                <td>
                    <input class="form-control text" type="text" name="num" value="{$info.num??''}" placeholder="乘坐人数">
                    <span class="form-required">*</span>
                </td>
                {/if}
            </tr>
            <tr>
                <th>租车要求</th>
                <td class="layui-form">
                    {if isset($info) && $info.status != 0}
                        {if $info.is_air == 1}<span style="margin-right:10px;">空凋</span>{/if}
                        {if $info.is_tv == 1}<span style="margin-right:10px;">电视</span>{/if}
                        {if $info.is_microphone == 1}<span style="margin-right:10px;">麦克风</span>{/if}
                        {if $info.is_bathroom == 1}<span>卫生间</span>{/if}
                    {else}
                    <input type="checkbox" name="is_air" value="1" title="空调" {if !isset($info.is_air) ||$info.is_air == 1}checked{/if}>
                    <input type="checkbox" name="is_tv" value="1" title="电视" {if !isset($info.is_tv) ||$info.is_tv == 1}checked{/if}>
                    <input type="checkbox" name="is_microphone" value="1" title="麦克风" {$info.is_microphone == 1?'checked':''}>
                    <input type="checkbox" name="is_bathroom" value="1" title="卫生间" {$info.is_bathroom == 1?'checked':''}>
                    {/if}
                </td>
            </tr>
            <tr>
                <th>起始地点</th>
                <td>
                    {if isset($info) && $info.status != 0}
                        {$info.start_prov}{$info.start_city}{$info.start_area}{$info.start_address}
                    {else}
<!--                    <div class="layui-form address-area" data-prov="start_prov" data-city="start_city" data-area="start_area" data-provid="{$info.start_provid??''}" data-cityid="{$info.start_cityid??''}" data-areaid="{$info.start_areaid??''}">-->
<!--                        <div class="layui-form-item">-->
<!--                            <div class="layui-input-inline">-->
<!--                                <select name="start_prov" id="start_prov" lay-filter="start_prov">-->
<!--                                </select>-->
<!--                            </div>-->
<!--                            <div class="layui-input-inline">-->
<!--                                <select name="start_city" id="start_city" lay-filter="start_city">-->
<!--                                </select>-->
<!--                            </div>-->
<!--                            <div class="layui-input-inline">-->
<!--                                <select name="start_area" id="start_area" lay-filter="start_area">-->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <input class="form-control text" type="text" name="start_address" value="{$info.start_address??''}" placeholder="起始详细地址">
                    {/if}
                </td>
            </tr>
            <tr>
                <th>到达地点</th>
                <td>
                    {if isset($info) && $info.status != 0}
                    {$info.end_prov}{$info.end_city}{$info.end_area}{$info.end_address}
                    {else}
<!--                    <div class="layui-form address-area" data-prov="end_prov" data-city="end_city" data-area="end_area" data-provid="{$info.end_provid??''}" data-cityid="{$info.end_cityid??''}" data-areaid="{$info.end_areaid??''}">-->
<!--                        <div class="layui-form-item">-->
<!--                            <div class="layui-input-inline">-->
<!--                                <select name="end_prov" id="end_prov" lay-filter="end_prov">-->
<!--                                </select>-->
<!--                            </div>-->
<!--                            <div class="layui-input-inline">-->
<!--                                <select name="end_city" id="end_city" lay-filter="end_city">-->
<!--                                </select>-->
<!--                            </div>-->
<!--                            <div class="layui-input-inline">-->
<!--                                <select name="end_area" id="end_area" lay-filter="end_area">-->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <input class="form-control text" type="text" name="end_address" value="{$info.end_address??''}" placeholder="到达详细地址">
                    {/if}
                </td>
            </tr>
            <tr>
                <th>订单备注</th>
                <td>
                    <textarea name="remark" class="form-control text" placeholder="订单备注">{$info.remark??''}</textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="button" class="btn btn-success form-post" {if isset($info) && $info.status == 2}post-msg="确认保存后，订单将不能再次修改"{/if}>保存</button>
                    <a class="btn btn-default active" href="JavaScript:history.go(-1)">返回</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script src="__PublicAdmin__/js/plugins/jquery.autocompleter.js?001"></script>
<script>
    $(function(){
        var data = [{0,1,2}];
        $('#nope1').autocompleter({
            // marker for autocomplete matches
            highlightMatches: true,
            // object to local or url to remote search
            source: data,
            // custom template
            template: '{{ id }}{{name}}',
            // show hint
            hint: true,
            // abort source if empty field
            empty: false,
            // max results
            limit: 10,

            callback: function (value, index, selected) {
                if (selected) {
                    $('#customer_id').val(selected.id);
                }
            }
        });

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
        $("#order_type").on("click",".layui-form-radio",function(){
            var id = $(this).prev().val();
            if(id == 1){
                $(".jiaotong,.tuanche").show();
            }else if(id == 2){
                $(".tuanche").show();
                $(".jiaotong").hide();
            }else if(id == 3){
                $(".jiaotong").show();
                $(".tuanche").hide();
            }
        })
    })
</script>
