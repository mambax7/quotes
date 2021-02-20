<{include file="db:quotes_header.tpl"}>
<div class="panel panel-info">
    <div class="panel-heading"><h2 class="panel-title">Author </h2></div>

    <table class="table table-striped">
        <thead>
        <tr>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td><{$smarty.const.MD_QUOTES_AUTHOR_ID}></td>
            <td><{$author.id}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_AUTHOR_NAME}></td>
            <td><{$author.name}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_AUTHOR_COUNTRY}></td>
            <td><{$author.country}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_AUTHOR_BIO}></td>
            <td><{$author.bio}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_AUTHOR_PHOTO}></td>
            <td><img src="<{$xoops_url}>/uploads/quotes/author/<{$author.photo}>" alt="author" class="img-responsive"></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_AUTHOR_CREATED}></td>
            <td><{$author.created}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_AUTHOR_UPDATED}></td>
            <td><{$author.updated}></td>
        </tr>
        <tr>
            <td><{$smarty.const.MD_QUOTES_ACTION}></td>
            <td>
                <!--<a href="author.php?op=view&id=<{$author.id}>" title="<{$smarty.const._PREVIEW}>"><img src="<{xoModuleIcons16 search.png}>" alt="<{$smarty.const._PREVIEW}>" title="<{$smarty.const._PREVIEW}>"</a>&nbsp;-->
                <{if $xoops_isadmin == true}>
                    <a href="author.php?op=edit&id=<{$author.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}>" title="<{$smarty.const._EDIT}>"></a>
                    &nbsp;
                    <a href="admin/author.php?op=delete&id=<{$author.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}>" title="<{$smarty.const._DELETE}>"</a>
                <{/if}>
            </td>
        </tr>
        </tbody>

    </table>
</div>
<div id="pagenav"><{$pagenav}></div>
<{$commentsnav|default:''}> <{$lang_notice|default:''}>
<{if $comment_mode|default:'' == "flat"}> <{include file="db:system_comments_flat.tpl"}> <{elseif $comment_mode|default:'' == "thread"}> <{include file="db:system_comments_thread.tpl"}> <{elseif $comment_mode|default:'' == "nest"}> <{include file="db:system_comments_nest.tpl"}> <{/if}>
<{include file="db:quotes_footer.tpl"}>
