<{include file="db:quotes_header.tpl"}>

<article class="quotes-detail quotes-detail-quote">
    <{if $quote_nav.prev|default:'' != ''}>
        <a class="quotes-detail-quote-nav quotes-detail-quote-nav-prev" href="<{$quote_nav.prev|escape:'html'}>" aria-label="<{$smarty.const.MD_QUOTES_QUOTE_PREVIOUS|escape}>" title="<{$smarty.const.MD_QUOTES_QUOTE_PREVIOUS|escape}>"><span aria-hidden="true">&lsaquo;</span></a>
    <{/if}>
    <{if $quote_nav.next|default:'' != ''}>
        <a class="quotes-detail-quote-nav quotes-detail-quote-nav-next" href="<{$quote_nav.next|escape:'html'}>" aria-label="<{$smarty.const.MD_QUOTES_QUOTE_NEXT|escape}>" title="<{$smarty.const.MD_QUOTES_QUOTE_NEXT|escape}>"><span aria-hidden="true">&rsaquo;</span></a>
    <{/if}>
    <blockquote><{$quote.quote|default:''}></blockquote>
    <dl>
        <{if $quote.author|default:'' != ''}>
            <div>
                <dt><{$smarty.const.MD_QUOTES_QUOTE_AUTHOR_ID|default:'Author'|escape}></dt>
                <dd class="quotes-detail-person">
                    <a href="<{$quotes_url|escape:'html'}>/author.php?op=view&amp;id=<{$quote.author_id}>"><{$quote.author|escape}></a>
                    <{if $quote.author_photo_url|default:'' != ''}>
                        <a class="quotes-detail-person-photo" href="<{$quotes_url|escape:'html'}>/author.php?op=view&amp;id=<{$quote.author_id}>">
                            <img src="<{$quote.author_photo_url|escape:'html'}>" alt="<{$quote.author|escape}>">
                        </a>
                    <{/if}>
                </dd>
            </div>
        <{/if}>
        <{if $quote.category|default:'' != ''}>
            <div>
                <dt><{$smarty.const.MD_QUOTES_QUOTE_CID|default:'Category'|escape}></dt>
                <dd><a href="<{$quotes_url|escape:'html'}>/category.php?op=view&amp;id=<{$quote.category_id}>"><{$quote.category|escape}></a></dd>
            </div>
        <{/if}>
        <{if $quote.updated|default:'' != '' && $quote.created|default:'' != ''}>
            <div>
                <dt><{$smarty.const.MD_QUOTES_QUOTE_CREATED|default:'Created'|escape}></dt>
                <dd><{$quote.created|escape}></dd>
            </div>
        <{/if}>
        <{if $quote.updated|default:'' != ''}>
            <div class="quotes-detail-actions-row">
                <dt><{$smarty.const.MD_QUOTES_QUOTE_UPDATED|default:'Updated'|escape}></dt>
                <dd>
                    <span><{$quote.updated|escape}></span>
                    <{if $xoops_isadmin === true}>
                        <span class="quotes-detail-inline-actions">
                            <a href="quote.php?op=edit&amp;id=<{$quote.id}>" title="<{$smarty.const._EDIT|escape}>"><{$smarty.const._EDIT|escape}></a>
                            <a href="admin/quote.php?op=delete&amp;id=<{$quote.id}>" title="<{$smarty.const._DELETE|escape}>"><{$smarty.const._DELETE|escape}></a>
                        </span>
                    <{/if}>
                </dd>
            </div>
        <{elseif $quote.created|default:'' != ''}>
            <div class="quotes-detail-actions-row">
                <dt><{$smarty.const.MD_QUOTES_QUOTE_CREATED|default:'Created'|escape}></dt>
                <dd>
                    <span><{$quote.created|escape}></span>
                    <{if $xoops_isadmin === true}>
                        <span class="quotes-detail-inline-actions">
                            <a href="quote.php?op=edit&amp;id=<{$quote.id}>" title="<{$smarty.const._EDIT|escape}>"><{$smarty.const._EDIT|escape}></a>
                            <a href="admin/quote.php?op=delete&amp;id=<{$quote.id}>" title="<{$smarty.const._DELETE|escape}>"><{$smarty.const._DELETE|escape}></a>
                        </span>
                    <{/if}>
                </dd>
            </div>
        <{/if}>
    </dl>
</article>

<{include file="db:quotes_footer.tpl"}>
