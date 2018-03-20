
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>车牌号码</th>
                <td>
                    <input class="form-control text" type="text" name="num" value="{$info.num??''}" placeholder="车牌号码">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>厂牌型号</th>
                <td>
                    <input class="form-control text" type="text" name="brand" value="{$info.brand??''}" placeholder="厂牌型号">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>座位数量</th>
                <td>
                    <input class="form-control text" type="text" name="site_num" value="{$info.site_num??''}" placeholder="座位数量">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>主驾驶员</th>
                <td>
                    <input class="form-control text click-show" type="text" data-url="{:url("persion/user/busUserList")}" value="{$info.fir_name??''}" placeholder="请输入想要查找的主驾驶员" data-msg="主驾驶员">
                    <input class="form-control text click-id" type="hidden" name="fir_user_id" value="{$info.fir_user_id??''}">
                    <ul class="list-group click-show-wrap text">
                    </ul>
                    <span class="form-required">*</span>
                    {if condition="checkPath('persion/user/userAdd')"}
                    <a href="{:url('persion/user/userAdd',['skip_type'=>'bus'])}" style="line-height:34px;margin-left:20px;">添加驾驶员</a>
                    {/if}
                </td>
            </tr>
            <tr>
                <th>副驾驶员</th>
                <td>
                    <input class="form-control text click-show" type="text" data-url="{:url("persion/user/busUserList")}" value="{$info.sec_name??''}" placeholder="请输入想要查找的副驾驶员" data-msg="副驾驶员">
                    <input class="form-control text click-id" type="hidden" name="sec_user_id" value="{$info.sec_user_id??''}">
                    <ul class="list-group click-show-wrap text">
                    </ul>
                </td>
            </tr>
            <tr>
                <th>股东人员</th>
                <td>
                    <div class="partner-wrap">
                        <div class="partner-area">
                            {if isset($partnerList)}
                            {foreach $partnerList as $item}
                            <div class="partner-list clear-float">
                                <input class="form-control text click-show" type="text" data-url="{:url("persion/user/busPartnerList")}" value="{$item.name??''}" placeholder="请输入想要查找的股东" data-msg="股东人员">
                                <input class="form-control text click-id" type="hidden" name="partner_id" value="{$item.user_id??''}">
                                <ul class="list-group click-show-wrap text">
                                </ul>
                                <input class="form-control partner-rate" placeholder="股份比例" value="{$item.rate}">
                                <button class="layui-btn layui-btn-primary layui-btn-sm partner-delete">
                                    <i class="layui-icon">&#xe640;</i>
                                </button>
                            </div>
                            {/foreach}
                            {/if}
                        </div>
                        <div class="partner-clone clear-float">
                            <input class="form-control text click-show" type="text" data-url="{:url("persion/user/busPartnerList")}" value="" placeholder="请输入想要查找的股东" data-msg="股东人员">
                            <input class="form-control text click-id" type="hidden" name="partner_id" value="">
                            <ul class="list-group click-show-wrap text">
                            </ul>
                            <input class="form-control partner-rate" placeholder="股份比例">
                            <button class="layui-btn layui-btn-primary layui-btn-sm partner-delete">
                                <i class="layui-icon">&#xe640;</i>
                            </button>
                        </div>
                        <div class="partner-btn">
                            <button class="layui-btn layui-btn-sm add-partner">
                                <i class="layui-icon">&#xe654;</i>添加
                            </button>
                        </div>
                    </div>
                    <input id="partner_data" class="form-control" type="hidden" name="partner_data" value="">
                </td>
            </tr>
            <tr>
                <th>入驻类型</th>
                <td class="layui-form">
                    <input type="radio" name="type" value="1" {if !isset($info.type) ||$info.type == 1}checked{/if} title="自有车">
                    <input type="radio" name="type" value="2" {$info.type == 2?'checked':''} title="加盟车">
                    <input type="radio" name="type" value="3" {$info.type == 3?'checked':''} title="外请车">
                </td>
            </tr>
            <tr>
                <th>车内设备</th>
                <td class="layui-form">
                    <input type="checkbox" name="is_air" value="1" {if !isset($info.is_air) ||$info.is_air == 1}checked{/if} title="空调">
                    <input type="checkbox" name="is_tv" value="1" {if !isset($info.is_tv) ||$info.is_tv == 1}checked{/if}  title="电视">
                    <input type="checkbox" name="is_microphone" value="1" {$info.is_microphone == 1?'checked':''}  title="麦克风">
                    <input type="checkbox" name="is_bathroom" value="1" {$info.is_bathroom == 1?'checked':''}  title="卫生间">
                </td>
            </tr>
            <tr>
                <th>车辆归属</th>
                <td>
                    <input class="form-control text click-show" type="text" data-url="{:url("bus/corporationList")}" value="{$info.corporation_name??''}" placeholder="请输入想要查找的车辆归属" data-msg="车辆归属">
                    <input class="form-control text click-id" type="hidden" name="corporation_id" value="{$info.corporation_id??''}">
                    <ul class="list-group click-show-wrap text">
                    </ul>
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>公司部门</th>
                <td>
                    <div class="layui-form select">
                        <select name="department_id" class="form-control text" lay-verify="">
                            <option value="0">选择车辆所属内部部门</option>
                            {foreach $department as $v}
                            <option value="{$v.id}" {$info.department_id == $v.id?'selected':''}>{$v.name}</option>
                            {/foreach}
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <th>车身颜色</th>
                <td>
                    <input class="form-control text" type="text" name="color" value="{$info.color??''}" placeholder="车身颜色">
                </td>
            </tr>
            <tr>
                <th>购买日期</th>
                <td>
                    <input name="buy_date" value="{$info.buy_date??''}"  readonly dom-class="check-date" class="date-time check-date form-control laydate-icon text"  type="text" placeholder="请选择购买日期">
                </td>
            </tr>
            <tr>
                <th>入户日期</th>
                <td>
                    <input name="home_date" value="{$info.home_date??''}"  readonly dom-class="home_date" class="date-time home_date form-control laydate-icon text"  type="text" placeholder="请选择入户日期">
                </td>
            </tr>
            <tr>
                <th>发动机号</th>
                <td>
                    <input class="form-control text" type="text" name="engine_code" value="{$info.engine_code??''}" placeholder="发动机号">
                </td>
            </tr>
            <tr>
                <th>行驶证号</th>
                <td>
                    <input class="form-control text" type="text" name="drive_code" value="{$info.drive_code??''}" placeholder="行驶证号">
                </td>
            </tr>
            <tr>
                <th>营运证号</th>
                <td>
                    <input class="form-control text" type="text" name="business_code" value="{$info.business_code??''}" placeholder="营运证号">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <input class="form-control text" type="hidden" name="style" value="{$style??''}">
                    <input class="form-control text" type="hidden" name="order_id" value="{$order_id??''}">
                    <button type="button" class="btn btn-success form-post " >保存</button>
                    <a class="btn btn-default active" href="JavaScript:history.go(-1)">返回</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<style>
    .partner-wrap .click-show{
        width:192px;
    }
    .partner-rate{
        width:100px;
        float:left;
        margin-left:8px;
    }
    .partner-btn{
        width:300px;
        text-align:center;
    }
    .partner-list{
        clear:both;
        margin-bottom:12px;
    }
    .partner-clone{
        display:none;
    }
    .partner-delete{
        margin-left:8px;
        margin-top:2px;
    }
