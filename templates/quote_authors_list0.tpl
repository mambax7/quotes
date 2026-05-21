<{include file="db:quote_header.tpl"}>
<div class="panel panel-info">
    <div class="panel-heading"><h2 class="panel-title"><strong>Authors</strong> </h2></div>

    <table class="table table-striped">
        <thead>
                <tr>
                    <th><{$smarty.const.MD_QUOTE_AUTHORS_ID}></th>  <th><{$smarty.const.MD_QUOTE_AUTHORS_NAME}></th>  <th><{$smarty.const.MD_QUOTE_AUTHORS_COUNTRY}></th>  <th><{$smarty.const.MD_QUOTE_AUTHORS_BIO}></th>  <th><{$smarty.const.MD_QUOTE_AUTHORS_PHOTO}></th>  <th><{$smarty.const.MD_QUOTE_AUTHORS_CREATED}></th>  <th><{$smarty.const.MD_QUOTE_AUTHORS_UPDATED}></th><th  width="80"><{$smarty.const.MD_QUOTE_ACTION}></th>
            </tr>
            </thead>
        <{foreach item=author from=$authors}>
            <tbody>
            <tr>

                             <td><{$author.id}></td>
                    <td><{$author.name}></td>
                    <td><{$author.country}></td>
                    <td><{$author.bio}></td>
                    <td><img src="<{$xoops_url}>/uploads/quote/images/<{$author.photo}>" style="max-width:100px" alt="authors"></td>
                   <td><{$author.created}></td>
                    <td><{$author.updated}></td>
                                <td>
                       <a href="authors.php?op=view&id=<{$author.id}>" title="<{$smarty.const._PREVIEW}>"><img src="<{xoModuleIcons16 'search.png'}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>"</a>
                       <{if $xoops_isadmin === true}>
                       <a href="authors.php?op=edit&id=<{$author.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>" ></a>
                       <a href="admin/authors.php?op=delete&id=<{$author.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
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
