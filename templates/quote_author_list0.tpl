<{include file="db:quote_header.tpl"}>
<div class="panel panel-info">
    <div class="panel-heading"><h2 class="panel-title"><strong>Author</strong> </h2></div>

    <table class="table table-striped">
        <thead>
                <tr>
                    <th><{$smarty.const.MD_QUOTE_AUTHOR_ID}></th>  <th><{$smarty.const.MD_QUOTE_AUTHOR_NAME}></th>  <th><{$smarty.const.MD_QUOTE_AUTHOR_COUNTRY}></th>  <th><{$smarty.const.MD_QUOTE_AUTHOR_BIO}></th>  <th><{$smarty.const.MD_QUOTE_AUTHOR_PHOTO}></th>  <th><{$smarty.const.MD_QUOTE_AUTHOR_CREATED}></th>  <th><{$smarty.const.MD_QUOTE_AUTHOR_UPDATED}></th><th  width="80"><{$smarty.const.MD_QUOTE_ACTION}></th>
            </tr>
            </thead>
        <{foreach itemitem=author from=$author}>
            <tbody>
            <tr>

                             <td><{$authoritem.id}></td>
                    <td><{$authoritem.name}></td>
                    <td><{$authoritem.country}></td>
                    <td><{$authoritem.bio}></td>
                    <td><img src="<{$xoops_url}>/uploads/quote/images/<{$authoritem.photo}>" style="max-width:100px" alt="author"></td>
                   <td><{$authoritem.created}></td>
                    <td><{$authoritem.updated}></td>
                                <td>
                       <a href="author.php?op=view&id=<{$authoritem.id}>" title="<{$smarty.const._PREVIEW}>"><img src="<{xoModuleIcons16 'search.png'}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>"</a>
                       <{if $xoops_isadmin === true}>
                       <a href="author.php?op=edit&id=<{$authoritem.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>" ></a>
                       <a href="admin/author.php?op=delete&id=<{$authoritem.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
                       <{/if}>
                   </td>
                </tr>
               </tbody>
        <{/foreach}>
    </table>
</div>
<{$pagenav}>
    <{$commentsnav}> <{$lang_notice}>
        <{if $comment_mode|default:'' == "flat"}>
        <{include file="db:system_comments_flat.tpl"}>
    <{elseif $comment_mode|default:'' == "thread"}>
        <{include file="db:system_comments_thread.tpl"}>
    <{elseif $comment_mode|default:'' == "nest"}><{include file="db:system_comments_nest.tpl"}> <{/if}>
<{include file="db:quote_footer.tpl"}>
