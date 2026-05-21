<{include file="db:quote_header.tpl"}>
<div class="panel panel-info">
    <div class="panel-heading"><h2 class="panel-title"><strong>Quote</strong> </h2></div>

    <table class="table table-striped">
        <thead>
                <tr>
                    <th><{$smarty.const.MD_QUOTE_QUOTE_ID}></th>  <th><{$smarty.const.MD_QUOTE_QUOTE_CID}></th>  <th><{$smarty.const.MD_QUOTE_QUOTE_AUTHOR_ID}></th>  <th><{$smarty.const.MD_QUOTE_QUOTE_QUOTE}></th>  <th><{$smarty.const.MD_QUOTE_QUOTE_ONLINE}></th>  <th><{$smarty.const.MD_QUOTE_QUOTE_CREATED}></th>  <th><{$smarty.const.MD_QUOTE_QUOTE_UPDATED}></th><th  width="80"><{$smarty.const.MD_QUOTE_ACTION}></th>
            </tr>
            </thead>
        <{foreach item=quoteitem from=$quote}>
            <tbody>
            <tr>

                             <td><{$quoteitem.id}></td>
                    <td><{$quoteitem.cid}></td>
                    <td><{$quoteitem.author_id}></td>
                    <td><{$quoteitem.quote}></td>
                    <td><{$quoteitem.online}></td>
                    <td><{$quoteitem.created}></td>
                    <td><{$quoteitem.updated}></td>
                                <td>
                       <a href="quote.php?op=view&id=<{$quoteitem.id}>" title="<{$smarty.const._PREVIEW}>"><img src="<{xoModuleIcons16 'search.png'}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>"</a>
                       <{if $xoops_isadmin === true}>
                       <a href="quote.php?op=edit&id=<{$quoteitem.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>" ></a>
                       <a href="admin/quote.php?op=delete&id=<{$quoteitem.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
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
