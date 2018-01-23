{__NOLAYOUT__}
{include file="publics:topCss"}
<div class="container-fluid"  style="padding-top:12px;padding-bottom:12px;">
    <div id="alert"></div>
    <table class="table table-bordered">
           <tbody class="layui-form">
                <tr>
                    <td class="bg-gray">车牌号码</td>
                    <td>{$info.num}</td>
                    <td class="bg-gray">发动机号</td>
                    <td>{$info.engine_code}</td>
                </tr>
                <tr>
                    <td class="bg-gray">主驾驶员</td>
                    <td>{$info.fir_name}</td>
                    <td class="bg-gray">副驾驶员</td>
                    <td>{$info.sec_name}</td>
                </tr>
                <tr>
                    <td class="bg-gray">入驻类型</td>
                    <td>{if $info.type == 1}自有车{elseif $info.type == 2}加盟车{else}外请车{/if}</td>
                    <td class="bg-gray">厂牌型号</td>
                    <td>{$info.brand}</td>
                </tr>
                <tr>
                    <td class="bg-gray">座位数量</td>
                    <td>{$info.site_num}</td>
                    <td class="bg-gray">车身颜色</td>
                    <td>{$info.color}</td>
                </tr>
                <tr>
                    <td class="bg-gray">车辆归属</td>
                    <td>{$info.corporation_name}</td>
                    <td class="bg-gray">所属部门</td>
                    <td>{$info.department_name}</td>
                </tr>
                <tr>
                    <td class="bg-gray">合作伙伴</td>
                    <td>{$user_name}</td>
                    <td class="bg-gray">使用年限</td>
                    <td>{$info.buy_date|getYearNum}</td>
                </tr>
                <tr>
                    <td class="bg-gray">购买日期</td>
                    <td>{$info.buy_date}</td>
                    <td class="bg-gray">入驻日期</td>
                    <td>{$info.home_date}</td>
                </tr> <tr>
                    <td class="bg-gray">营运证号</td>
                    <td>{$info.business_code}</td>
                    <td class="bg-gray">行驶证号</td>
                    <td>{$info.drive_code}</td>
                </tr> <tr>
                    <td class="bg-gray">配备设备</td>
                    <td>{if $info.is_air}空凋{/if} {if $info.is_tv}电视{/if} {if $info.is_microphone}麦克风{/if} {if $info.is_bathroom}卫生间{/if}</td>
                    <td class="bg-gray">车辆状态</td>
                    <td>{if $info.status == 1}<span class="blue">正常</span>{elseif $info.type == 2}维修{elseif $info.type == 3}报废{else}<span class="red">停用</span>{/if}</td>
                </tr>
            </tbody>
        </table>
</div>
{include file="publics:bottomJs"}
<style>
    table{
        border:none !important;
    }
    .bg-gray{
        background-color:#f8f8f8;
        width:80px;
    }
</style>