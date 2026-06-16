<div class="quotes-shell">
    <header class="quotes-hero">
        <div>
            <p class="quotes-eyebrow"><{$smarty.const.MD_QUOTES_TITLE|default:'Quotes'|escape}></p>
            <h1><{$smarty.const.MD_QUOTES_TITLE|default:'Quotes'|escape}></h1>
            <p class="quotes-hero-copy"><{$smarty.const.MD_QUOTES_DESC|default:'A curated quote library'|replace:'&lt;p&gt;':''|replace:'&lt;/p&gt;':''|escape}></p>
        </div>
        <nav class="quotes-nav" aria-label="<{$smarty.const.MD_QUOTES_TITLE|default:'Quotes'|escape}>">
            <a href="<{$quotes_url|escape:'html'}>/index.php"><{$smarty.const.MD_QUOTES_INDEX|default:'Home'|escape}></a>
            <a href="<{$quotes_url|escape:'html'}>/quote.php"><{$smarty.const.MD_QUOTES_QUOTE|default:'Quotes'|escape}></a>
            <a href="<{$quotes_url|escape:'html'}>/category.php"><{$smarty.const.MD_QUOTES_CATEGORY|default:'Categories'|escape}></a>
            <a href="<{$quotes_url|escape:'html'}>/author.php"><{$smarty.const.MD_QUOTES_AUTHOR|default:'Authors'|escape}></a>
        </nav>
    </header>

    <{if $adv|default:'' != ''}>
        <div class="quotes-ad"><{$adv}></div>
    <{/if}>
