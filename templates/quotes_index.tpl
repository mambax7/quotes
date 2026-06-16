<{include file="db:quotes_header.tpl"}>

<section class="quotes-intro">
    <div>
        <h2><{$smarty.const.MD_QUOTES_INDEX|default:'Quotes'|escape}></h2>
        <p><{$smarty.const.MD_QUOTES_INDEX_DESC|default:'Browse memorable quotes by author and category.'|escape}></p>
    </div>
    <div class="quotes-stats" aria-label="<{$smarty.const.MD_QUOTES_TITLE|default:'Quotes'|escape}>">
        <a href="<{$quotes_url|escape:'html'}>/quote.php">
            <strong><{$quotes_stats.quotes|default:0}></strong>
            <span><{$smarty.const.MD_QUOTES_QUOTE|default:'Quotes'|escape}></span>
        </a>
        <a href="<{$quotes_url|escape:'html'}>/category.php">
            <strong><{$quotes_stats.categories|default:0}></strong>
            <span><{$smarty.const.MD_QUOTES_CATEGORY|default:'Categories'|escape}></span>
        </a>
        <a href="<{$quotes_url|escape:'html'}>/author.php">
            <strong><{$quotes_stats.authors|default:0}></strong>
            <span><{$smarty.const.MD_QUOTES_AUTHOR|default:'Authors'|escape}></span>
        </a>
    </div>
</section>

<{if $latest_quotes|default:false}>
    <section class="quotes-section">
        <div class="quotes-section-heading">
            <h2><{$smarty.const.MD_QUOTES_QUOTE|default:'Latest quotes'|escape}></h2>
            <a href="<{$quotes_url|escape:'html'}>/quote.php"><{$smarty.const.MD_QUOTES_QUOTE|default:'View all quotes'|escape}></a>
        </div>
        <div class="quotes-grid quotes-grid-quotes">
            <{foreach item=item from=$latest_quotes}>
                <article class="quotes-card quotes-card-quote">
                    <a href="<{$item.url|escape:'html'}>">
                        <blockquote><{$item.quote}></blockquote>
                        <div class="quotes-card-quote-meta">
                            <{if $item.author_photo_url|default:'' != ''}>
                                <img src="<{$item.author_photo_url|escape:'html'}>" alt="<{$item.author|escape}>">
                            <{/if}>
                            <div>
                                <p class="quotes-card-author-line">
                                    <{if $item.author|default:'' != ''}>
                                        <strong><{$item.author|escape}></strong>
                                    <{/if}>
                                    <{if $item.author_country|default:'' != ''}>
                                        <span><{$item.author_country|escape}></span>
                                    <{/if}>
                                </p>
                                <p class="quotes-card-meta">
                                    <{if $item.category|default:'' != ''}><span><{$item.category|escape}></span><{/if}>
                                </p>
                            </div>
                        </div>
                    </a>
                </article>
            <{/foreach}>
        </div>
    </section>
<{/if}>

<{include file="db:quotes_footer.tpl"}>
