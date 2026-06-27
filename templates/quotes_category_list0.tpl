<{include file="db:quotes_header.tpl"}>

<section class="quotes-section">
    <div class="quotes-section-heading">
        <h2><{$smarty.const._MD_QUOTES_CATEGORY|default:'Categories'|escape}></h2>
    </div>

    <{if $category|default:false}>
        <div class="quotes-grid quotes-grid-categories">
            <{foreach item=categoryitem from=$category}>
                <article class="quotes-card quotes-card-category">
                    <a href="<{$categoryitem.url|escape:'html'}>">
                        <{if $categoryitem.image_url|default:'' != ''}>
                            <img src="<{$categoryitem.image_url|escape:'html'}>" alt="<{$categoryitem.title|escape}>">
                        <{else}>
                            <div class="quotes-category-visual <{$categoryitem.visual_class|default:'quotes-category-visual--default'|escape:'html'}>" aria-hidden="true">
                                <span></span>
                            </div>
                        <{/if}>
                        <div>
                            <span class="quotes-color" style="background-color:<{$categoryitem.color|escape:'html'}>"></span>
                            <h3><{$categoryitem.title|escape}></h3>
                            <{if $categoryitem.description|default:'' != ''}>
                                <p><{$categoryitem.description|strip_tags|escape}></p>
                            <{/if}>
                        </div>
                    </a>
                    <{if $xoops_isadmin === true}>
                        <div class="quotes-card-actions">
                            <a href="category.php?op=edit&amp;id=<{$categoryitem.id}>" title="<{$smarty.const._EDIT|escape}>"><{$smarty.const._EDIT|escape}></a>
                            <{if $xoops_isadmin === true}><a href="admin/category.php?op=delete&amp;id=<{$categoryitem.id}>" title="<{$smarty.const._DELETE|escape}>"><{$smarty.const._DELETE|escape}></a><{/if}>
                        </div>
                    <{/if}>
                </article>
            <{/foreach}>
        </div>
    <{else}>
        <div class="quotes-empty"><{$smarty.const._MD_QUOTES_CATEGORY_DESC|default:'No categories are available yet.'|escape}></div>
    <{/if}>
</section>

<{if $pagination|default:'' != ''}>
    <nav class="quotes-pagination"><{render_pagination total=$pagination.total limit=$pagination.limit start=$pagination.start urlPattern=$pagination.url window=2}></nav>
<{elseif $pagenav|default:'' != ''}>
    <nav class="quotes-pagination"><{$pagenav}></nav>
<{/if}>

<{include file="db:quotes_footer.tpl"}>
