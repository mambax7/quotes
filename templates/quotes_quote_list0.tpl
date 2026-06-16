<{include file="db:quotes_header.tpl"}>

<section class="quotes-section">
    <div class="quotes-section-heading">
        <h2><{$smarty.const.MD_QUOTES_QUOTE|default:'Quotes'|escape}></h2>
    </div>

    <{if $quote|default:false}>
        <div class="quotes-grid quotes-grid-quotes">
            <{foreach item=quoteitem from=$quote}>
                <article class="quotes-card quotes-card-quote">
                    <a href="<{$quoteitem.url|escape:'html'}>">
                        <blockquote><{$quoteitem.quote}></blockquote>
                        <div class="quotes-card-quote-meta">
                            <{if $quoteitem.author_photo_url|default:'' != ''}>
                                <img src="<{$quoteitem.author_photo_url|escape:'html'}>" alt="<{$quoteitem.author|escape}>">
                            <{/if}>
                            <div>
                                <p class="quotes-card-author-line">
                                    <{if $quoteitem.author|default:'' != ''}>
                                        <strong><{$quoteitem.author|escape}></strong>
                                    <{/if}>
                                    <{if $quoteitem.author_country|default:'' != ''}>
                                        <span><{$quoteitem.author_country|escape}></span>
                                    <{/if}>
                                </p>
                                <p class="quotes-card-meta">
                                    <{if $quoteitem.category|default:'' != ''}><span><{$quoteitem.category|escape}></span><{/if}>
                                    <{if $quoteitem.created|default:'' != ''}><span><{$quoteitem.created|escape}></span><{/if}>
                                </p>
                            </div>
                        </div>
                    </a>
                    <{if $xoops_isadmin === true}>
                        <div class="quotes-card-actions">
                            <a href="quote.php?op=edit&amp;id=<{$quoteitem.id}>" title="<{$smarty.const._EDIT|escape}>"><{$smarty.const._EDIT|escape}></a>
                            <a href="admin/quote.php?op=delete&amp;id=<{$quoteitem.id}>" title="<{$smarty.const._DELETE|escape}>"><{$smarty.const._DELETE|escape}></a>
                        </div>
                    <{/if}>
                </article>
            <{/foreach}>
        </div>
    <{else}>
        <div class="quotes-empty"><{$smarty.const.MD_QUOTES_QUOTE_DESC|default:'No quotes are available yet.'|escape}></div>
    <{/if}>
</section>

<{if $pagenav|default:'' != ''}>
    <nav class="quotes-pagination"><{$pagenav}></nav>
<{/if}>

<{include file="db:quotes_footer.tpl"}>
