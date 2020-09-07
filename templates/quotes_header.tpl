<div class="header">
<span class="left"><b><{$smarty.const.MD_QUOTES_TITLE}></b>&#58;&#160;</span>
<span class="left"><{$smarty.const.MD_QUOTES_DESC}></span><br>
</div>
<div class="head">
    <{if $adv != ''}>
        <div class="center"><{$adv}></div>
    <{/if}>
</div>
<br>
<ul class = "nav nav-pills">
                 <li class = "active"><a href="<{$quotes_url}>"><{$smarty.const.MD_QUOTES_INDEX}></a></li>

            <li><a href="<{$quotes_url}>/quote.php"><{$smarty.const.MD_QUOTES_QUOTE}></a></li>
            <li><a href="<{$quotes_url}>/category.php"><{$smarty.const.MD_QUOTES_CATEGORY}></a></li>
            <li><a href="<{$quotes_url}>/author.php"><{$smarty.const.MD_QUOTES_AUTHOR}></a></li>
 </ul>

 <br>