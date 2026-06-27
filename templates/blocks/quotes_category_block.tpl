<{if $block.items|default:false}>
    <div class="quotes-block quotes-block-categories">
        <{foreach item=item from=$block.items}>
            <a class="quotes-block-category<{if $item.image|default:'' == ''}> quotes-block-no-image<{/if}>" href="<{$item.url|escape:'html'}>">
                <{if $item.image|default:'' != ''}>
                    <img src="<{$item.image|escape:'html'}>" alt="<{$item.title|escape}>">
                <{/if}>
                <span class="quotes-block-category-body">
                    <span class="quotes-block-title"><{$item.title|escape}></span>
                    <{if $item.description|default:'' != ''}>
                        <span class="quotes-block-text"><{$item.description|strip_tags|escape}></span>
                    <{/if}>
                </span>
            </a>
        <{/foreach}>
        <a class="quotes-block-more" href="<{$block.url|escape:'html'}>"><{$smarty.const._MD_QUOTES_CATEGORY|default:'Categories'|escape}></a>
    </div>
<{/if}>
