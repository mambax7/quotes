<{include file="db:quotes_header.tpl"}>

<section class="quotes-section">
    <div class="quotes-section-heading">
        <h2><{$smarty.const._MD_QUOTES_AUTHOR|default:'Authors'|escape}></h2>
    </div>

    <{if $author|default:false}>
        <div class="quotes-grid quotes-grid-authors">
            <{foreach item=authoritem from=$author}>
                <article class="quotes-card quotes-card-author">
                    <a href="<{$authoritem.url|escape:'html'}>">
                        <{if $authoritem.photo_url|default:'' != ''}>
                            <img src="<{$authoritem.photo_url|escape:'html'}>" alt="<{$authoritem.name|escape}>">
                        <{/if}>
                        <div>
                            <h3><{$authoritem.name|escape}></h3>
                            <{if $authoritem.country|default:'' != ''}>
                                <p class="quotes-card-meta"><{$authoritem.country|escape}></p>
                            <{/if}>
                            <{if $authoritem.bio|default:'' != ''}>
                                <p><{$authoritem.bio|strip_tags|escape}></p>
                            <{/if}>
                        </div>
                    </a>
                    <{if $authoritem.can_edit}>
                        <div class="quotes-card-actions">
                            <a href="author.php?op=edit&amp;id=<{$authoritem.id}>" title="<{$smarty.const._EDIT|escape}>"><{$smarty.const._EDIT|escape}></a>
                            <{if $xoops_isadmin === true}><a href="admin/author.php?op=delete&amp;id=<{$authoritem.id}>" title="<{$smarty.const._DELETE|escape}>"><{$smarty.const._DELETE|escape}></a><{/if}>
                        </div>
                    <{/if}>
                </article>
            <{/foreach}>
        </div>
    <{else}>
        <div class="quotes-empty"><{$smarty.const._MD_QUOTES_AUTHOR_DESC|default:'No authors are available yet.'|escape}></div>
    <{/if}>
</section>

<{if $pagination|default:'' != ''}>
    <nav class="quotes-pagination"><{render_pagination total=$pagination.total limit=$pagination.limit start=$pagination.start urlPattern=$pagination.url window=2}></nav>
<{elseif $pagenav|default:'' != ''}>
    <nav class="quotes-pagination"><{$pagenav}></nav>
<{/if}>

<{include file="db:quotes_footer.tpl"}>
