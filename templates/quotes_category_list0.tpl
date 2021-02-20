<{include file="db:quotes_header.tpl"}>
<div class="panel panel-info">
    <div class="panel-heading"><h2 class="panel-title"><strong>Category</strong> </h2></div>

    <table class="table table-striped">
        <thead>
                <tr>
                    <th><{$smarty.const.MD_QUOTES_CATEGORY_ID}></th>  <th><{$smarty.const.MD_QUOTES_CATEGORY_PID}></th>  <th><{$smarty.const.MD_QUOTES_CATEGORY_TITLE}></th>  <th><{$smarty.const.MD_QUOTES_CATEGORY_DESCRIPTION}></th>  <th><{$smarty.const.MD_QUOTES_CATEGORY_IMAGE}></th>  <th><{$smarty.const.MD_QUOTES_CATEGORY_WEIGHT}></th>  <th><{$smarty.const.MD_QUOTES_CATEGORY_COLOR}></th>  <th><{$smarty.const.MD_QUOTES_CATEGORY_ONLINE}></th><th  width="80"><{$smarty.const.MD_QUOTES_ACTION}></th>
            </tr>
            </thead>
        <{foreach item=category from=$category}>
            <tbody>
            <tr>

                             <td><{$category.id}></td>
                    <td><{$category.pid}></td>
                    <td><{$category.title}></td>
                    <td><{$category.description}></td>
                    <td><img src="<{$xoops_url}>/uploads/quotes/category/<{$category.image}>" style="max-width:100px" alt="category"></td>
                   <td><{$category.weight}></td>
                    <td><span style="background-color: <{$category.color}>;">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                      <td><{$category.online}></td>
                                <td>
                       <a href="category.php?op=view&id=<{$category.id}>" title="<{$smarty.const._PREVIEW}>"><img src="<{xoModuleIcons16 search.png}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>"</a>
                       <{if $xoops_isadmin == true}>
                       <a href="category.php?op=edit&id=<{$category.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>" ></a>
                       <a href="admin/category.php?op=delete&id=<{$category.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
                       <{/if}>
                   </td>
                </tr>
               </tbody>
        <{/foreach}>
    </table>
</div>
<{$pagenav|default:''}>
    <{$commentsnav|default:''}> <{$lang_notice|default:''}>
    <{if $comment_mode|default:'' == "flat"}> <{include file="db:system_comments_flat.tpl"}> <{elseif $comment_mode|default:'' == "thread"}> <{include file="db:system_comments_thread.tpl"}> <{elseif $comment_mode|default:'' == "nest"}> <{include file="db:system_comments_nest.tpl"}> <{/if}>
<{include file="db:quotes_footer.tpl"}>
