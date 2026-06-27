<{if $block.items|default:false}>
    <div class="quotes-block quotes-block-authors">
        <{foreach item=item from=$block.items}>
            <a class="quotes-block-author<{if $item.photo|default:'' == ''}> quotes-block-no-image<{/if}>" href="<{$item.url|escape:'html'}>">
                <{if $item.photo|default:'' != ''}>
                    <img src="<{$item.photo|escape:'html'}>" alt="<{$item.name|escape}>">
                <{/if}>
                <span>
                    <span class="quotes-block-title"><{$item.name|escape}></span>
                    <{if $item.country|default:'' != ''}>
                        <span class="quotes-block-text"><{$item.country|escape}></span>
                    <{/if}>
                </span>
            </a>
        <{/foreach}>
        <a class="quotes-block-more" href="<{$block.url|escape:'html'}>"><{$smarty.const._MD_QUOTES_AUTHOR|default:'Authors'|escape}></a>
    </div>
<{/if}>
