<{include file="db:quote_header.tpl"}>
<div class="panel panel-info">
    <div class="panel-heading"><h2 class="panel-title"><strong>Quotes</strong> </h2></div>

    <table class="table table-striped">
        <thead>
                <tr>
                    <th><{$smarty.const.MD_QUOTE_QUOTES_ID}></th>  <th><{$smarty.const.MD_QUOTE_QUOTES_CID}></th>  <th><{$smarty.const.MD_QUOTE_QUOTES_AUTHOR_ID}></th>  <th><{$smarty.const.MD_QUOTE_QUOTES_QUOTE}></th>  <th><{$smarty.const.MD_QUOTE_QUOTES_ONLINE}></th>  <th><{$smarty.const.MD_QUOTE_QUOTES_CREATED}></th>  <th><{$smarty.const.MD_QUOTE_QUOTES_UPDATED}></th><th  width="80"><{$smarty.const.MD_QUOTE_ACTION}></th>
            </tr>
            </thead>
        <{foreach item=quotesitem from=$quotes}>
            <tbody>
            <tr>

                             <td><{$quoteitems.id}></td>
                    <td><{$quoteitems.cid}></td>
                    <td><{$quoteitems.author_id}></td>
                    <td><{$quoteitems.quote}></td>
                    <td><{$quoteitems.online}></td>
                    <td><{$quoteitems.created}></td>
                    <td><{$quoteitems.updated}></td>
                                <td>
                       <a href="quotes.php?op=view&id=<{$quoteitems.id}>" title="<{$smarty.const._PREVIEW}>"><img src="<{xoModuleIcons16 'search.png'}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>"</a>
                       <{if $xoops_isadmin === true}>
                       <a href="quotes.php?op=edit&id=<{$quoteitems.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>" ></a>
                       <a href="admin/quotes.php?op=delete&id=<{$quoteitems.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
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