</style>
<script>
    $(function(){
        //选择主驾驶
        $('.select-fir').click(function(){
            var id = $("#fir_id").val();
            layer.open({
                type: 2,
                title: '选择主驾驶员',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('bus/userSelect','','')}/fir/1/id/"+id,
            })
        });

        //选择副驾驶
        $('.select-sec').click(function(){
            var id = $("#sec_id").val();
            layer.open({
                type: 2,
                title: '选择副驾驶员',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('bus/userSelect','','')}/fir/2/id/"+id,
            })
        });

        //选择合伙人
        $('.select-bus-user').click(function(){
            var id = $("#bus_user_id").val();
            layer.open({
                type: 2,
                title: '选择股东',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('bus/busUserSelect','','')}/id/"+id,
            })
        });

        $(".add-partner").click(function(){
            var _clone = $(".partner-clone").clone(true,true).removeClass("partner-clone").addClass("partner-list");
            $(".partner-area").append(_clone);
            return false;
        })

        $(".partner-delete").click(function(){
            $(this).parents('.partner-list').remove();
        })

        $(".form-post").click(function(){
            var sublist = {};
           $(".partner-area .partner-list").each(function(index,item){
               var partner_id = $(item).find(".click-id").val();
               var rate = $(item).find(".partner-rate").val().trim();
               sublist[partner_id] = rate;
           })
            $("#partner_data").val(JSON.stringify(sublist));
        })
    })
</script>
