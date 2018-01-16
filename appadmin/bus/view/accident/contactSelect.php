{__NOLAYOUT__}
{include file="publics:topCss"}
<div class="container-fluid"  style="padding-top:12px;padding-bottom:50px;">
    <div id="alert"></div>
    <form  class="form-horizontal" action="{:url('stock/contactSelect',['id'=>$id])}" method="post">
    <table class="table table-bordered">
           <tbody class="layui-form">
                <?php $num = count($contactList)%3;?>
                {volist name="$contactList" id="v" key="k"}
                    {if $k % 3 == 1}<tr>{/if}
                    <td >
                        <input type="radio" name="contact" {$v.id == $id?'checked':''} value="{$v.id}" title="{$v.name}">
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
    </form>
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
        $("table").on("click",".layui-form-radio",function(){
            var id = $(this).prev().val();
            var title = $(this).prev().attr("title");
            $(parent.document).find("#repair_id").val(id);
            $(parent.document).find(".select-repair").text(title);
        })
    })
</script>