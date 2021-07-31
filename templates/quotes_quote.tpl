<{include file="db:quotes_header.tpl"}>
<div class="panel panel-info">
    <div class="panel-heading"><h2 class="panel-title">Quote </h2></div>

    <table class="table table-striped">
        <thead>
        <tr>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td><{$smarty.const.MD_QUOTES_QUOTE_ID}></td>
            <td><{$quote.id}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_QUOTE_CID}></td>
            <td><{$quote.cid}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_QUOTE_AUTHOR_ID}></td>
            <td><{$quote.author_id}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_QUOTE_QUOTE}></td>
            <td><{$quote.quote}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_QUOTE_ONLINE}></td>
            <td><{$quote.online}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_QUOTE_CREATED}></td>
            <td><{$quote.created}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_QUOTE_UPDATED}></td>
            <td><{$quote.updated}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_ACTION}></td>
            <td>
                <!--<a href="quote.php?op=view&id=<{$quote.id}>" title="<{$smarty.const._PREVIEW}>"><img src="<{xoModuleIcons16 search.png}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>"</a>&nbsp;-->
                <{if $xoops_isadmin == true}>
                    <a href="quote.php?op=edit&id=<{$quote.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>"></a>
                    &nbsp;
                    <a href="admin/quote.php?op=delete&id=<{$quote.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
                <{/if}>
            </td>
        </tr>
        </tbody>

    </table>
</div>
<div id="pagenav"><{$pagenav}></div>
<{$commentsnav}> <{$lang_notice}>
<{if $comment_mode|default:'' == "flat"}> <{include file="db:system_comments_flat.tpl"}> <{elseif $comment_mode == "thread"}> <{include file="db:system_comments_thread.tpl"}> <{elseif $comment_mode == "nest"}> <{include file="db:system_comments_nest.tpl"}> <{/if}>
<{include file="db:quotes_footer.tpl"}>
