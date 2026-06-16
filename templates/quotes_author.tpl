<{include file="db:quotes_header.tpl"}>

<article class="quotes-detail quotes-detail-author">
    <{if $author.photo_url|default:'' != ''}>
        <img src="<{$author.photo_url|escape:'html'}>" alt="<{$author.name|escape}>">
    <{/if}>
    <div>
        <h2><{$author.name|default:''|escape}></h2>
        <{if $author.country|default:'' != ''}>
            <p class="quotes-card-meta"><{$author.country|escape}></p>
        <{/if}>
        <{if $author.bio|default:'' != ''}>
            <div class="quotes-rich-text"><{$author.bio}></div>
        <{/if}>
        <dl>
            <{if $author.created|default:'' != ''}>
                <div>
                    <dt><{$smarty.const.MD_QUOTES_AUTHOR_CREATED|default:'Created'|escape}></dt>
                    <dd><{$author.created|escape}></dd>
                </div>
            <{/if}>
            <{if $author.updated|default:'' != ''}>
                <div class="quotes-detail-actions-row">
                    <dt><{$smarty.const.MD_QUOTES_AUTHOR_UPDATED|default:'Updated'|escape}></dt>
                    <dd>
                        <span><{$author.updated|escape}></span>
                        <{if $xoops_isadmin === true}>
                            <span class="quotes-detail-inline-actions">
                                <a href="author.php?op=edit&amp;id=<{$author.id}>" title="<{$smarty.const._EDIT|escape}>"><{$smarty.const._EDIT|escape}></a>
                                <a href="admin/author.php?op=delete&amp;id=<{$author.id}>" title="<{$smarty.const._DELETE|escape}>"><{$smarty.const._DELETE|escape}></a>
                            </span>
                        <{/if}>
                    </dd>
                </div>
            <{/if}>
        </dl>
    </div>
</article>

<{if $author_quote|default:false}>
    <section class="quotes-section quotes-author-quotes">
        <div class="quotes-section-heading">
            <h2><{$smarty.const.MD_QUOTES_QUOTE|default:'Quote'|escape}></h2>
            <{if $author_quote_nav.count|default:0 > 1}>
                <span class="quotes-quote-count"><{$author_quote_nav.index}> / <{$author_quote_nav.count}></span>
            <{/if}>
        </div>
        <article class="quotes-card quotes-card-quote quotes-author-quote-card">
            <a href="<{$author_quote.url|escape:'html'}>">
                <blockquote><{$author_quote.quote}></blockquote>
            </a>
            <{if $author_quote_nav.count|default:0 > 1}>
                <div class="quotes-quote-nav">
                    <{if $author_quote_nav.prev|default:'' != ''}>
                        <a href="<{$author_quote_nav.prev|escape:'html'}>" aria-label="Previous quote">&lsaquo;</a>
                    <{else}>
                        <span aria-hidden="true">&lsaquo;</span>
                    <{/if}>
                    <{if $author_quote_nav.next|default:'' != ''}>
                        <a href="<{$author_quote_nav.next|escape:'html'}>" aria-label="Next quote">&rsaquo;</a>
                    <{else}>
                        <span aria-hidden="true">&rsaquo;</span>
                    <{/if}>
                </div>
            <{/if}>
        </article>
    </section>
<{/if}>

<{if $pagenav|default:'' != ''}>
    <nav class="quotes-pagination"><{$pagenav}></nav>
<{/if}>

<{include file="db:quotes_footer.tpl"}>
