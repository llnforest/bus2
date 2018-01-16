{__NOLAYOUT__}
{include file="publics:topCss"}
<div class="container-fluid"  style="padding-top:12px;padding-bottom:50px;">
    <div id="alert"></div>
    <table class="table table-bordered">
           <tbody class="layui-form">
                <?php $num = count($userList)%3;?>
                {volist name="$userList" id="v" key="k"}
                    {if $k % 3 == 1}<tr>{/if}
                    <td >
                        <input type="checkbox" name="user" value="{$v.id}" title="{$v.name}" lay-skin="primary" {if in_array($v.id,$id)}checked{/if}>
                    </td>
                    {if $k%3 == 0}
                    </tr>
                    {/if}
                {/volist}
                {if $num != 0}
                {for start="0" end="3-$num"}
                <td></td>
                {/for}
                </tr>
                {/if}
            </tbody>
        </table>
        <div class="layer-box-bottom" style="padding-top:0;">
            <span class="btn btn-success layui-off">确定</span>
        </div>
</div>
{include file="publics:bottomJs"}
<style>
    td{
        border:none !important;
    }
    table{
        border:none !important;
    }
</style>
<script>
    $(function(){
        $("table").on("click",".layui-form-checkbox",function(){
            var names=[],ids=[];
            $("input[name='user']:checked").each(function(){
                names.push($(this).attr("title"));
                ids.push($(this).val());
            });
            names = names.join(',');
            ids = ids.join(',');
            $(parent.document).find("#bus_user_id").val(ids);
            $(parent.document).find(".select-bus-user").text(names);
        })
    })
</script>