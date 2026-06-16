<{include file="db:quotes_header.tpl"}>

<article class="quotes-detail quotes-detail-category">
    <{if $category.image_url|default:'' != ''}>
        <img src="<{$category.image_url|escape:'html'}>" alt="<{$category.title|escape}>">
    <{else}>
        <div class="quotes-category-visual quotes-category-visual-detail <{$category.visual_class|default:'quotes-category-visual--default'|escape:'html'}>" aria-hidden="true">
            <span></span>
        </div>
    <{/if}>
    <div>
        <span class="quotes-color" style="background-color:<{$category.color|escape:'html'}>"></span>
        <h2><{$category.title|default:''|escape}></h2>
        <{if $category.description|default:'' != ''}>
            <p><{$category.description|strip_tags|escape}></p>
        <{/if}>
        <dl>
            <div class="quotes-detail-actions-row">
                <dt><{$smarty.const.MD_QUOTES_CATEGORY_WEIGHT|default:'Weight'|escape}></dt>
                <dd>
                    <span><{$category.weight|default:0}></span>
                    <{if $xoops_isadmin === true}>
                        <span class="quotes-detail-inline-actions">
                            <a href="category.php?op=edit&amp;id=<{$category.id}>" title="<{$smarty.const._EDIT|escape}>"><{$smarty.const._EDIT|escape}></a>
                            <a href="admin/category.php?op=delete&amp;id=<{$category.id}>" title="<{$smarty.const._DELETE|escape}>"><{$smarty.const._DELETE|escape}></a>
                        </span>
                    <{/if}>
                </dd>
            </div>
        </dl>
    </div>
</article>

<{if $category_quotes|default:false}>
    <section class="quotes-section">
        <div class="quotes-section-heading">
            <h2><{$smarty.const.MD_QUOTES_QUOTE|default:'Quotes'|escape}></h2>
            <a href="<{$quotes_url|escape:'html'}>/quote.php"><{$smarty.const.MD_QUOTES_QUOTE|default:'Quote'|escape}></a>
        </div>
        <div class="quotes-grid quotes-grid-quotes">
            <{foreach item=quoteitem from=$category_quotes}>
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
                                </p>
                            </div>
                        </div>
                    </a>
                </article>
            <{/foreach}>
        </div>
    </section>
<{/if}>

<{if $pagenav|default:'' != ''}>
    <nav class="quotes-pagination"><{$pagenav}></nav>
<{/if}>

<{include file="db:quotes_footer.tpl"}>
