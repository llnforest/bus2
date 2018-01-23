{__NOLAYOUT__}
{include file="publics:topCss"}
<div class="container-fluid"  style="padding-top:12px;">
    <div id="alert"></div>
    <table class="table table-bordered">
           <tbody class="layui-form">
                <tr>
                    <td class="bg-gray">客户名称</td>
                    <td>{$info.name}</td>
                </tr>
                <tr>
                    <td class="bg-gray">联系方式</td>
                    <td>{$info.phone}</td>
                </tr>
                <tr>
                    <td class="bg-gray">出发地点</td>
                    <td>{$info.start_prov}{$info.start_city}{$info.start_area}{$info.start_address}</td>
                </tr>
                <tr>
                    <td class="bg-gray">出发时间</td>
                    <td>{$info.start_date?date_format(date_create($info.start_date),'Y-m-d H:i'):''}</td>
                </tr>
                <tr>
                    <td class="bg-gray">到达地点</td>
                    <td>{$info.end_prov}{$info.end_city}{$info.end_area}{$info.end_address}</td>
                </tr>
                <tr>
                    <td class="bg-gray">回程时间</td>
                    <td>{$info.end_date?date_format(date_create($info.end_date),'Y-m-d H:i'):''}</td>
                </tr>
                <tr>
                    <td class="bg-gray">乘坐人数</td>
                    <td>{$info.num}</td>
                </tr>
                <tr>
                    <td class="bg-gray">结账方式</td>
                    <td>{if $info.type == 1}全包现收{elseif $info.type == 2}全包预收{elseif $info.type == 3}全包记账{elseif $info.type == 4}净价现收{elseif $info.type == 5}净价预收{elseif $info.type == 6}净价记账{/if}</td>
                </tr>
                <tr>
                    <td class="bg-gray">预付金额</td>
                    <td>{$info.true_money}</td>
                </tr>
                <tr>
                    <td class="bg-gray">订单金额</td>
                    <td>{$info.total_money}</td>
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