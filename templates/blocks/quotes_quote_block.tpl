<{if $block.items|default:false}>
    <div class="quotes-block quotes-block-quotes">
        <{foreach item=item from=$block.items}>
            <article class="quotes-block-item">
                <a class="quotes-block-quote" href="<{$item.url|escape:'html'}>">
                    <{$item.quote|strip_tags|escape}>
                </a>
                <div class="quotes-block-meta">
                    <{if $item.author|default:'' != ''}>
                        <span class="quotes-block-author-name"><{if $item.author_url|default:'' != ''}><a href="<{$item.author_url|escape:'html'}>"><{$item.author|escape}></a><{else}><{$item.author|escape}><{/if}></span>
                    <{/if}>
                    <{if $item.category|default:'' != ''}>
                        <span><{$item.category|escape}></span>
                    <{/if}>
                </div>
            </article>
        <{/foreach}>
        <a class="quotes-block-more" href="<{$block.url|escape:'html'}>"><{$smarty.const._MB_QUOTES_QUOTE|default:'More quotes'|escape}></a>
    </div>
<{/if}>
