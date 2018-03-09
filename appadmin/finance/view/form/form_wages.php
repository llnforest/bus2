
<div class="col-sm-12">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>选择员工</th>
                <td>
                    <span class="span-primary select-user">{$info.user_name?:'选择员工'}</span>
                    <input id="user_id" class="form-control text" type="hidden" name="user_id" value="{$info.user_id??''}">
                </td>
            </tr>
            <tr>
                <th>发放日期</th>
                <td>
                    <input name="wages_date" value="{$info.wages_date??''}"  readonly dom-class="wages_date" class="date-time wages_date form-control laydate-icon text"  type="text" placeholder="选择发放日期">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>基本工资</th>
                <td>
                    <input class="form-control text" type="text" name="base_wages" value="{$info.base_wages??''}" placeholder="基本工资">
                    <span class="form-required">*</span>
                </td>
            </tr>
            <tr>
                <th>其他补发</th>
                <td>
                    <input class="form-control text" type="text" name="qitafa" value="{$info.qitafa??''}" placeholder="其他补发">
                </td>
            </tr>
            <tr>
                <th>其他扣除</th>
                <td>
                    <input class="form-control text" type="text" name="qitakou" value="{$info.qitakou??''}" placeholder="其他扣除">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    明细补发
                </td>
            </tr>
            <tr>
                <th>岗位津贴</th>
                <td>
                    <input class="form-control text" type="text" name="jintie" value="{$info.jintie??''}" placeholder="岗位津贴">
                </td>
            </tr>
            <tr>
                <th>社保补贴</th>
                <td>
                    <input class="form-control text" type="text" name="shebaobutie" value="{$info.shebaobutie??''}" placeholder="社保补贴">
                </td>
            </tr>
            <tr>
                <th>满勤</th>
                <td>
                    <input class="form-control text" type="text" name="manqin" value="{$info.manqin??''}" placeholder="满勤">
                </td>
            </tr>
            <tr>
                <th>工龄</th>
                <td>
                    <input class="form-control text" type="text" name="gongling" value="{$info.gongling??''}" placeholder="工龄">
                </td>
            </tr>
            <tr>
                <th>加班</th>
                <td>
                    <input class="form-control text" type="text" name="jiaban" value="{$info.jiaban??''}" placeholder="加班">
                </td>
            </tr>
            <tr>
                <th>优秀员工</th>
                <td>
                    <input class="form-control text" type="text" name="youxiu" value="{$info.youxiu??''}" placeholder="优秀员工">
                </td>
            </tr>
            <tr>
                <th>退服装押金</th>
                <td>
                    <input class="form-control text" type="text" name="tuifuzhuang" value="{$info.tuifuzhuang??''}" placeholder="退服装押金">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    明细扣除
                </td>
            </tr>
            <tr>
                <th>缺勤</th>
                <td>
                    <input class="form-control text" type="text" name="queqin" value="{$info.queqin??''}" placeholder="缺勤">
                </td>
            </tr>
            <tr>
                <th>病事假</th>
                <td>
                    <input class="form-control text" type="text" name="qingjia" value="{$info.qingjia??''}" placeholder="病事假">
                </td>
            </tr>
            <tr>
                <th>旷工</th>
                <td>
                    <input class="form-control text" type="text" name="kuanggong" value="{$info.kuanggong??''}" placeholder="旷工">
                </td>
            </tr>
            <tr>
                <th>迟到</th>
                <td>
                    <input class="form-control text" type="text" name="chidao" value="{$info.chidao??''}" placeholder="迟到">
                </td>
            </tr>
            <tr>
                <th>社保</th>
                <td>
                    <input class="form-control text" type="text" name="shebao" value="{$info.shebao??''}" placeholder="社保">
                </td>
            </tr>
            <tr>
                <th>个人所得税</th>
                <td>
                    <input class="form-control text" type="text" name="suodeshui" value="{$info.suodeshui??''}" placeholder="个人所得税">
                </td>
            </tr>
            <tr>
                <th>扣服装押金</th>
                <td>
                    <input class="form-control text" type="text" name="yajin" value="{$info.yajin??''}" placeholder="扣服装押金">
                </td>
            </tr>
            <tr>
                <th>过失</th>
                <td>
                    <input class="form-control text" type="text" name="guoshi" value="{$info.guoshi??''}" placeholder="过失">
                </td>
            </tr>
            <tr>
                <th>借款</th>
                <td>
                    <input class="form-control text" type="text" name="jiekuan" value="{$info.jiekuan??''}" placeholder="借款">
                </td>
            </tr>
            <tr>
                <th>餐具</th>
                <td>
                    <input class="form-control text" type="text" name="canju" value="{$info.canju??''}" placeholder="餐具">
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
        //选择用户
        $('.select-user').click(function(){
            var id = $("#user_id").val();
            layer.open({
                type: 2,
                title: '员工选择',
                shadeClose: true,
                shade: false,
                area: ['400px', '500px'],
                content: "{:url('reimburse/userSelect','','')}/id/"+id,
            })
        });


    })
</script>
